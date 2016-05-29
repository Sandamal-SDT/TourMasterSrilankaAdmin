<?php

class Access_denied extends CI_Controller {

    function index() {
        $this->load->view('viewAccessDenied');
    }

}
