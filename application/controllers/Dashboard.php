<?php

class Dashboard extends CI_Controller {

    function index() {
        $pageTitle['path']="TMSL > ";
        $pageTitle['pageTitle']="DashBoard";
        $this->load->view('viewDashboard',$pageTitle);
    }
    
}
