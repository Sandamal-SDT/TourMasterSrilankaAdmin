<?php
/**
 * Created by PhpStorm.
 * User: cHiN
 * Date: 2015-09-06
 * Time: 11:46 PM
 */

class Hotel extends CI_Controller{

    //hotel_Id,hotel_Name,hotel_Telephone,hotel_Address,hotel_Inspection_rate,hotel_Bank_Account_Number

    function __construct(){
        parent::__construct();
        validateUser();
        $this->load->model('Model_hotel','modelHotel');
    }

    function getGridSettings(){
        $gridHeader=array("ID","Name","Location","Telephone","Inspection Rate","Actions"); //grid header
        $gridDataFeilds=array("hotel_Id", "hotel_Name","hotel_Location","hotel_Telephone","hotel_Inspection_Rate"); //data binding

        if(validateEdit()) {
            //sends command names,javascript function,address
            $gridActions = array(array("view", "edit"), array("getView", "getEdit"),
                array("index.php/hotel/viewData", "index.php/hotel/editData"));
        }else{
            $gridActions = array(array("view"), array("getView"),
                array("index.php/hotel/viewData"));
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

        $controlData=$this->modelHotel->getHotels();
        $gridData=$this->getGridSettings();

        if(isset($controlData['data']))
            $gridData['data']=$controlData['data'];

        $sendData['gridData']=$gridData;
        $sendData['ctrlData']=$controlData['stat'];

        $this->load->view('hotel/viewHotel',$sendData);
    }

    public function viewData($hotelId){
        $result['controlData']=$this->modelHotel->getHotel($hotelId);
        $this->load->view('hotel/viewHotelView',$result);
    }

    public function editData($hotelId){
        $result['controlData']=$this->modelHotel->getHotel($hotelId);
        $this->load->view('hotel/viewHotelEdit',$result);
    }


    public function saveData($isInsert)
    {
        $this->load->helper(array('form', 'url'));
        $this->load->library('form_validation');

        $stat['statFlag']=0;
        $stat['message']="";

        if (isset($_POST['hotel_Id']))
        {

            $id=$_POST['hotel_Id'];
            $name=$_POST['hotel_Name'];
            $telephone=$_POST['hotel_Telephone'];
            $hotel_Address=$_POST['hotel_Address'];
            $hotel_Inspection_rate=$_POST['hotel_Inspection_Rate'];
            $hotel_Bank_Account_Number=$_POST['hotel_Bank_Account_Number'];
            $contact=$_POST['hotel_Contact_Person'];
            $loc=$_POST['hotel_Location'];
            $web=$_POST['hotel_Website'];
            $email=$_POST['hotel_Email'];
            $bank=$_POST['hotel_Bank_Name'];
            $bankBranch=$_POST['hotel_Bank_Branch'];
            $expire=$_POST['hotel_Contract_Expire_Date'];
            $hotel_Comments=$_POST['hotel_Comments'];
            $hotel_ExtraTelephone=$_POST['hotel_ExtraTelephone'];
            $hotel_ExtraEmail=$_POST['hotel_ExtraEmail'];
            $hotel_Bank_Account_Name=$_POST['hotel_Bank_Account_Name'];


            $result=$this->modelHotel->updateHotel($id, $name, $contact,$telephone,$hotel_Address,$loc,$web, $email, $hotel_Bank_Account_Number,$bank,$bankBranch,$hotel_Inspection_rate,$expire,$hotel_Comments,$hotel_ExtraTelephone,$hotel_ExtraEmail,$hotel_Bank_Account_Name);
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
        $controlData=$this->modelHotel->getHotels();
        $gridData=$this->getGridSettings();

        if(isset($controlData['data']))
            $gridData['data']=$controlData['data'];

        $this->load->view('tools/grid',$gridData);
    }

    public function getSearchGrid(){
        if(isset($_POST['cusName'])){
            $controlData=$this->modelHotel->getHotelSearch($_POST['cusName']);

            $gridData=$this->getGridSettings();
            if(isset($controlData['data']))
                $gridData['data']=$controlData['data'];

            $this->load->view('tools/grid',$gridData);
        }
    }

    private function validateUser(){
        if( !$this->session->userdata('isLoggedIn') )
            redirect('/login');
        else if($this->session->userdata('userType')!=0){
            redirect('/access_denied');
        }
    }
} 