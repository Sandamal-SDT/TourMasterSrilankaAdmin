<?php
/**
 * Created by PhpStorm.
 * User: cHiN
 * Date: 2015-09-08
 * Time: 8:26 AM
 */

class Model_tour extends CI_Model{
    
    function  getModelDetails(){
        $modelDetails['originalTable']="tour";
        $modelDetails['table']="view_tour";
        $modelDetails['drverNote']="view_tour_driver_note";
        $modelDetails['cols']=array("tour_Id","tour_Tour_Enrolment_Id","tour_Start_Date","tour_End_Date","tour_Room_Id",
            "customer_First_Name","hotel_Name","tour_Number_Of_Rooms","customer_Last_Name");
        return $modelDetails;
    }

    public function getTours()
    {
        $cols=$this->getModelDetails()['cols'];
        $table=$this->getModelDetails()['table'];

        $this->db->select(/*$cols[0].','.$cols[1].','.$cols[2].','.$cols[3].','.$cols[4].','.$cols[5].','.$cols[6].','.$cols[7].','.$cols[8]*/);
        $this->db->from($table);
        $query= $this->db->get();
        $data=$query->result();

        $processed=$this->convertToGridData($data);

        $error=$this->db->error();
        $stat['statFlag']=$data?1:0;
        $stat['message']=$data?"succeeded ...":"no record found";

        $ret['stat']=$stat;
        if($stat['statFlag']==1)
            $ret['data']=$this->arrayCastRecursive($processed);

        //getting enrolled customers
        $this->db->select("tour_Enrolment_Id,customer_First_Name");
        $this->db->from("view_tour_customer");
        $query= $this->db->get();
        $enCustomer=$query->result();
        $enCustomerList=$this->toIdArray($enCustomer,'tour_Enrolment_Id','tour_Enrolment_Id','customer_First_Name');
        $ret['enCustomerList']=$enCustomerList;

        //getting hotel rooms
        $this->db->select("room_Id,hotel_Name");
        $this->db->from("view_tour_room");
        $roomHotel= $this->db->get()->result();
        $enRoomList=$this->toIdArray($roomHotel,'room_Id','room_Id','hotel_Name');
        $ret['enRoomList']=$enRoomList;

        //getting hotel locations
        $this->db->select("hotel_Location");
        $this->db->from("view_tour_location");
        $enLocationList= $this->db->get()->result();
        $ret['enLocationList']=$enLocationList;

        return $ret;
    }

    public function getTourSearch($tourCustomer){

        $cols=$this->getModelDetails()['cols'];
        $table=$this->getModelDetails()['table'];

        $this->db->select($cols[0].','.$cols[1].','.$cols[2].','.$cols[3].','.$cols[4].','.$cols[5].','.$cols[6].','.$cols[7]);
        $this->db->from($table);
        $this->db->like($cols[5], $tourCustomer);
        $query= $this->db->get();

        $data=$query->result();
        $processed=$this->convertToGridData($data);

        $error=$this->db->error();
        $stat['statFlag']=$data?1:0;
        $stat['message']=$data?"loaded ...":"no record found";


        $ret['stat']=$stat;
        if($stat['statFlag']==1)
            $ret['data']=$this->arrayCastRecursive($processed);

        return $ret;
    }

    public function getHotelsForLocation($location){

        $this->db->select('hotel_Id,hotel_Name');
        $this->db->from('hotel');
        $this->db->like('hotel_Location', $location);
        $query= $this->db->get();

        $data=$query->result();

        $stat['statFlag']=$data?1:0;
        $stat['message']=$data?"loaded ...":"no record found";

        $ret['stat']=$stat;
        $ret['title']="Hotel";
        if($stat['statFlag']==1)
            $ret['data']=$this->toIdArray($data,'hotel_Id','hotel_Id','hotel_Name');
        return $ret;
    }

    public function getRoomsForHotel($hotel){

        $this->db->select('room_Id,room_Type,room_Accommodation_Type');
        $this->db->from('room');
        $this->db->where('room_Hotel_Id', $hotel);
        $query= $this->db->get();
        $data=$query->result();

        $stat['statFlag']=$data?1:0;
        $stat['message']=$data?"loaded ...":"no record found";

        $ret['stat']=$stat;
        $ret['title']="Room";
        if($stat['statFlag']==1)
            $ret['data']=$this->toIdArray($data,'room_Id','room_Type','room_Accommodation_Type');
        return $ret;
    }

    public function getTour($tourId=-1){
        $cols=$this->getModelDetails()['cols'];
        $table=$this->getModelDetails()['table'];

        $query = $this->db->get_where($table, array($cols[0] => $tourId));
        $data=$query->result();

        $stat['statFlag']=$data?1:0;
        $stat['message']=$data?"loaded ...":"no record found";

        $processed=$this-> convertToViewData($data[0]);

        $ret['stat']=$stat;
        if($stat['statFlag']==1)
            $ret['data']=$processed;

        return $ret;
    }


