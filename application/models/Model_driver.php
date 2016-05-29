<?php
/**
 * Created by PhpStorm.
 * User: cHiN
 * Date: 2015-09-06
 * Time: 11:48 PM
 */

class Model_driver extends CI_Model{

    function  getModelDetails(){
        $modelDetails['table']="driver";
        $modelDetails['cols']=array("driver_Id","driver_Name","driver_Charge_Per_Date","driver_Extra_Km_Charge","driver_Nic"
        ,"driver_Licence","driver_Other_Charge","driver_Blood_Group","driver_Telephone");
        return $modelDetails;
    }

    public function getDrivers()
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

    public function getDriverSearch($driverName){

        $cols=$this->getModelDetails()['cols'];
        $table=$this->getModelDetails()['table'];

        $this->db->select($cols[0].','.$cols[1].','.$cols[2].','.$cols[3]);
        $this->db->from($table);
        $this->db->like($cols[1], $driverName);
        $query= $this->db->get();

        $data=$query->result();

        $stat['statFlag']=$data?1:0;
        $stat['message']=$data?"loaded ...":"no record found";


        $ret['stat']=$stat;
        if($stat['statFlag']==1)
            $ret['data']=$this->arrayCastRecursive($data);

        return $ret;
    }

    public function getDriver($driverId=-1){
        $cols=$this->getModelDetails()['cols'];
        $table=$this->getModelDetails()['table'];

        $query = $this->db->get_where($table, array($cols[0] => $driverId));
        $data=$query->result();

        $stat['statFlag']=$data?1:0;
        $stat['message']=$data?"loaded ...":"no record found";

        $ret['stat']=$stat;
        if($stat['statFlag']==1)
            $ret['data']=$data[0];

        return $ret;
    }


    public function getDriverForEdit($driverId){
        $cols=$this->getModelDetails()['cols'];
        $table=$this->getModelDetails()['table'];

        $query = $this->db->get_where($table, array($cols[0] => $driverId));
        $data=$query->result();


        $stat['statFlag']=$data?1:0;
        $stat['message']=$data?"loaded ...":"no record found";

        $ret['stat']=$stat;
        if($stat['statFlag']==1)
            $ret['data']=$data;

        return $ret;
    }


    public function updateDriver($driver_Id,$driver_Name,$driver_Charge_Per_Date,$driver_Extra_Km_Charge,$driver_Nic
        ,$driver_Licence,$driver_Other_Charge,$driver_Blood_Group,$driver_Telephone)
    {
        $cols=$this->getModelDetails()['cols'];
        $table=$this->getModelDetails()['table'];

        $data = array($cols[1]=>$driver_Name, $cols[2]=>$driver_Charge_Per_Date, $cols[3]=>$driver_Extra_Km_Charge
        ,$cols[4]=>$driver_Nic, $cols[5]=>$driver_Licence, $cols[6]=>$driver_Other_Charge,$cols[7]=>$driver_Blood_Group,$cols[8]=>$driver_Telephone);

        //print_r($data);

        if($driver_Id!=-1){//update
            $this->db->where($cols[0], $driver_Id);
            return($this->db->update($table,$data));
        }
        else {//insert
            return($this->db->insert($table,$data));
        }
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