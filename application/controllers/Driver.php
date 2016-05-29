<?php
/**
 * Created by PhpStorm.
 * User: cHiN
 * Date: 2015-09-06
 * Time: 11:46 PM
 */

class Driver extends CI_Controller{

    //"driver_Id","driver_Name","driver_Charge_Per_Date","driver_Extra_Km_Charge"
    
    function __construct(){
        parent::__construct();
        validateUser();
        $this->load->model('Model_driver','modelDriver');
    }

    function getGridSettings(){
        $gridHeader=array("ID","Driver Name","Charge Per Date","Extra Km Charge","Actions"); //grid header
        $gridDataFeilds=array("driver_Id","driver_Name","driver_Charge_Per_Date","driver_Extra_Km_Charge"); //data binding

        if(validateEdit()){
        //sends command names,javascript function,address
        $gridActions=array(array("view","edit"),array("getView","getEdit"),
            array("index.php/driver/viewData","index.php/driver/editData"));
        }else{
            $gridActions=array(array("view"),array("getView"),
                array("index.php/driver/viewData"));
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

        $controlData=$this->modelDriver->getDrivers();
        $gridData=$this->getGridSettings();

        if(isset($controlData['data']))
            $gridData['data']=$controlData['data'];

        $sendData['gridData']=$gridData;
        $sendData['ctrlData']=$controlData['stat'];

        $this->load->view('driver/viewDriver',$sendData);
    }

    public function viewData($driverId){
        $result['controlData']=$this->modelDriver->getDriver($driverId);
        $this->load->view('driver/viewDriverView',$result);
    }

    public function editData($driverId){
        $result['controlData']=$this->modelDriver->getDriverForEdit($driverId);
        $this->load->view('driver/viewDriverEdit',$result);
    }


    public function saveData($isInsert)
    {
        $this->load->helper(array('form', 'url'));
        $this->load->library('form_validation');

        $stat['statFlag']=0;
        $stat['message']="";

        if (isset($_POST['driver_Id']))
        {

            $id=$_POST['driver_Id'];
            $driver_Name=$_POST['driver_Name'];
            $driver_Charge_Per_Date=$_POST['driver_Charge_Per_Date'];
            $driver_Extra_Km_Charge=$_POST['driver_Extra_Km_Charge'];
            $driver_Nic=$_POST['driver_Nic'];
            $driver_Licence=$_POST['driver_Licence'];
            $driver_Other_Charge=$_POST['driver_Other_Charge'];
            $driver_Blood_Group=$_POST['driver_Blood_Group'];
            $driver_Telephone=$_POST['driver_Telephone'];


            $result=$this->modelDriver->updateDriver($id, $driver_Name, $driver_Charge_Per_Date,$driver_Extra_Km_Charge
            ,$driver_Nic,$driver_Licence,$driver_Other_Charge,$driver_Blood_Group,$driver_Telephone);
            if($result)
            {
                //ok
                $stat['statFlag']=1;
                $stat['message']=$driver_Name." : ".$isInsert==0?"Successfully Updated":"Successfully Inserted";
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
        $controlData=$this->modelDriver->getDrivers();
        $gridData=$this->getGridSettings();

        if(isset($controlData['data']))
            $gridData['data']=$controlData['data'];

        $this->load->view('tools/grid',$gridData);
    }

    public function getSearchGrid(){
        if(isset($_POST['driver_Name'])){
            $controlData=$this->modelDriver->getDriverSearch($_POST['driver_Name']);

            $gridData=$this->getGridSettings();
            if(isset($controlData['data']))
                $gridData['data']=$controlData['data'];

            $this->load->view('tools/grid',$gridData);
        }
    }

} 