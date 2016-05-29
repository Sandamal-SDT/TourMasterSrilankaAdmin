<?php
/**
 * Created by PhpStorm.
 * User: cHiN
 * Date: 2015-09-08
 * Time: 8:20 AM
 */

class Extra_charges extends CI_Controller{
    
    function __construct(){
        parent::__construct();
        validateUser();
        $this->load->model('Model_extra_charges','modelExtra');
    }

    function getGridSettings(){

        $gridHeader=array("ID","Tour Enrolment","Description","Charge","Actions"); //grid header
        $gridDataFeilds=array("tour_Extra_Charge_Id","tour_Extra_Charge_Tour_Enrolment_Id","tour_Extra_Charge_Description","tour_Extra_Charge_Extra_charge"); //data binding

        if(validateEdit()) {
            //sends command names,javascript function,address
            $gridActions = array(array("view", "edit"), array("getView", "getEdit"),
                array("index.php/extra_charges/viewData", "index.php/extra_charges/editData"));
        }else{
            $gridActions = array(array("view"), array("getView"),
                array("index.php/extra_charges/viewData"));
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

        $controlData=$this->modelExtra->getExtraCharges();
        $gridData=$this->getGridSettings();

        if(isset($controlData['data']))
            $gridData['data']=$controlData['data'];

        $sendData['gridData']=$gridData;
        $sendData['ctrlData']=$controlData['stat'];
        $sendData['enCustomerList']=$controlData['enCustomerList'];

        $this->load->view('extra_charges/viewExtra_charges',$sendData);
    }

    public function viewData($extra_chargesId){
        $result['controlData']=$this->modelExtra->getExtraCharge($extra_chargesId);
        $this->load->view('extra_charges/viewExtra_chargesView',$result);
    }

    public function editData($extra_chargesId){
        $result['controlData']=$this->modelExtra->getExtraChargesForEdit($extra_chargesId);
        $this->load->view('extra_charges/viewExtra_chargesEdit',$result);
    }


    public function saveData($isInsert)
    {
        $this->load->helper(array('form', 'url'));
        $this->load->library('form_validation');

        $stat['statFlag']=0;
        $stat['message']="";

        if (isset($_POST['tour_Extra_Charge_Id']))
        {
            //"tour_Extra_Charge_Id","tour_Extra_Charge_Tour_Enrolment_Id","tour_Extra_Charge_Description","tour_Extra_Charge_Extra_charge"
            $id=$_POST['tour_Extra_Charge_Id'];
            $tour_Extra_Charge_Tour_Enrolment_Id=$_POST['tour_Extra_Charge_Tour_Enrolment_Id'];
            $tour_Extra_Charge_Description=$_POST['tour_Extra_Charge_Description'];
            $tour_Extra_Charge_Extra_charge=$_POST['tour_Extra_Charge_Extra_charge'];


            $result=$this->modelExtra->updateExtraCharges($id,$tour_Extra_Charge_Tour_Enrolment_Id,$tour_Extra_Charge_Description,$tour_Extra_Charge_Extra_charge);
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
        $controlData=$this->modelExtra->getExtraCharges();
        $gridData=$this->getGridSettings();

        if(isset($controlData['data']))
            $gridData['data']=$controlData['data'];

        $this->load->view('tools/grid',$gridData);
    }

    public function getSearchGrid(){
        if(isset($_POST['tour_Extra_Charge_Tour_Enrolment_Id'])){
            $controlData=$this->modelExtra->getExtraChargesSearch($_POST['tour_Extra_Charge_Tour_Enrolment_Id']);

            $gridData=$this->getGridSettings();
            if(isset($controlData['data']))
                $gridData['data']=$controlData['data'];

            $this->load->view('tools/grid',$gridData);
        }
    }

} 