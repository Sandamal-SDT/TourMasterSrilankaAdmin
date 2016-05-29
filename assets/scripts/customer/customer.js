/**
 * Created by PhpStorm.
 * User: cHiN
 * Date: 2015-09-04
 * Time: 12:13 AM
 */
var dataGrid;

$(document).ready(function() {

    bindGrid();

    // Select all tabs
    $('.nav-tabs a').click(function(){
        $(this).tab('show');
    });

    // Select tab by name
    //$('.nav-tabs a[href="#home"]').tab('show')

    // Select first tab
    //$('.nav-tabs a:first').tab('show')

    // Select last tab
    //$('.nav-tabs a:last').tab('show')

    // Select fourth tab (zero-based)
    //$('.nav-tabs li:eq(3) a').tab('show')
} );

function getCustomerView(content){
    $('#tabView').html(content);
    $('#tabViewLink').css("display","block");
    $('.nav-tabs li:eq(1) a').tab('show');
}

function getCustomerEdit(content){
    $('#tabEdit').html(content);
    $('#tabEditLink').css("display","block");
    $('.nav-tabs li:eq(2) a').tab('show');
}

function saveCustomer(url){
    var cusId=$('#ID').val();
    var cusName=$('#customerName').val();
    var cusCountry=$('#customerCountry').val();
    var cusEmail=$('#customerEmail').val();
    var cusLName=$('#customerNamel').val();
    var cusDob=$('#customerDob').val();
    var cusAddr=$('#customerAddress').val();
    var cusTp=$('#customerTelephone').val();
    var customer_Blood_Group=$('#customerBloodGroup').val();
    var customer_Comments=$('#customerComments').val();
    var cus_ExtraTelephone=$('#customerExtraTelephone').val();
    var cus_EmergencyTelephone=$('#customerEmergencyTelephone').val();

    var post={
        'cusId':cusId,
        'cusName':cusName,
        'cusCountry':cusCountry,
        'cusEmail':cusEmail,
        'cusLName':cusLName,
        'cusDob':cusDob,
        'cusAddr':cusAddr,
        'cusTp':cusTp,
        'customer_Blood_Group':customer_Blood_Group,
        'customer_Comments':customer_Comments,
        'customer_ExtraTelephone':cus_ExtraTelephone,
        'customer_EmergencyTelephone':cus_EmergencyTelephone
    };
    setJson(url,getResult,post,'');
}

function addCustomer(url){
    var cusId=-1;
    var cusName=$('#customerNamei').val();
    var cusCountry=$('#customerCountryi').val();
    var cusEmail=$('#customerEmaili').val();
    var cusLName=$('#customerNameli').val();
    var cusDob=$('#customerDobi').val();
    var cusAddr=$('#customerAddressi').val();
    var cusTp=$('#customerTelephonei').val();
    var customer_Blood_Group=$('#customerBloodGroupi').val();
    var customer_Comments=$('#customerCommentsi').val();
    var customer_ExtraTelephone=$('#customerExtraTelephonei').val();
    var customer_EmergencyTelephone=$('#customerEmergencyTelephonei').val();

    var post={
        'cusId':cusId,
        'cusName':cusName,
        'cusCountry':cusCountry,
        'cusEmail':cusEmail,
        'cusLName':cusLName,
        'cusDob':cusDob,
        'cusAddr':cusAddr,
        'cusTp':cusTp,
        'customer_Blood_Group':customer_Blood_Group,
        'customer_Comments':customer_Comments,
        'customer_ExtraTelephone':customer_ExtraTelephone,
        'customer_EmergencyTelephone':customer_EmergencyTelephone
    };
    setJson(url,getResult,post,"");

    $('#customerNamei').val("");
    $('#customerCountryi').val("");
    $('#customerEmaili').val("");
    $('#customerNameli').val("");
    $('#customerDobi').val("");
    $('#customerAddressi').val("");
    $('#customerTelephonei').val("");
    $('#customerBloodGroupi').val("");
    $('#customerCommentsi').val("");
    $('#customerExtraTelephonei').val("");
    $('#customerEmergencyTelephonei').val("");
}

function searchCustomer(url){
    var cusName=$('#customerNameS').val();

    var post={
        'cusName':cusName
    };
    getJson(url,refreshTable,post,'');
}


function getResult(data,params){
        $('#tabViewLink').css("display","none");
        $('#tabEditLink').css("display","none");
        $('.nav-tabs li:eq(0) a').tab('show');
        //$('body').html($('body').html()+data);

        getJson("customer/loadAjaxGrid",refreshTable);
        $('body').append(data);
}

function refreshTable(content,params){
    dataGrid.clear();
    //localStorage.removeItem( 'DataTables_datatable_'+window.location.pathname );//remove table state
    $('#tableContainer').html(content);
    bindGrid();
}

function bindGrid(){

    dataGrid=$('#datatable').DataTable(
        {
            stateSave: true,
            responsive:true,
            autoWidth:false
        }
    );
}