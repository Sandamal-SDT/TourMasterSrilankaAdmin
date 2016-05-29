<?php
/**
 * Created by PhpStorm.
 * User: cHiN
 * Date: 2015-09-06
 * Time: 11:46 PM
 */

class Hotel_bank extends CI_Controller{

    //hotel_Id,hotel_Name,hotel_Telephone,hotel_Address,hotel_Inspection_rate,hotel_Bank_Account_Number

    function __construct(){
        parent::__construct();
        validateUser();
        $this->load->model('Model_hotel','modelHotel');
        $this->load->model('Model_tour_en','modelTourEn');
    }

    function getGridSettings(){
        $gridHeader=array("Tour Enrol Id","Customer","Action"); //grid header
        $gridDataFeilds=array("tour_Enrolment_Id","customer_First_Name"); //data binding
        //sends command names,javascript function,address
        $gridActions=array(array("view"),array("getView"),
            array("index.php/hotel_bank/viewData"));

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

        $this->load->view('hotel_bank/viewHotel_bank',$sendData);
    }


    public function viewData($tourId){
        $result['controlData']=$this->modelTourEn->getTourEnWithTours($tourId);
        $this->load->view('hotel_bank/viewHotel_bankView',$result);
    }

    public function getHotelDetailsById($tourEnId){
        $result['controlData']=$this->modelHotel->getHotelsPerTourEnrolement($tourEnId);
        $this->load->view('hotel_bank/viewHotel_bankReport',$result);
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

} 