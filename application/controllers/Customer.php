<?php

class Customer extends CI_Controller {

    function index() {
        validateUser(); //see 'validate_user_helper' helper
        $this->load->model('Model_customer','modelCustomer');
        $this->showData();
    }

	public function showData() {
		$result['controlData']=$this->modelCustomer->getCustomers();
		$this->load->view('customer/viewCustomer',$result);
	}  

	public function viewData($customerId){
		$this->load->model('Model_customer','modelCustomer');
		$result['controlData']=$this->modelCustomer->getCustomer($customerId);
		$this->load->view('customer/viewCustomerView',$result);
	}

    public function editCustomer($customerId){
        $this->load->model('Model_customer','modelCustomer');
        $result['controlData']=$this->modelCustomer->getCustomer($customerId);
        $this->load->view('customer/viewCustomerEdit',$result);
    }


    public function saveCustomer($isInsert)
    {
        $this->load->helper(array('form', 'url'));
        $this->load->library('form_validation');

        $stat['statFlag']=0;
        $stat['message']="";

        if (isset($_POST['cusId']))
        {
            $this->form_validation->set_rules('cusEmail', 'Email', 'trim|required|valid_email');
            $this->form_validation->set_rules('cusName', 'name', 'required');
            $this->form_validation->set_rules('cusId', 'id', 'required');

            if ($this->form_validation->run() == FALSE)
            {
                //validity void
                $stat['statFlag']=0;
                $stat['message']="Validation Error : please check all feilds";
                $this->load->view('tools/loader',$stat);
            }
            else {

                $id=$_POST['cusId'];
                $name=$_POST['cusName'];
                $country=$_POST['cusCountry'];
                $email=$_POST['cusEmail'];
                $cusLName=$_POST['cusLName'];
                $cusDob=$_POST['cusDob'];
                $cusAddr=$_POST['cusAddr'];
                $cusTp=$_POST['cusTp'];
                $cusBloodType=$_POST['customer_Blood_Group'];
                $cusComment=$_POST['customer_Comments'];
                $cusExtraTelephone=$_POST['customer_ExtraTelephone'];
                $cusEmergencyTelephone=$_POST['customer_EmergencyTelephone'];

                $this->load->model('Model_customer','modelCustomer');
                $result=$this->modelCustomer->updateCustomer($id, $name, $country, $email,$cusLName,$cusDob,$cusAddr,$cusTp,$cusBloodType,$cusComment,$cusExtraTelephone,$cusEmergencyTelephone);
                if($result)
                {
                    //ok
                    $stat['statFlag']=1;
                    $stat['message']=$name." : ".$isInsert==0?"Successfully Updated":"Successfully Inserted";
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
        }
        else {
            $this->load->view('customer/viewCustomer');
        }

    }


    public function loadAjaxGrid(){
        $this->load->model('Model_customer','modelCustomer');
        $controlData=$this->modelCustomer->getCustomers();

        $gridHeader=array("ID","Name","Country","Email","Actions"); //grid header
        $gridDataFeilds=array("customer_Id","customer_First_Name","customer_Country","customer_Email"); //data binding
        //sends command names,javascript function,address


        if(validateEdit()){
        $gridActions=array(array("view","edit"),array("getCustomerView","getCustomerEdit"),
            array("index.php/customer/viewData","index.php/customer/editCustomer"));
        }else{
            $gridActions=array(array("view"),array("getCustomerView"),
                array("index.php/customer/viewData"));
        }


        $gridData['gridHeader']=$gridHeader;
        $gridData['gridDataFeilds']=$gridDataFeilds;
        if(isset($controlData['data']))
            $gridData['data']=$controlData['data'];
        $gridData['actions']=$gridActions;

        $this->load->view('tools/grid',$gridData);
    }

    public function getSearchGrid(){
        if(isset($_POST['cusName'])){
            $this->load->model('Model_customer','modelCustomer');
            $controlData=$this->modelCustomer->getCustomerSearch($_POST['cusName']);

            $gridHeader=array("ID","Name","Country","Email","Actions"); //grid header
            $gridDataFeilds=array("customer_Id","customer_First_Name","customer_Country","customer_Email"); //data binding
            //sends command names,javascript function,address
            $gridActions=array(array("view","edit"),array("getCustomerView","getCustomerEdit"),
                array("index.php/customer/viewData","index.php/customer/editCustomer"));

            $gridData['gridHeader']=$gridHeader;
            $gridData['gridDataFeilds']=$gridDataFeilds;
            if(isset($controlData['data']))
                $gridData['data']=$controlData['data'];
            $gridData['actions']=$gridActions;

            $this->load->view('tools/grid',$gridData);
        }
    }

}