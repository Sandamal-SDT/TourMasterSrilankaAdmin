<?php


class Model_user extends CI_Model {

    var $details;

    function  getModelDetails(){
        $modelDetails['table']="user";
        $modelDetails['cols']=array("user_Id","user_Name","user_Pass_Word","user_Type");

        return $modelDetails;
    }

    function validate_user( $userName, $password ) {
        // Build a query to retrieve the user's details
        // based on the received username and password
        $this->db->from('user');
        $this->db->where('user_Name',$userName );
        $this->db->where( 'user_Pass_Word', sha1($password) );
        $login = $this->db->get()->result();

        // The results of the query are stored in $login.
        // If a value exists, then the user account exists and is validated
        if ( is_array($login) && count($login) == 1 ) {
            // Set the users details into the $details property of this class
            $this->details = $login[0];
            // Call set_session to set the user's session vars via CodeIgniter
            $this->set_session();
            return true;
        }

        return false;
    }

    function set_session() {
        // session->set_userdata is a CodeIgniter function that
        // stores data in CodeIgniter's session storage.  Some of the values are built in
        // to CodeIgniter, others are added.  See CodeIgniter's documentation for details.
        $this->session->set_userdata( array(
                'UserId'=>$this->details->user_Id,
                'UserName'=> $this->details->user_Name,
                'isLoggedIn'=>true,
                'userType'=>$this->details->user_Type
            )
        );
    }

    public function getUsers()
    {
        $cols=$this->getModelDetails()['cols'];
        $table=$this->getModelDetails()['table'];

        $this->db->select($cols[0].','.$cols[1].','.$cols[2].','.$cols[3]);
        $this->db->from($table);
        $query= $this->db->get();
        $data=$this->convertUserTypes($query->result());

        $error=$this->db->error();
        $stat['statFlag']=$data?1:0;
        $stat['message']=$data?"succeeded ...":"no record found";

        $ret['stat']=$stat;
        if($stat['statFlag']==1)
            $ret['data']=$this->arrayCastRecursive($data);

        return $ret;
    }

    public function getUser($userId=-1){
        $cols=$this->getModelDetails()['cols'];
        $table=$this->getModelDetails()['table'];

        $query = $this->db->get_where($table, array($cols[0] => $userId));
        $data=$this->convertUserTypes($query->result());

        $error=$this->db->error();
        $stat['statFlag']=$data?1:0;
        $stat['message']=$data?"loaded ...":"no record found";


        $ret['stat']=$stat;
        if($stat['statFlag']==1)
            $ret['data']=$data[0];

        return $ret;
    }

    public function getUserSearch($userName){

        $cols=$this->getModelDetails()['cols'];
        $table=$this->getModelDetails()['table'];

        $this->db->select($cols[0].','.$cols[1].','.$cols[2].','.$cols[3]);
        $this->db->from($table);
        $this->db->like($cols[1], $userName);
        $query= $this->db->get();

        $data=$this->convertUserTypes($query->result());

        $error=$this->db->error();
        $stat['statFlag']=$data?1:0;
        $stat['message']=$data?"loaded ...":"no record found";


        $ret['stat']=$stat;
        if($stat['statFlag']==1)
            $ret['data']=$this->arrayCastRecursive($data);

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

    public function updateUser($id,$name,$password,$type)
    {
        $cols=$this->getModelDetails()['cols'];
        $table=$this->getModelDetails()['table'];

        $data = array($cols[1]=>$name, $cols[2]=>sha1($password), $cols[3]=>$type);

        //print_r($data);
        if($id!=-1){//update
            $this->db->where($cols[0], $id);
            return($this->db->update($table,$data));
        }
        else {//insert
            return($this->db->insert($table,$data));
        }
    }


    /*
     * converting user types int -> string
     */
    function convertUserTypes($array){
        if (is_array($array)) {
            foreach($array as $row){
                $row->user_TypeId = $row->user_Type;
                if($row->user_Type == 0)
                    $row->user_Type="Super Admin";
                elseif($row->user_Type==1)
                    $row->user_Type="Admin";
                elseif($row->user_Type==2)
                    $row->user_Type="Office";
                elseif($row->user_Type==3)
                    $row->user_Type="ViewOnly";
            }
        }
        return $array;
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
