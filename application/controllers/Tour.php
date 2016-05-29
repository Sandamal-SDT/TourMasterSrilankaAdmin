<?php
/**
 * Created by PhpStorm.
 * User: cHiN
 * Date: 2015-09-08
 * Time: 8:20 AM
 */

class Tour extends CI_Controller{
    
    function __construct(){
        parent::__construct();
        validateUser();
        $this->load->model('Model_tour','modelTour');
        $this->load->model('Model_tour_en','modelTourEn');
    }

    function getGridSettings(){
        $gridHeader=array("Tour Enrol Id","Customer","Action"); //grid header
        $gridDataFeilds=array("tour_Enrolment_Id","customer_First_Name"); //data binding
        //sends command names,javascript function,address
        $gridActions=array(array("view"),array("getView"),
            array("index.php/tour/viewData"));

        $gridData['gridHeader']=$gridHeader;
        $gridData['gridDataFeilds']=$gridDataFeilds;
        $gridData['actions']=$gridActions;

        return $gridData;
    }



    function index() {
        $this->showData();
    }

    public function showData() {

        $controlData=$this->modelTourEn->getTour_ens();
        $gridData=$this->getGridSettings();

        if(isset($controlData['data']))
            $gridData['data']=$controlData['data'];

        $sendData['gridData']=$gridData;
        $sendData['ctrlData']=$controlData['stat'];
        $sendData['customerList']=$controlData['customerList'];
        $sendData['driverList']=$controlData['driverList'];

        $this->load->view('tour/viewTour',$sendData);
    }

    public function viewData($tourId){
        $result['controlData']=$this->modelTourEn->getTourEnWithTours($tourId);
        $this->load->view('tour/viewTourView',$result);
    }

    public function getDayDetailsById($tourId){
        if($tourId!=0){
            $result['controlData']=$this->modelTour->getTourForEdit($tourId);
            $this->load->view('tour/viewTourEdit',$result);
        }
        else{//new date insertion
            $result['controlData']=$this->modelTour->getTourForEdit($tourId);
            $this->load->view('tour/viewTourAdd',$result);
        }
        //echo json_encode($result);
    }

    public function saveData($isInsert)
    {
        $this->load->helper(array('form', 'url'));
        $this->load->library('form_validation');

        $stat['statFlag']=0;
        $stat['message']="";

        if (isset($_POST['tour_id']))
        {

            $id=$_POST['tour_id'];
            $tour_Enrolment_Id=$_POST['tour_Enrolment_Id'];
            $tour_Start_Date=$_POST['tour_Start_Date'];
            $tour_End_Date=$_POST['tour_End_Date'];
            $tour_Room_Id=$_POST['tour_Room_Id'];
            $tour_Number_Of_Rooms=$_POST['tour_Number_Of_Rooms'];

            $result=$this->modelTour->updateTour($id,$tour_Enrolment_Id,$tour_Start_Date,$tour_End_Date,$tour_Room_Id,$tour_Number_Of_Rooms);
            if($result)
            {
                //ok
                $stat['statFlag']=1;
                $stat['message']=$id." : ".$isInsert==0?"Successfully Updated":"Successfully Inserted";
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
        $controlData=$this->modelTour->getTours();
        $gridData=$this->getGridSettings();

        if(isset($controlData['data']))
            $gridData['data']=$controlData['data'];

        $this->load->view('tools/grid',$gridData);
    }

    public function getSearchGrid(){
        if(isset($_POST['tour_Enrolment_Id'])){
            $controlData=$this->modelTour->getTourSearch($_POST['tour_Enrolment_Id']);

            $gridData=$this->getGridSettings();
            if(isset($controlData['data']))
                $gridData['data']=$controlData['data'];

            $this->load->view('tools/grid',$gridData);
        }
    }

    public function getHotelsForLocation(){
        if(isset($_POST['key'])){
            $controlData=$this->modelTour->getHotelsForLocation($_POST['key']);
            $this->load->view('tools/dropDown',$controlData);
        }
    }

    public function getRoomsForHotel(){
        if(isset($_POST['key'])){
            $controlData=$this->modelTour->getRoomsForHotel($_POST['key']);
            $this->load->view('tools/dropDown',$controlData);
        }
    }

    public function refreshGrid($tourId){
        $result['controlData']=$this->modelTourEn->getTourEnWithTours($tourId);
        $this->load->view('tour/viewTourGrid',$result);
    }
} 