    public function getTourForEdit($tourId){
        $cols=$this->getModelDetails()['cols'];
        $table=$this->getModelDetails()['originalTable'];
        $query = $this->db->get_where($table, array($cols[0] => $tourId));
        $data=$query->result();

        //getting enrolled customers
        $this->db->select("tour_Enrolment_Id,customer_First_Name");
        $this->db->from("view_tour_customer");
        $query= $this->db->get();
        $enCustomer=$query->result();
        $enCustomerList=$this->toIdArray($enCustomer,'tour_Enrolment_Id','tour_Enrolment_Id','customer_First_Name');
        $data['enCustomerList']=$enCustomerList;

        //getting hotel rooms
        $this->db->select("room_Id,hotel_Name");
        $this->db->from("view_tour_room");
        $roomHotel= $this->db->get()->result();
        $enRoomList=$this->toIdArray($roomHotel,'room_Id','room_Id','hotel_Name');
        $data['enRoomList']=$enRoomList;

        //getting hotel locations
        $this->db->select("hotel_Location");
        $this->db->from("view_tour_location");
        $enLocationList= $this->db->get()->result();
        $data['enLocationList']=$enLocationList;

        $error=$this->db->error();
        $stat['statFlag']=$data?1:0;
        $stat['message']=$data?"loaded ...":"no record found";

        $ret['stat']=$stat;
        if($stat['statFlag']==1)
            $ret['data']=$data;

        return $ret;
    }


    public function updateTour($id,$tour_Enrolment_Id,$tour_Start_Date,$tour_End_Date,$tour_Room_Id,$tour_Number_Of_Rooms)
    {
        $cols=$this->getModelDetails()['cols'];
        $table=$this->getModelDetails()['originalTable'];

        $data = array($cols[1]=>$tour_Enrolment_Id,$cols[2]=>$tour_Start_Date,$cols[3]=>$tour_End_Date,
            $cols[4]=>$tour_Room_Id,$cols[7]=>$tour_Number_Of_Rooms);

        //print_r($data);
        //$modelDetails['cols']=array("tour_Id","tour_Tour_Enrolment_Id","tour_Start_Date","tour_End_Date","tour_Room_Id",
        //"customer_First_Name","hotel_Name","tour_Number_Of_Rooms");

        if($id!=-1){//update
            $this->db->where($cols[0], $id);
            return($this->db->update($table,$data));
        }
        else {//insert
            return($this->db->insert($table,$data));
        }
    }

    public function getTourForDriverNote($tourId){
        $cols=array("tour_Id","tour_Start_Date","tour_End_Date","room_Id","hotel_Id",
            "hotel_Address","hotel_Telephone","hotel_Name","hotel_Location","room_Type","room_Accommodation_Type","tour_Enrolment_Number_Of_Persons"
        ,"tour_Enrolment_Number_Of_Children","tour_Enrolment_Id","customer_Id","customer_First_Name","customer_Last_Name","hotel_Email","tour_Number_Of_Rooms","hotel_ExtraEmail");

        $table=$this->getModelDetails()['drverNote'];

        $query = $this->db->get_where($table, array($cols[0] => $tourId));
        $data=$query->result();

        $stat['statFlag']=$data?1:0;
        $stat['message']=$data?"loaded ...":"no record found";

        $ret['stat']=$stat;
        if($stat['statFlag']==1)
            $ret['data']=$data;

        return $ret;
    }

    //concatenating tour enrolment id and customer name
    function convertToGridData($rowData){
        $processed=array();
        if(isset($rowData)){
            foreach($rowData as $row){
                $temp["tour_Id"]=$row->tour_Id;
                $temp["hotel_Name"]=$row->hotel_Name;
                $temp["tour_Tour_Enrolment_Id"]=$row->tour_Tour_Enrolment_Id." -> ".$row->customer_First_Name;
                $temp["tour_Start_Date"]=$row->tour_Start_Date;
                $temp["tour_End_Date"]=$row->tour_End_Date;
                array_push($processed,$temp);
            }
        }
        return $processed;
    }

    function convertToViewData($rawData){
        $processed=new stdClass();
        if(isset($rawData)){
            $processed->tour_Id=$rawData->tour_Id;
            $processed->hotel_Name=$rawData->hotel_Name;
            $processed->tour_Enrolment_Id=$rawData->tour_Tour_Enrolment_Id." -> ".$rawData->customer_First_Name;
            $processed->tour_Start_Date=$rawData->tour_Start_Date;
            $processed->tour_End_Date=$rawData->tour_End_Date;
            $processed->tour_Room_Id=$rawData->tour_Room_Id." -> ".$rawData->hotel_Name;
            $processed->tour_Number_Of_Rooms=$rawData->tour_Number_Of_Rooms;
        }
        return $processed;
    }

    //converts data result to id array (db ID vise indexed array)
    function toIdArray($inArray,$idField,$valueField1,$valueField2){
        if(isset($inArray)) {
            foreach ($inArray as $row) {
                $outArray[$row->$idField]=$row->$valueField1." -> ".$row->$valueField2;
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