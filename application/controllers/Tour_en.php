<?php
/**
 * Created by PhpStorm.
 * User: cHiN
 * Date: 2015-09-04
 * Time: 11:33 PM
 */

class Tour_en extends CI_Controller{

    /* tour_Enrolment_Id,tour_Enrolment_Number_Of_Persons,tour_Enrolment_Extra_Mileage,tour_Enrolment_Description,tour_Enrolment_Customer_Id,tour_Enrolment_Driver_Id,tour_Enrolment_Arrives,tour_Enrolment_Departure,tour_Enrolment_Days */

    function __construct(){
        parent::__construct();
        validateUser();
        if($this->session->userdata('userType') == 2)
            redirect('/access_denied');
        $this->load->model('Model_tour_en','modelTour_en');
    }

    function getGridSettings(){
        $gridHeader=array("Tour Enrol Id","Customer First Name","Customer Last Name","Action"); //grid header
        $gridDataFeilds=array("tour_Enrolment_Id","customer_First_Name","customer_Last_Name"); //data binding

        if(validateEdit()) {
            //sends command names,javascript function,address
            $gridActions = array(array("view", "edit"), array("getView", "getEdit"),
                array("index.php/tour_en/viewData", "index.php/tour_en/editData"));
        }else{
            $gridActions = array(array("view"), array("getView"),
                array("index.php/tour_en/viewData"));
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

        $controlData=$this->modelTour_en->getTour_ens();
        $gridData=$this->getGridSettings();

        if(isset($controlData['data']))
            $gridData['data']=$controlData['data'];

        $sendData['gridData']=$gridData;
        $sendData['ctrlData']=$controlData['stat'];
        $sendData['customerList']=$controlData['customerList'];
        $sendData['driverList']=$controlData['driverList'];

        $this->load->view('tour_en/viewTour_en',$sendData);
    }

    public function viewData($tour_enEnId){
        $result['controlData']=$this->modelTour_en->getTour_en($tour_enEnId);
        $this->load->view('tour_en/viewTour_enView',$result);
    }

    public function editData($tour_enEnId){
        $result['controlData']=$this->modelTour_en->getTour_enForEdit($tour_enEnId);

        $this->load->view('tour_en/viewTour_enEdit',$result);
    }

    public function saveData($isInsert)
    {
        $this->load->helper(array('form', 'url'));
        $this->load->library('form_validation');

        $stat['statFlag']=0;
        $stat['message']="";

        if (isset($_POST['tour_en_Id']))
        {

            $tour_en_Id=$_POST['tour_en_Id'];
            $tour_en_customer_Id=$_POST['tour_en_customer_Id'];
            $tour_Enrolment_Driver_Id=$_POST['tour_Enrolment_Driver_Id'];

            $tour_Enrolment_Number_Of_Persons=$_POST['tour_Enrolment_Number_Of_Persons'];
            $tour_Enrolment_Extra_Mileage=$_POST['tour_Enrolment_Extra_Mileage'];
            $tour_Enrolment_Description=$_POST['tour_Enrolment_Description'];

            $tour_Enrolment_Arrives=$_POST['tour_Enrolment_Arrives'];
            $tour_Enrolment_Departure=$_POST['tour_Enrolment_Departure'];
            $tour_Enrolment_Days=$_POST['tour_Enrolment_Days'];

            $tour_Enrolment_Number_Of_Children=$_POST['tour_Enrolment_Number_Of_Children'];
            $tour_Enrolment_Arrive_Time=$_POST['tour_Enrolment_Arrive_Time'];

            $result=$this->modelTour_en->updateTour_en($tour_en_Id, $tour_en_customer_Id,$tour_Enrolment_Driver_Id,$tour_Enrolment_Description
                ,$tour_Enrolment_Number_Of_Persons,$tour_Enrolment_Extra_Mileage,$tour_Enrolment_Arrives,$tour_Enrolment_Departure,$tour_Enrolment_Days
                ,$tour_Enrolment_Number_Of_Children,$tour_Enrolment_Arrive_Time);
            if($result)
            {
                //ok
                $stat['statFlag']=1;
                $stat['message']=$tour_en_Id." : ".$isInsert==0?"Successfully Updated":"Successfully Inserted";
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
        $controlData=$this->modelTour_en->getTour_ens();
        $gridData=$this->getGridSettings();

        if(isset($controlData['data']))
            $gridData['data']=$controlData['data'];

        $this->load->view('tools/grid',$gridData);
    }

    public function getSearchGrid(){
        if(isset($_POST['tour_en_customer_Id'])){
            $controlData=$this->modelTour_en->getTour_enSearch($_POST['tour_en_customer_Id']);

            $gridData=$this->getGridSettings();
            if(isset($controlData['data']))
                $gridData['data']=$controlData['data'];

            $this->load->view('tools/grid',$gridData);
        }
    }

} 