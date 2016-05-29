<?php
/**
 * Created by PhpStorm.
 * User: cHiN
 * Date: 2015-09-07
 * Time: 9:02 PM
 */

class Model_tour_flow extends CI_Model{

    function  getModelDetails(){
        $modelDetails['table']="view_tour_enrolment";
        $modelDetails['cols']=array("tour_Enrolment_Id","tour_Enrolment_Customer_Id","customer_First_Name","tour_Enrolment_Driver_Id","driver_Name"
        ,"tour_Enrolment_Description","customer_Last_Name");

        $modelDetails['reportTable']="view_tour_flow";
        $modelDetails['reportCols']=array("tour_Enrolment_Id","customer_Id","customer_First_Name","customer_Country","tour_Id","tour_Number_Of_Rooms"
        ,"tour_Start_Date","tour_End_Date","driver_Id","driver_Name","room_Id","room_Price","room_Type","hotel_Id","hotel_Name","hotel_Location"
        ,"driver_Charge_Per_Date","driver_Extra_Km_Charge","tour_Enrolment_Extra_Mileage","tour_Enrolment_Description","tour_Enrolment_Number_Of_Persons");

        $modelDetails['extraChargesTable']="tour_extra_charge";
        $modelDetails['extraChargesCols']=array("tour_Extra_Charge_Id","tour_Extra_Charge_Tour_Enrolment_Id","tour_Extra_Charge_Description","tour_Extra_Charge_Extra_charge");

        //tickets
        $modelDetails['ticketsTable']="view_tour_flow_ticket";
        $modelDetails['ticketsCols']=array("tour_Enrolment_Id","ticket_Id","ticket_Name","ticket_Price","tour_Ticket_No_Of_Tickets");

        //seasons
        $modelDetails['seasonTable']="view_season_room_price";
        $modelDetails['seasonCols']=array("tour_Id","tour_Room_Id","tour_Season_Price","tour_Season_Id","tour_Season_Start_Date","tour_Season_End_Date");


        return $modelDetails;
    }

    public function getTour_ens()
    {
        $cols=$this->getModelDetails()['cols'];
        $table=$this->getModelDetails()['table'];

        $this->db->select($cols[0].','.$cols[2].','.$cols[6]);
        $this->db->from($table);
        $query= $this->db->get();
        $data=$query->result();

        $stat['statFlag']=$data?1:0;
        $stat['message']=$data?"succeeded ...":"no record found";

        $ret['stat']=$stat;
        if($stat['statFlag']==1)
            $ret['data']=$this->arrayCastRecursive($data);


        return $ret;
    }

    public function getTour_enSearch($customer){

        $cols=$this->getModelDetails()['cols'];
        $table=$this->getModelDetails()['table'];

        $this->db->select($cols[0].','.$cols[2]);
        $this->db->from($table);
        $this->db->like($cols[2], $customer);
        $query= $this->db->get();

        $data=$query->result();

        $stat['statFlag']=$data?1:0;
        $stat['message']=$data?"loaded ...":"no record found";


        $ret['stat']=$stat;
        if($stat['statFlag']==1)
            $ret['data']=$this->arrayCastRecursive($data);

        return $ret;
    }

    public function getTour_en($tour_en_Id=-1){
        $cols=$this->getModelDetails()['reportCols'];
        $table=$this->getModelDetails()['reportTable'];

        $query = $this->db->get_where($table, array($cols[0] => $tour_en_Id));
        $data=$query->result();

        //processing season
        $data = $this->getSeasonRoomPrice($data);

        //extra charges
        $cols2=$this->getModelDetails()['extraChargesCols'];
        $table2=$this->getModelDetails()['extraChargesTable'];

        $query2 = $this->db->get_where($table2, array($cols2[1] => $tour_en_Id));
        $data2=$query2->result();

        //tickets
        $cols3=$this->getModelDetails()['ticketsCols'];
        $table3=$this->getModelDetails()['ticketsTable'];

        $query3 = $this->db->get_where($table3, array($cols3[0] => $tour_en_Id));
        $data3=$query3->result();


        //status
        $stat['statFlag']=$data?1:0;
        $stat['message']=$data?"loaded ...":"no record found";


        $ret['stat']=$stat;
        if($stat['statFlag']==1){
            $ret['data']=$data;
            $ret['extra']=$data2;
            $ret['ticket']=$data3;
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


    /*
     * getting current season price
    */
    function getSeasonRoomPrice($enrolementDetailList){
        $table=$this->getModelDetails()['seasonTable'];
        $cols=$this->getModelDetails()['seasonCols'];

        foreach ($enrolementDetailList as $tour){
            $query = $this->db->get_where($table, array($cols[0] => $tour->tour_Id));
            $data=$query->result();
            if(isset($data)&&isset($data[0])){
                $tour->room_Price = $data[0]->tour_Season_Price; //setting seasonal price
            }
        }
        return $enrolementDetailList;
    }
} 