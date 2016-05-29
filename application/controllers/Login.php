<?php

class Login extends CI_Controller {


    function index() {
        if( $this->session->userdata('isLoggedIn') ) {
            redirect('/dashboard');
        } else {
            $this->show_login(false);
        }
    }
    

    //login validation
    function login_user() {
        // Create an instance of the user model
        $this->load->model('Model_user','modelUser');

        // Grab the userName and password from the form POST
        $userName = $this->input->post('userName');
        $pass  = $this->input->post('password');

        //Ensure values exist for userName and pass, and validate the user's credentials
        if( $userName && $pass && $this->modelUser->validate_user($userName,$pass)) {
            // If the user is valid, redirect to the main view
            redirect('/dashboard');
        } else {
            // Otherwise show the login screen with an error message.
            $this->show_login(true);
        }
    }

    function show_login( $show_error = false ) {
        $this->load->helper('form');
        $this->load->view('viewLogin');
    }

    function logout_user() {
      $this->session->sess_destroy();
      $this->index();
    }

}
