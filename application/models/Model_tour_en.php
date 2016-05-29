<?php
/**
 * Created by PhpStorm.
 * User: cHiN
 * Date: 2015-09-07
 * Time: 9:02 PM
 */

class Model_tour_en extends CI_Model{

    function  getModelDetails(){
        $modelDetails['table']="view_tour_enrolment";
        $modelDetails['cols']=array("tour_Enrolment_Id","tour_Enrolment_Customer_Id","customer_First_Name","tour_Enrolment_Driver_Id","driver_Name","tour_Enrolment_Description","tour_Enrolment_Number_Of_Persons","tour_Enrolment_Extra_Mileage","tour_Enrolment_Arrives","tour_Enrolment_Departure","tour_Enrolment_Days"
        ,"tour_Enrolment_Number_Of_Children","tour_Enrolment_Arrive_Time","customer_Last_Name");

        $modelDetails['table2']="view_tour_en_tour";
        $modelDetails['cols2']=array("tour_Enrolment_Id","tour_Id","tour_Room_Id","room_Type","room_Accommodation_Type","tour_Number_Of_Rooms","tour_Start_Date","tour_End_Date","room_Hotel_Id","hotel_Name");

        return $modelDetails;
    }

    public function getTour_ens()
    {
        $cols=$this->getModelDetails()['cols'];
        $table=$this->getModelDetails()['table'];

        $this->db->select($cols[0].','.$cols[2].','.$cols[13]);
        $this->db->from($table);
        $query= $this->db->get();
        $data=$query->result();

        $error=$this->db->error();
        $stat['statFlag']=$data?1:0;
        $stat['message']=$data?"succeeded ...":"no record found";

        $ret['stat']=$stat;
        if($stat['statFlag']==1)
            $ret['data']=$this->arrayCastRecursive($data);

        //customers for combobox
        $this->db->select('customer_Id,customer_First_Name');
        $this->db->from('customer');
        $customerData= $this->db->get()->result();
        $customerList=$this->toIdArray($customerData,'customer_Id','customer_First_Name');
        //print_r($customerList);
        $ret['customerList']=$customerList;

        //drivers for combobox
        $this->db->select('driver_Id,driver_Name');
        $this->db->from('driver');
        $driverData= $this->db->get()->result();
        $driverList=$this->toIdArray($driverData,'driver_Id','driver_Name');
        //print_r($customerList);
        $ret['driverList']=$driverList;

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

        $error=$this->db->error();
        $stat['statFlag']=$data?1:0;
        $stat['message']=$data?"loaded ...":"no record found";


        $ret['stat']=$stat;
        if($stat['statFlag']==1)
            $ret['data']=$this->arrayCastRecursive($data);

        return $ret;
    }

    public function getTour_en($tour_en_Id=-1){
        $cols=$this->getModelDetails()['cols'];
        $table=$this->getModelDetails()['table'];

        $query = $this->db->get_where($table, array($cols[0] => $tour_en_Id));
        $data=$query->result();

        $error=$this->db->error();
        $stat['statFlag']=$data?1:0;
        $stat['message']=$data?"loaded ...":"no record found";


        $ret['stat']=$stat;
        if($stat['statFlag']==1)
            $ret['data']=$data[0];

        return $ret;
    }


    public function getTour_enForEdit($tour_en_Id){
        $cols=$this->getModelDetails()['cols'];
        $table=$this->getModelDetails()['table'];

        $query = $this->db->get_where($table, array($cols[0] => $tour_en_Id));
        $data=$query->result();

        $error=$this->db->error();
        $stat['statFlag']=$data?1:0;
        $stat['message']=$data?"loaded ...":"no record found";

        //customers for combobox
        $this->db->select('customer_Id,customer_First_Name');
        $this->db->from('customer');
        $customerData= $this->db->get()->result();
        $customerList=$this->toIdArray($customerData,'customer_Id','customer_First_Name');
        //print_r($customerList);
        $data['customerList']=$customerList;

        //drivers for combobox
        $this->db->select('driver_Id,driver_Name');
        $this->db->from('driver');
        $driverData= $this->db->get()->result();
        $driverList=$this->toIdArray($driverData,'driver_Id','driver_Name');
        //print_r($customerList);
        $data['driverList']=$driverList;

        $ret['stat']=$stat;
        if($stat['statFlag']==1)
            $ret['data']=$data;

        return $ret;
    }


    public function updateTour_en($tour_en_Id,$tour_en_customer_Id,$driver_Id,$tour_Enrolment_Description,$tour_Enrolment_Number_Of_Persons,$tour_Enrolment_Extra_Mileage,
                                  $tour_Enrolment_Arrives,$tour_Enrolment_Departure,$tour_Enrolment_Days,
                                  $tour_Enrolment_Number_Of_Children,$tour_Enrolment_Arrive_Time)
    {
        $cols=$this->getModelDetails()['cols'];
        $table=$this->getModelDetails()['table'];

        $data = array($cols[1]=>$tour_en_customer_Id,$cols[3]=>$driver_Id,$cols[5]=>$tour_Enrolment_Description
        ,$cols[6]=>$tour_Enrolment_Number_Of_Persons,$cols[7]=>$tour_Enrolment_Extra_Mileage
        ,$cols[8]=>$tour_Enrolment_Arrives,$cols[9]=>$tour_Enrolment_Departure,$cols[10]=>$tour_Enrolment_Days
        ,$cols[11]=>$tour_Enrolment_Number_Of_Children,$cols[12]=>$tour_Enrolment_Arrive_Time);

        if($tour_en_Id!=-1){//update
            $this->db->where($cols[0],$tour_en_Id);
            return($this->db->update($table,$data));
        }
        else {//insert
            return($this->db->insert($table,$data));
        }
    }



    public function getTourEnWithTours($tourEnId){
        $cols=$this->getModelDetails()['cols'];
        $table=$this->getModelDetails()['table'];

        $query = $this->db->get_where($table, array($cols[0] => $tourEnId));
        $data=$query->result();

        //tour days details
        $cols2=$this->getModelDetails()['cols2'];
        $table2=$this->getModelDetails()['table2'];

        $query2 = $this->db->get_where($table2, array($cols2[0] => $tourEnId));
        $data2=$query2->result();

        $stat['statFlag']=$data?1:0;
        $stat['message']=$data?"loaded ...":"no record found";

        $ret['stat']=$stat;
        if($stat['statFlag']==1){
            $ret['tourEnDetails']=$data;
            $ret['tourDayDetails']=$data2;
        }
        return $ret;
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