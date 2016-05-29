<?php
/**
 * Created by PhpStorm.
 * User: cHiN
 * Date: 2015-09-08
 * Time: 8:26 AM
 */

class Model_extra_charges extends CI_Model{
    
    function  getModelDetails(){
        $modelDetails['originalTable']="tour_extra_charge";
        $modelDetails['table']="view_extra_charge";
        $modelDetails['cols']=array("tour_Extra_Charge_Id","tour_Extra_Charge_Tour_Enrolment_Id","tour_Extra_Charge_Description","tour_Extra_Charge_Extra_charge"
        ,"customer_First_Name");
        return $modelDetails;
    }

    public function getExtraCharges()
    {
        $cols=$this->getModelDetails()['cols'];
        $table=$this->getModelDetails()['table'];

        $this->db->select($cols[0].','.$cols[1].','.$cols[2].','.$cols[3].','.$cols[4]);
        $this->db->from($table);
        $query= $this->db->get();
        $data=$query->result();

        $processed=$this->convertToGridData($data);

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
        
        
        return $ret;
    }

    public function getExtraChargesSearch($tourCustomer){

        $cols=$this->getModelDetails()['cols'];
        $table=$this->getModelDetails()['table'];

        $this->db->select($cols[0].','.$cols[1].','.$cols[2].','.$cols[3].','.$cols[4]);
        $this->db->from($table);
        $this->db->like($cols[4], $tourCustomer);
        $query= $this->db->get();

        $data=$query->result();
        $processed=$this->convertToGridData($data);

        $stat['statFlag']=$data?1:0;
        $stat['message']=$data?"loaded ...":"no record found";


        $ret['stat']=$stat;
        if($stat['statFlag']==1)
            $ret['data']=$this->arrayCastRecursive($processed);

        return $ret;
    }

    public function getExtraCharge($extraChargeId=-1){
        $cols=$this->getModelDetails()['cols'];
        $table=$this->getModelDetails()['table'];

        $query = $this->db->get_where($table, array($cols[0] => $extraChargeId));
        $data=$query->result();

        $stat['statFlag']=$data?1:0;
        $stat['message']=$data?"loaded ...":"no record found";

        $processed=$this-> convertToViewData($data[0]);

        $ret['stat']=$stat;
        if($stat['statFlag']==1)
            $ret['data']=$processed;

        return $ret;
    }


    public function getExtraChargesForEdit($tourId){
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


        $stat['statFlag']=$data?1:0;
        $stat['message']=$data?"loaded ...":"no record found";

        $ret['stat']=$stat;
        if($stat['statFlag']==1)
            $ret['data']=$data;

        return $ret;
    }


    public function updateExtraCharges($tour_Extra_Charge_Id,$tour_Extra_Charge_Tour_Enrolment_Id,$tour_Extra_Charge_Description,$tour_Extra_Charge_Extra_charge)
    {
        //tour_Extra_Charge_Id,tour_Extra_Charge_Tour_Enrolment_Id,tour_Extra_Charge_Description,tour_Extra_Charge_Extra_charge
        $cols=$this->getModelDetails()['cols'];
        $table=$this->getModelDetails()['originalTable'];

        $data = array($cols[1]=>$tour_Extra_Charge_Tour_Enrolment_Id,$cols[2]=>$tour_Extra_Charge_Description,$cols[3]=>$tour_Extra_Charge_Extra_charge);

        //print_r($data);

        if($tour_Extra_Charge_Id!=-1){//update
            $this->db->where($cols[0], $tour_Extra_Charge_Id);
            return($this->db->update($table,$data));
        }
        else {//insert
            return($this->db->insert($table,$data));
        }
    }

    //concatenating tour enrolment id and customer name
    function convertToGridData($rowData){

        $processed=array();
        if(isset($rowData)){
            foreach($rowData as $row){
                $temp["tour_Extra_Charge_Id"]=$row->tour_Extra_Charge_Id;
                $temp["tour_Extra_Charge_Tour_Enrolment_Id"]=$row->tour_Extra_Charge_Tour_Enrolment_Id." -> ".$row->customer_First_Name;
                $temp["tour_Extra_Charge_Description"]=$row->tour_Extra_Charge_Description;
                $temp["tour_Extra_Charge_Extra_charge"]=$row->tour_Extra_Charge_Extra_charge;
                array_push($processed,$temp);
            }
        }
        return $processed;
    }

    function convertToViewData($rawData){
        $processed=new stdClass();
        if(isset($rawData)){
            $processed->tour_Extra_Charge_Id=$rawData->tour_Extra_Charge_Id;
            $processed->tour_Extra_Charge_Tour_Enrolment_Id=$rawData->tour_Extra_Charge_Tour_Enrolment_Id." -> ".$rawData->customer_First_Name;
            $processed->tour_Extra_Charge_Description=$rawData->tour_Extra_Charge_Description;
            $processed->tour_Extra_Charge_Extra_charge=$rawData->tour_Extra_Charge_Extra_charge;
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