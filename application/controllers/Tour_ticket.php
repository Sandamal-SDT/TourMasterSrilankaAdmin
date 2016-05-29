<?php
/**
 * Created by PhpStorm.
 * User: cHiN
 * Date: 2015-09-08
 * Time: 8:20 AM
 */

class Tour_ticket extends CI_Controller{
    
    function __construct(){
        parent::__construct();
        validateUser();
        $this->load->model('Model_tour_ticket','modelTourTicket');
    }

    function getGridSettings(){
        $gridHeader=array("ID","Tour Enrolment","Ticket","Number Of Tickets","Actions"); //grid header
        $gridDataFeilds=array("tour_Ticket_Id","tour_Ticket_Tour_Enrolment_Id","ticket_Name","tour_Ticket_No_Of_Tickets"); //data binding

        if(validateEdit()) {
            //sends command names,javascript function,address
            $gridActions = array(array("view", "edit"), array("getView", "getEdit"),
                array("index.php/tour_ticket/viewData", "index.php/tour_ticket/editData"));
        }else{
            $gridActions = array(array("view"), array("getView"),
                array("index.php/tour_ticket/viewData"));
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

        $controlData=$this->modelTourTicket->getTourTickets();
        $gridData=$this->getGridSettings();

        if(isset($controlData['data']))
            $gridData['data']=$controlData['data'];

        $sendData['gridData']=$gridData;
        $sendData['ctrlData']=$controlData['stat'];
        $sendData['enTour_enList']=$controlData['enTour_enList'];
        $sendData['enTicketList']=$controlData['enTicketList'];

        $this->load->view('tour_ticket/viewTour_ticket',$sendData);
    }

    public function viewData($tourId){
        $result['controlData']=$this->modelTourTicket->getTourTicket($tourId);
        $this->load->view('tour_ticket/viewTour_ticketView',$result);
    }

    public function editData($tourId){
        $result['controlData']=$this->modelTourTicket->getTourTicketForEdit($tourId);
        $this->load->view('tour_ticket/viewTour_ticketEdit',$result);
    }


    public function saveData($isInsert)
    {
        $this->load->helper(array('form', 'url'));
        $this->load->library('form_validation');

        $stat['statFlag']=0;
        $stat['message']="";

        if (isset($_POST['tour_Ticket_Id']))
        {

            $id=$_POST['tour_Ticket_Id'];
            $tour_Ticket_Tour_Enrolment_Id=$_POST['tour_Ticket_Tour_Enrolment_Id'];
            $tour_Ticket_Ticket_Id=$_POST['tour_Ticket_Ticket_Id'];
            $tour_Ticket_No_Of_Tickets=$_POST['tour_Ticket_No_Of_Tickets'];
            $tour_Ticket_Description=$_POST['tour_Ticket_Description'];

            $result=$this->modelTourTicket->updateTourTicket($id,$tour_Ticket_Tour_Enrolment_Id,$tour_Ticket_Ticket_Id,$tour_Ticket_No_Of_Tickets,$tour_Ticket_Description);
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
        $controlData=$this->modelTourTicket->getTourTickets();
        $gridData=$this->getGridSettings();

        if(isset($controlData['data']))
            $gridData['data']=$controlData['data'];

        $this->load->view('tools/grid',$gridData);
    }

    public function getSearchGrid(){
        if(isset($_POST['ticket_Name'])){
            $controlData=$this->modelTourTicket->getTourTicketSearch($_POST['ticket_Name']);

            $gridData=$this->getGridSettings();
            if(isset($controlData['data']))
                $gridData['data']=$controlData['data'];

            $this->load->view('tools/grid',$gridData);
        }
    }

} 