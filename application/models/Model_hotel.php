<?php
/**
 * Created by PhpStorm.
 * User: cHiN
 * Date: 2015-09-06
 * Time: 11:48 PM
 */

class Model_hotel extends CI_Model{

    function  getModelDetails(){
        $modelDetails['table']="hotel";
        $modelDetails['cols']=array("hotel_Id","hotel_Name","hotel_Contact_Person","hotel_Telephone","hotel_Address","hotel_Location","hotel_Website","hotel_Email","hotel_Bank_Account_Number","hotel_Bank_Name","hotel_Bank_Branch","hotel_Inspection_Rate","hotel_Contract_Expire_Date","hotel_Comments","hotel_ExtraTelephone","hotel_ExtraEmail","hotel_Bank_Account_Name");

        $modelDetails['table2']="room";
        $modelDetails['cols2']=array("room_Id","room_Hotel_Id","room_Price","room_Type","room_Accommodation_Type","room_Comments");

        $modelDetails['table3']="view_tour_en_hotels";
        $modelDetails['cols3']=array("tour_Enrolment_Id","hotel_Id","hotel_Name","hotel_Contact_Person","hotel_Telephone","hotel_Address","hotel_Location","hotel_Website","hotel_Email","hotel_Bank_Account_Number","hotel_Bank_Name","hotel_Bank_Branch","hotel_Inspection_Rate","hotel_Contract_Expire_Date","hotel_Comments","hotel_ExtraTelephone","hotel_ExtraEmail","hotel_Bank_Account_Name");

        return $modelDetails;
    }

    public function getHotels()
    {
        $cols=$this->getModelDetails()['cols'];
        $table=$this->getModelDetails()['table'];

        $this->db->select($cols[0].','.$cols[1].','.$cols[5].','.$cols[3].','.$cols[2].','.$cols[11]);
        $this->db->from($table);
        $query= $this->db->get();
        $data=$query->result();

        $error=$this->db->error();
        $stat['statFlag']=$data?1:0;
        $stat['message']=$data?"succeeded ...":"no record found";

        $ret['stat']=$stat;
        if($stat['statFlag']==1)
            $ret['data']=$this->arrayCastRecursive($data);

        return $ret;
    }

    public function getHotelSearch($hotelLocation){

        $cols=$this->getModelDetails()['cols'];
        $table=$this->getModelDetails()['table'];

        $this->db->select($cols[0].','.$cols[1].','.$cols[5].','.$cols[3].','.$cols[2].','.$cols[11]);
        $this->db->from($table);
        $this->db->like($cols[5], $hotelLocation);
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

    public function getHotel($hotelId=-1){
        $cols=$this->getModelDetails()['cols'];
        $table=$this->getModelDetails()['table'];

        $query = $this->db->get_where($table, array($cols[0] => $hotelId));
        $data=$query->result();

        $error=$this->db->error();
        $stat['statFlag']=$data?1:0;
        $stat['message']=$data?"loaded ...":"no record found";


        $ret['stat']=$stat;
        if($stat['statFlag']==1)
            $ret['data']=$data[0];

        return $ret;
    }

    public function getHotelsPerTourEnrolement($tourEnId=-1){
        $cols=$this->getModelDetails()['cols3'];
        $table=$this->getModelDetails()['table3'];

        $query = $this->db->get_where($table, array($cols[0] => $tourEnId));
        $data=$query->result();

        $error=$this->db->error();
        $stat['statFlag']=$data?1:0;
        $stat['message']=$data?"loaded ...":"no record found";


        $ret['stat']=$stat;
        if($stat['statFlag']==1)
            $ret['data']=$data;

        return $ret;
    }

    public function updateHotel($id, $name, $contact,$telephone,$hotel_Address,$loc, $web, $email, $bankAcc,$bank,$bankBranch,$iRate,$expire,$hotel_Comments,$hotel_ExtraTelephone,$hotel_ExtraEmail,$hotel_Bank_Account_Name)
    {
        $cols=$this->getModelDetails()['cols'];
        $table=$this->getModelDetails()['table'];

        $data = array($cols[1]=>$name, $cols[2]=>$contact, $cols[3]=>$telephone,$cols[4]=>$hotel_Address, $cols[5]=>$loc, $cols[6]=>$web, $cols[7]=>$email, $cols[8]=>$bankAcc, $cols[9]=>$bank, $cols[10]=>$bankBranch, $cols[11]=>$iRate, $cols[12]=>$expire, $cols[13]=>$hotel_Comments, $cols[14]=>$hotel_ExtraTelephone, $cols[15]=>$hotel_ExtraEmail, $cols[16]=>$hotel_Bank_Account_Name);

        //print_r($data);

        if($id!=-1){//update
            $this->db->where($cols[0], $id);
            return($this->db->update($table,$data));
        }
        else {//insert
            return($this->db->insert($table,$data));
        }
    }


    public function getRoomForHotel($hotelId){
        $cols=$this->getModelDetails()['cols'];
        $table=$this->getModelDetails()['table'];

        $query = $this->db->get_where($table, array($cols[0] => $hotelId));
        $data=$query->result();

        //hotel room details
        $cols2=$this->getModelDetails()['cols2'];
        $table2=$this->getModelDetails()['table2'];

        $query2 = $this->db->get_where($table2, array($cols2[1] => $hotelId));
        $data2=$query2->result();

        $stat['statFlag']=$data?1:0;
        $stat['message']=$data?"loaded ...":"no record found";

        $ret['stat']=$stat;
        if($stat['statFlag']==1){
            $ret['hotelDetails']=$data;
            $ret['roomDetails']=$data2;
        }
        return $ret;
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