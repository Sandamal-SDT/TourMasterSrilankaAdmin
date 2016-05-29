<?php


class Model_customer extends CI_Model {

    public function getCustomers()
	{
		$query= $this->db->get('customer');
        $data=$query->result();

        $error=$this->db->error();
        $stat['statFlag']=$data?1:0;
        $stat['message']=$data?"succeeded ...":"no record found";

        $ret['stat']=$stat;
        $ret['data']=$this->arrayCastRecursive($data);

        return $ret;
    }

	public function getCustomerSearch($customerName){

        $this->db->select('*');
        $this->db->from('customer');
        $this->db->like('customer_First_Name', $customerName);
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

    public function getCustomer($customerId=-1){
        $query = $this->db->get_where('customer', array('customer_Id' => $customerId));
        $data=$query->result();

        $error=$this->db->error();
        $stat['statFlag']=$data?1:0;
        $stat['message']=$data?"loaded ...":"no record found";


        $ret['stat']=$stat;
        if($stat['statFlag']==1)
            $ret['data']=$data[0];

        return $ret;
    }


    public function updateCustomer($id, $name, $country, $email,$cusLName,$cusDob,$cusAddr,$cusTp,$cusBloodType,$cusComment,$cusExtraTelephone,$cusEmergencyTelephone)
    {
        $data = array('customer_First_Name'=>$name, 'customer_Country'=>$country, 'customer_Email'=>$email
        ,'customer_Last_Name'=>$cusLName, 'customer_Dob'=>$cusDob, 'customer_Address'=>$cusAddr,'customer_Telephone'=>$cusTp
        , 'customer_Blood_Group'=>$cusBloodType,'customer_Comments'=>$cusComment
        , 'customer_ExtraTelephone'=>$cusExtraTelephone,'customer_EmergencyTelephone'=>$cusEmergencyTelephone);

        if($id!=-1){//update
            $this->db->where('customer_Id', $id);
            return($this->db->update('customer',$data));
        }
        else {//insert
            return($this->db->insert('customer',$data));
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

    /*
     * convert stdClass object to array
     * http://carlofontanos.com/convert-stdclass-object-to-array-in-php/
    */
    function cvf_convert_object_to_array($data) {

        if (is_object($data)) {
            $data = get_object_vars($data);
        }

        if (is_array($data)) {
            return array_map(__FUNCTION__, $data); //recursive
        }
        else {
            return $data;
        }
    }

}
