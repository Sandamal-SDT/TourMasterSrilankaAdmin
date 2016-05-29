<?php
/**
 * Created by PhpStorm.
 * User: cHiN
 * Date: 2016-05-08
 * Time: 12:33 AM
 */

function validateUser(){
    $CI = & get_instance();  //get instance, access the CI superobject
    if( !$CI->session->userdata('isLoggedIn') )
        redirect('/login');
}

//validates user type
//3 -> no edit
function validateEdit(){
    $CI = & get_instance();  //get instance, access the CI superobject
    if($CI->session->userdata('userType') == 3)
        return false;
    else
        return true;
}
