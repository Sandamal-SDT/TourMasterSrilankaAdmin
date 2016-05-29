<?php
/**
 * Created by PhpStorm.
 * User: cHiN
 * Date: 2015-09-04
 * Time: 11:33 PM
 */

class Tour_flow extends CI_Controller{

    function __construct(){
        parent::__construct();
        validateUser();
        if($this->session->userdata('userType') == 2)
            redirect('/access_denied');
        $this->load->model('Model_tour_flow','modelTour_flow');
    }

    function getGridSettings(){
        $gridHeader=array("Tour Enrol Id","Customer First Name","Customer Last Name","Action"); //grid header
        $gridDataFeilds=array("tour_Enrolment_Id","customer_First_Name","customer_Last_Name"); //data binding
        //sends command names,javascript function,address
        $gridActions=array(array("Report"),array("getViewConfig"),
            array("index.php/tour_flow/viewData"));

        $gridData['gridHeader']=$gridHeader;
        $gridData['gridDataFeilds']=$gridDataFeilds;
        $gridData['actions']=$gridActions;

        return $gridData;
    }



    function index() {
        $this->showData();
    }

    public function showData() {

        $controlData=$this->modelTour_flow->getTour_ens();
        $gridData=$this->getGridSettings();

        if(isset($controlData['data']))
            $gridData['data']=$controlData['data'];

        $sendData['gridData']=$gridData;
        $sendData['ctrlData']=$controlData['stat'];

        $this->load->view('tour_flow/viewTour_flow',$sendData);
    }

    public function viewData($tour_enEnId){
        $result['controlData']=$this->modelTour_flow->getTour_en($tour_enEnId);
        $this->load->view('tour_flow/viewTour_flowView',$result);
    }

    public function generateReport($tour_enEnId){
        $result['controlData']=$this->modelTour_flow->getTour_en($tour_enEnId);
        $this->load->view('tour_flow/viewTour_flowReport',$result);
    }

    public function loadAjaxGrid(){
        $controlData=$this->modelTour_flow->getTour_ens();
        $gridData=$this->getGridSettings();

        if(isset($controlData['data']))
            $gridData['data']=$controlData['data'];

        $this->load->view('tools/grid',$gridData);
    }

    public function getSearchGrid(){
        if(isset($_POST['tour_en_customer_Id'])){
            $controlData=$this->modelTour_flow->getTour_enSearch($_POST['tour_en_customer_Id']);

            $gridData=$this->getGridSettings();
            if(isset($controlData['data']))
                $gridData['data']=$controlData['data'];

            $this->load->view('tools/grid',$gridData);
        }
    }

} 