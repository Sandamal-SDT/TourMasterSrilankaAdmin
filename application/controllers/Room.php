<?php
/**
 * Created by PhpStorm.
 * User: cHiN
 * Date: 2015-09-06
 * Time: 11:46 PM
 */

class Room extends CI_Controller{

    //room_Id,room_Name,room_Telephone,room_Address,room_Inspection_rate,room_Bank_Account_Number

    function __construct(){
        parent::__construct();
        validateUser();
        $this->load->model('Model_room','modelRoom');
        $this->load->model('Model_hotel','modelHotel');
    }

    function getGridSettings(){
        $gridHeader=array("ID","Name","Location","Telephone","Inspection Rate","Actions"); //grid header
        $gridDataFeilds=array("hotel_Id", "hotel_Name","hotel_Location","hotel_Telephone","hotel_Inspection_Rate"); //data binding
        //sends command names,javascript function,address
        $gridActions=array(array("view"),array("getView"),
            array("index.php/room/viewData"));

        $gridData['gridHeader']=$gridHeader;
        $gridData['gridDataFeilds']=$gridDataFeilds;
        $gridData['actions']=$gridActions;

        return $gridData;
    }




    function index() {
        $this->showData();
    }

    public function showData() {
        /*
        $controlData=$this->modelRoom->getRooms();
        $gridData=$this->getGridSettings();

        if(isset($controlData['data']))
            $gridData['data']=$controlData['data'];

        $sendData['gridData']=$gridData;
        $sendData['ctrlData']=$controlData['stat'];
        $sendData['hotelList']=$controlData['hotelList'];
        */
        $controlData=$this->modelHotel->getHotels();
        $gridData=$this->getGridSettings();

        if(isset($controlData['data']))
            $gridData['data']=$controlData['data'];

        $sendData['gridData']=$gridData;
        $sendData['ctrlData']=$controlData['stat'];

        $this->load->view('room/viewRoom',$sendData);
    }

    public function viewData($hotelId){
        $result['controlData']=$this->modelHotel->getRoomForHotel($hotelId);
        $this->load->view('room/viewRoomView',$result);
    }

    public function editData($roomId){
        $result['controlData']=$this->modelRoom->getRoomForEdit($roomId);
        $this->load->view('room/viewRoomEdit',$result);
    }


    public function saveData($isInsert)
    {
        $this->load->helper(array('form', 'url'));
        $this->load->library('form_validation');

        $stat['statFlag']=0;
        $stat['message']="";

        if (isset($_POST['room_Id']))
        {

            $id=$_POST['room_Id'];
            $hotel_Id=$_POST['hotel_Id'];
            $room_Type=$_POST['room_Type'];
            $room_Price=$_POST['room_Price'];
            $room_Accommodation_Type=$_POST['room_Accommodation_Type'];
            $room_Comments=$_POST['room_Comments'];
            $room_Seasons = $_POST['season_List'];

            //print_r($room_Seasons);


            $result=$this->modelRoom->updateRoom($id, $hotel_Id, $room_Type,$room_Price,$room_Accommodation_Type,$room_Comments,$room_Seasons);
            if($result)
            {
                //ok
                $stat['statFlag']=1;
                $stat['message']=$room_Type." : ".$isInsert==0?"Successfully Updated":"Successfully Inserted";
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
        $controlData=$this->modelRoom->getRooms();
        $gridData=$this->getGridSettings();

        if(isset($controlData['data']))
            $gridData['data']=$controlData['data'];

        $this->load->view('tools/grid',$gridData);
    }

    public function getSearchGrid(){
        if(isset($_POST['room_Type'])){
            $controlData=$this->modelRoom->getRoomSearch($_POST['room_Type']);

            $gridData=$this->getGridSettings();
            if(isset($controlData['data']))
                $gridData['data']=$controlData['data'];

            $this->load->view('tools/grid',$gridData);
        }
    }


    public function getRoomDetailsById($roomId){
        if($roomId!=0){
            $result['controlData']=$this->modelRoom->getRoomForEdit($roomId);
            $this->load->view('room/viewRoomEdit',$result);
        }
        else{//new date insertion
            $result['controlData']=$this->modelRoom->getRoomForEdit($roomId);
            $this->load->view('room/viewRoomAdd',$result);
        }
        //echo json_encode($result);
    }

    public function refreshGrid($hotelId){
        $result['controlData']=$this->modelHotel->getRoomForHotel($hotelId);
        $this->load->view('room/viewRoomGrid',$result);
    }
} 