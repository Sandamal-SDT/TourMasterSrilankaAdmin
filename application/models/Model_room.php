<?php
/**
 * Created by PhpStorm.
 * User: cHiN
 * Date: 2015-09-06
 * Time: 11:48 PM
 */

class Model_room extends CI_Model{

    function  getModelDetails(){
        $modelDetails['table']="view_room";
        $modelDetails['cols']=array("room_Id","room_Hotel_Id","room_Type","room_Price","hotel_Name","room_Accommodation_Type","room_Comments");
        $modelDetails['table2']="tour_seasons";
        $modelDetails['cols2']=array("tour_Season_Id","tour_Season_Start_Date","tour_Season_End_Date","tour_Season_Price","tour_Season_Room_Id");
        return $modelDetails;
    }

    public function getRooms()
    {
        $cols=$this->getModelDetails()['cols'];
        $table=$this->getModelDetails()['table'];

        $this->db->select($cols[0].','.$cols[4].','.$cols[2].','.$cols[3]);
        $this->db->from($table);
        $query= $this->db->get();
        $data=$query->result();

        $error=$this->db->error();
        $stat['statFlag']=$data?1:0;
        $stat['message']=$data?"succeeded ...":"no record found";

        $ret['stat']=$stat;
        if($stat['statFlag']==1)
            $ret['data']=$this->arrayCastRecursive($data);

        //hotels for combobox
        $this->db->select('hotel_Id,hotel_Name');
        $this->db->from('hotel');
        $hotelData= $this->db->get()->result();
        $hotelList=$this->toIdArray($hotelData,'hotel_Id','hotel_Name');
        //print_r($hotelList);
        $ret['hotelList']=$hotelList;


        return $ret;
    }

    public function getRoomsearch($roomType){

        $cols=$this->getModelDetails()['cols'];
        $table=$this->getModelDetails()['table'];

        $this->db->select($cols[0].','.$cols[4].','.$cols[3].','.$cols[2]);
        $this->db->from($table);
        $this->db->like($cols[2], $roomType);
        $query= $this->db->get();

        $data=$query->result();

        $error=$this->db->error();
        $stat['statFlag']=$data?1:0;
        $stat['message']=$data?"loaded ...":"no record found";


        $ret['stat']=$stat;
        if($stat['statFlag']==1)
            $ret['data']=$this->arrayCastRecursive($data);

        return $ret;
    }

    public function getRoom($roomId=-1){
        $cols=$this->getModelDetails()['cols'];
        $table=$this->getModelDetails()['table'];

        $query = $this->db->get_where($table, array($cols[0] => $roomId));
        $data=$query->result();

        $error=$this->db->error();
        $stat['statFlag']=$data?1:0;
        $stat['message']=$data?"loaded ...":"no record found";


        $ret['stat']=$stat;
        if($stat['statFlag']==1)
            $ret['data']=$data[0];

        return $ret;
    }


    public function getRoomForEdit($roomId){
        $cols=$this->getModelDetails()['cols'];
        $table=$this->getModelDetails()['table'];
        $cols2=$this->getModelDetails()['cols2'];
        $table2=$this->getModelDetails()['table2'];

        $query = $this->db->get_where($table, array($cols[0] => $roomId));
        $data=$query->result();

        /*
        $this->db->select('hotel_Id,hotel_Name');
        $this->db->from('hotel');
        $hotelData= $this->db->get()->result();
        $hotelList=$this->toIdArray($hotelData,'hotel_Id','hotel_Name');
        //print_r($hotelList);
        $data['hotelList']=$hotelList;
        //print_r($data);
        */
        $query2 = $this->db->get_where($table2, array($cols2[4] => $roomId));
        $data2=$query2->result();


        $stat['statFlag']=1;
        $stat['message']="loaded ...";


        $ret['stat']=$stat;
        if($stat['statFlag']==1){
            $ret['data']=$data;
            $ret['seasonList']=$data2;
        }

        return $ret;
    }


    public function updateRoom($room_Id, $hotel_Id, $room_Type,$room_Price,$acco_Type,$room_Comments,$room_Seasons)
    {
        $cols=$this->getModelDetails()['cols'];
        $table=$this->getModelDetails()['table'];
        $cols2=$this->getModelDetails()['cols2'];
        $table2=$this->getModelDetails()['table2'];

        $data = array($cols[1]=>$hotel_Id, $cols[2]=>$room_Type, $cols[3]=>$room_Price,$cols[5]=>$acco_Type,$cols[6]=>$room_Comments);

        //print_r($room_Seasons);

        if($room_Id!=-1){//update
            $this->db->where($cols[0], $room_Id);
            $this->db->update($table,$data);

            //deleting and reinserting season details
            $this->db->where($cols2[4], $room_Id);
            $this->db->delete($table2);
        }
        else {//insert
            $this->db->insert($table,$data);
            $room_Id = $this->db->insert_id();
        }

        //inserting room seasons
        foreach($room_Seasons as $season){
            //echo $insert_id;
            //echo ($season["startDate"]);
            //echo ($season["endDate"]);
            //echo date_create_from_format('M/d/Y', "05/22/2016");
            //echo ($season["price"]);
            if(isset($season["price"]) && $season["price"]>0){
                $sDate= new DateTime($season["startDate"]);
                $eDate= new DateTime($season["endDate"]);

                $data2 = array($cols2[1]=>$sDate->format('Y-m-d H:i:s')
                , $cols2[2]=>$eDate->format('Y-m-d H:i:s')
                , $cols2[3]=>$season["price"]
                ,$cols2[4]=>$room_Id);
                $this->db->insert($table2,$data2);
            }
        }
    }


    //converts data result to id array (db ID vise indexed array)
    function toIdArray($inArray,$idField,$valueField){

        if(isset($inArray)) {
            foreach ($inArray as $row) {
                $outArray[$row->$idField]=$row->$valueField;
                //print_r($row->hotel_Id);
            }
        }
        return $outArray;
    }


    /*
     * convert stdClass object to array
     * http://stackoverflow.com/questions/18576762/php-stdclass-to-array
    */
    function arrayCastRecursive($array)
    {
        if (is_array($array)) {
            foreach ($array as $key => $value) {
                if (is_array($value)) {
                    $array[$key] = $this->arrayCastRecursive($value);
                }
                if ($value instanceof stdClass) {
                    $array[$key] = $this->arrayCastRecursive((array)$value);
                }
            }
        }
        if ($array instanceof stdClass) {
            return $this->arrayCastRecursive((array)$array);
        }
        return $array;
    }


} 