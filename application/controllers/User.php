<?php
/**
 * Created by PhpStorm.
 * User: cHiN
 * Date: 2015-09-06
 * Time: 11:46 PM
 */

class User extends CI_Controller{

    //hotel_Id,hotel_Name,hotel_Telephone,hotel_Address,hotel_Inspection_rate,hotel_Bank_Account_Number

    function __construct(){
        parent::__construct();
        validateUser();
        if(!$this->session->userdata('userType') == 0)
            redirect('/access_denied');
        $this->load->model('Model_user','modelUser');
    }

    function getGridSettings(){
        $gridHeader=array("ID","User Name","User Type","Actions"); //grid header
        $gridDataFeilds=array("user_Id", "user_Name","user_Type"); //data binding

        if(validateEdit()) {
            //sends command names,javascript function,address
            $gridActions = array(array("view", "edit"), array("getView", "getEdit"),
                array("index.php/user/viewData", "index.php/user/editData"));
        }else{
            $gridActions = array(array("view"), array("getView"),
                array("index.php/user/viewData"));
        }

        $gridData['gridHeader']=$gridHeader;
        $gridData['gridDataFeilds']=$gridDataFeilds;
        $gridData['actions']=$gridActions;

        return $gridData;
    }


    function index() {
        $this->showData();
    }

    public function showData() {

        $controlData=$this->modelUser->getUsers();
        $gridData=$this->getGridSettings();

        if(isset($controlData['data']))
            $gridData['data']=$controlData['data'];

        $sendData['gridData']=$gridData;
        $sendData['ctrlData']=$controlData['stat'];

        $this->load->view('user/viewUser',$sendData);
    }

    public function viewData($userId){
        $result['controlData']=$this->modelUser->getUser($userId);
        $this->load->view('user/viewUserView',$result);
    }

    public function getSearchGrid(){
        if(isset($_POST['userName'])){
            $controlData=$this->modelUser->getUserSearch($_POST['userName']);

            $gridData=$this->getGridSettings();
            if(isset($controlData['data']))
                $gridData['data']=$controlData['data'];

            $this->load->view('tools/grid',$gridData);
        }
    }

    public function editData($userId){
        $result['controlData']=$this->modelUser->getUser($userId);
        $this->load->view('user/viewUserEdit',$result);
    }

    public function saveData($isInsert)
    {
        $this->load->helper(array('form', 'url'));
        $this->load->library('form_validation');

        $stat['statFlag']=0;
        $stat['message']="";

        if (isset($_POST['user_Id']))
        {
            $id=$_POST['user_Id'];
            $name=$_POST['user_Name'];
            $password=$_POST['user_Password'];
            $type=$_POST['user_Type'];

            $result=$this->modelUser->updateUser($id, $name,$password,$type);
            if($result)
            {
                //ok
                $stat['statFlag']=1;
                $stat['message']=$name." : ".$isInsert==0?"Successfully Updated":"Successfully Inserted";
                $this->load->view('tools/loader',$stat);
            }
            else {

                //db error
                $error=$this->db->error();
                $stat['statFlag']=0;
                $stat['message']="Db Error ".$error->code." : ".$error->message;
                $this->load->view('tools/loader',$stat);
            }

        }
        else {
            $stat['statFlag']=0;
            $stat['message']="Wrong parameters";
            $this->load->view('tools/loader',$stat);
        }

    }

    public function loadAjaxGrid(){
        $controlData=$this->modelUser->getUsers();
        $gridData=$this->getGridSettings();

        if(isset($controlData['data']))
            $gridData['data']=$controlData['data'];

        $this->load->view('tools/grid',$gridData);
    }

} 