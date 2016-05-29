<?php
/**
 * Created by PhpStorm.
 * User: cHiN
 * Date: 2015-09-08
 * Time: 8:20 AM
 */

class Driver_note extends CI_Controller{
    
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
            array("index.php/driver_note/viewData"));

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

        $this->load->view('driver_note/viewDriver_note',$sendData);
    }

    public function viewData($tourId){
        $result['controlData']=$this->modelTourEn->getTourEnWithTours($tourId);
        $this->load->view('driver_note/viewDriver_noteView',$result);
    }

    public function getDayDetailsById($tourId){
        $result['controlData']=$this->modelTour->getTourForDriverNote($tourId);
        $this->load->view('driver_note/viewDriver_noteReport',$result);
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

} 