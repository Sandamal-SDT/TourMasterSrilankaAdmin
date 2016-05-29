<?php
/**
 * Created by PhpStorm.
 * User: cHiN
 * Date: 2015-09-08
 * Time: 8:20 AM
 */

class Ticket extends CI_Controller{
    
    function __construct(){
        parent::__construct();
        validateUser();
        $this->load->model('Model_ticket','modelTicket');
    }

    function getGridSettings(){

        $gridHeader=array("ID","Ticket Name","Ticket Description","Ticket Price","Actions"); //grid header
        $gridDataFeilds=array("ticket_Id","ticket_Name","ticket_Description","ticket_Price"); //data binding

        if(validateEdit()) {
            //sends command names,javascript function,address
            $gridActions = array(array("view", "edit"), array("getView", "getEdit"),
                array("index.php/ticket/viewData", "index.php/ticket/editData"));
        }else{
            $gridActions = array(array("view"), array("getView"),
                array("index.php/ticket/viewData"));
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

        $controlData=$this->modelTicket->getTickets();
        $gridData=$this->getGridSettings();

        if(isset($controlData['data']))
            $gridData['data']=$controlData['data'];

        $sendData['gridData']=$gridData;
        $sendData['ctrlData']=$controlData['stat'];

        $this->load->view('ticket/viewTicket',$sendData);
    }

    public function viewData($ticketId){
        $result['controlData']=$this->modelTicket->getTicket($ticketId);
        $this->load->view('ticket/viewTicketView',$result);
    }

    public function editData($ticketId){
        $result['controlData']=$this->modelTicket->getTicketForEdit($ticketId);
        $this->load->view('ticket/viewTicketEdit',$result);
    }


    public function saveData($isInsert)
    {
        $this->load->helper(array('form', 'url'));

        $stat['statFlag']=0;
        $stat['message']="";

        if (isset($_POST['ticket_Id']))
        {
            //"ticket_Id","ticket_Name","ticket_Description","ticket_Price"
            $id=$_POST['ticket_Id'];
            $ticket_Name=$_POST['ticket_Name'];
            $ticket_Description=$_POST['ticket_Description'];
            $ticket_Price=$_POST['ticket_Price'];


            $result=$this->modelTicket->updateTicket($id,$ticket_Name,$ticket_Description,$ticket_Price);
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
        $controlData=$this->modelTicket->getTickets();
        $gridData=$this->getGridSettings();

        if(isset($controlData['data']))
            $gridData['data']=$controlData['data'];

        $this->load->view('tools/grid',$gridData);
    }

    public function getSearchGrid(){
        if(isset($_POST['ticket_Name'])){
            $controlData=$this->modelTicket->getTicketSearch($_POST['ticket_Name']);

            $gridData=$this->getGridSettings();
            if(isset($controlData['data']))
                $gridData['data']=$controlData['data'];

            $this->load->view('tools/grid',$gridData);
        }
    }

} 