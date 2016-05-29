<?php
/**
 * Created by PhpStorm.
 * User: cHiN
 * Date: 2015-09-08
 * Time: 8:26 AM
 */

class Model_tour_ticket extends CI_Model{
    
    function  getModelDetails(){
        $modelDetails['table']="view_tour_ticket";
        $modelDetails['cols']=array("tour_Ticket_Id","tour_Ticket_Tour_Enrolment_Id","tour_Ticket_Ticket_Id","tour_Ticket_No_Of_Tickets","tour_Ticket_Description",
            "ticket_Name","customer_First_Name");
        return $modelDetails;
    }

    public function getTourTickets()
    {
        $cols=$this->getModelDetails()['cols'];
        $table=$this->getModelDetails()['table'];

        $this->db->select($cols[0].','.$cols[1].','.$cols[2].','.$cols[3].','.$cols[4].','.$cols[5].','.$cols[6]);
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
        $ret['enTour_enList']=$enCustomerList;

        //getting tickets
        $this->db->select("ticket_Id,ticket_Name");
        $this->db->from("ticket");
        $roomHotel= $this->db->get()->result();
        $enTicketList=$this->toIdArray($roomHotel,'ticket_Id','ticket_Id','ticket_Name');
        $ret['enTicketList']=$enTicketList;

        return $ret;
    }

    public function getTourTicketSearch($ticket_Name){

        $cols=$this->getModelDetails()['cols'];
        $table=$this->getModelDetails()['table'];

        $this->db->select($cols[0].','.$cols[1].','.$cols[2].','.$cols[3].','.$cols[4].','.$cols[5].','.$cols[6]);
        $this->db->from($table);
        $this->db->like($cols[5], $ticket_Name);
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

    public function getTourTicket($tour_Ticket_Id=-1){
        $cols=$this->getModelDetails()['cols'];
        $table=$this->getModelDetails()['table'];

        $query = $this->db->get_where($table, array($cols[0] => $tour_Ticket_Id));
        $data=$query->result();

        $stat['statFlag']=$data?1:0;
        $stat['message']=$data?"loaded ...":"no record found";

        $processed=$this-> convertToViewData($data[0]);

        $ret['stat']=$stat;
        if($stat['statFlag']==1)
            $ret['data']=$processed;

        return $ret;
    }


    public function getTourTicketForEdit($tourId){
        $cols=$this->getModelDetails()['cols'];
        $table=$this->getModelDetails()['table'];
        $query = $this->db->get_where($table, array($cols[0] => $tourId));
        $data=$query->result();

        //getting enrolled customers
        $this->db->select("tour_Enrolment_Id,customer_First_Name");
        $this->db->from("view_tour_customer");
        $query= $this->db->get();
        $enCustomer=$query->result();
        $enCustomerList=$this->toIdArray($enCustomer,'tour_Enrolment_Id','tour_Enrolment_Id','customer_First_Name');
        $data['enTour_enList']=$enCustomerList;

        //getting tickets
        $this->db->select("ticket_Id,ticket_Name");
        $this->db->from("ticket");
        $roomHotel= $this->db->get()->result();
        $enTicketList=$this->toIdArray($roomHotel,'ticket_Id','ticket_Id','ticket_Name');
        $data['enTicketList']=$enTicketList;


        $error=$this->db->error();
        $stat['statFlag']=$data?1:0;
        $stat['message']=$data?"loaded ...":"no record found";

        $ret['stat']=$stat;
        if($stat['statFlag']==1)
            $ret['data']=$data;

        return $ret;
    }


    public function updateTourTicket($tour_Ticket_Id,$tour_Ticket_Tour_Enrolment_Id,$tour_Ticket_Ticket_Id,$tour_Ticket_No_Of_Tickets,$tour_Ticket_Description)
    {
        $cols=$this->getModelDetails()['cols'];
        $table=$this->getModelDetails()['table'];

        $data = array($cols[1]=>$tour_Ticket_Tour_Enrolment_Id,$cols[2]=>$tour_Ticket_Ticket_Id,$cols[3]=>$tour_Ticket_No_Of_Tickets,
            $cols[4]=>$tour_Ticket_Description);

        //print_r($data);

        if($tour_Ticket_Id!=-1){//update
            $this->db->where($cols[0], $tour_Ticket_Id);
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
                $temp["tour_Ticket_Id"]=$row->tour_Ticket_Id;
                $temp["tour_Ticket_Tour_Enrolment_Id"]=$row->tour_Ticket_Tour_Enrolment_Id." -> ".$row->customer_First_Name;
                $temp["ticket_Name"]=$row->ticket_Name;
                $temp["tour_Ticket_No_Of_Tickets"]=$row->tour_Ticket_No_Of_Tickets;
                array_push($processed,$temp);
            }
        }
        return $processed;
    }

    function convertToViewData($rawData){
        $processed=new stdClass();
        if(isset($rawData)){
            $processed->tour_Ticket_Id=$rawData->tour_Ticket_Id;
            $processed->tour_Ticket_Tour_Enrolment_Id=$rawData->tour_Ticket_Tour_Enrolment_Id." -> ".$rawData->customer_First_Name;
            $processed->ticket_Name=$rawData->ticket_Name;
            $processed->tour_Ticket_No_Of_Tickets=$rawData->tour_Ticket_No_Of_Tickets;
            $processed->tour_Ticket_Description=$rawData->tour_Ticket_Description;
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