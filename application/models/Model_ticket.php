<?php
/**
 * Created by PhpStorm.
 * User: cHiN
 * Date: 2015-09-08
 * Time: 8:26 AM
 */

class Model_ticket extends CI_Model{
    
    function  getModelDetails(){
        $modelDetails['table']="ticket";
        $modelDetails['cols']=array("ticket_Id","ticket_Name","ticket_Description","ticket_Price");
        return $modelDetails;
    }

    public function getTickets()
    {
        $cols=$this->getModelDetails()['cols'];
        $table=$this->getModelDetails()['table'];

        $this->db->select($cols[0].','.$cols[1].','.$cols[2].','.$cols[3]);
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

    public function getTicketSearch($ticket_Name){

        $cols=$this->getModelDetails()['cols'];
        $table=$this->getModelDetails()['table'];

        $this->db->select($cols[0].','.$cols[1].','.$cols[2].','.$cols[3]);
        $this->db->from($table);
        $this->db->like($cols[1], $ticket_Name);
        $query= $this->db->get();

        $data=$query->result();

        $stat['statFlag']=$data?1:0;
        $stat['message']=$data?"loaded ...":"no record found";


        $ret['stat']=$stat;
        if($stat['statFlag']==1)
            $ret['data']=$this->arrayCastRecursive($data);

        return $ret;
    }

    public function getTicket($extraChargeId=-1){
        $cols=$this->getModelDetails()['cols'];
        $table=$this->getModelDetails()['table'];

        $query = $this->db->get_where($table, array($cols[0] => $extraChargeId));
        $data=$query->result();

        $stat['statFlag']=$data?1:0;
        $stat['message']=$data?"loaded ...":"no record found";

        $ret['stat']=$stat;
        if($stat['statFlag']==1)
            $ret['data']=$data;

        return $ret;
    }


    public function getTicketForEdit($ticketId){
        $cols=$this->getModelDetails()['cols'];
        $table=$this->getModelDetails()['table'];
        $query = $this->db->get_where($table, array($cols[0] => $ticketId));
        $data=$query->result();

        $stat['statFlag']=$data?1:0;
        $stat['message']=$data?"loaded ...":"no record found";

        $ret['stat']=$stat;
        if($stat['statFlag']==1)
            $ret['data']=$data;

        return $ret;
    }


    public function updateTicket($ticket_Id ,$ticket_Name ,$ticket_Description ,$ticket_Price)
    {
        $cols=$this->getModelDetails()['cols'];
        $table=$this->getModelDetails()['table'];

        $data = array($cols[1]=>$ticket_Name,$cols[2]=>$ticket_Description,$cols[3]=>$ticket_Price);

        //print_r($data);

        if($ticket_Id!=-1){//update
            $this->db->where($cols[0], $ticket_Id);
            return($this->db->update($table,$data));
        }
        else {//insert
            return($this->db->insert($table,$data));
        }
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