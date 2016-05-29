/**
 * Created by PhpStorm.
 * User: cHiN
 * Date: 2015-09-04
 * Time: 12:13 AM
 */
var dataGrid;

$(document).ready(function() {

    bindGrid();

    $('.nav-tabs a').click(function(){
        $(this).tab('show');
    });

} );

//getting data for 'view'
function getView(content){
    $('#tabView').html(content);
    $('#tabViewLink').css("display","block");
    $('.nav-tabs li:eq(1) a').tab('show');
}

//get data for 'edit'
function getEdit(content){
    $('#tabEdit').html(content);
    $('#tabEditLink').css("display","block");
    $('.nav-tabs li:eq(2) a').tab('show');
}

//save function for update/insert
function saveData(url,postList,refreshUrl){
    setJson(url,getResult,postList.post,refreshUrl);
    clearCtrl(postList.ctrList);
}

//search function for search criteria
function searchData(url,postList,refreshUrl){
    getJson(url,refreshTable,postList.post,refreshUrl);
}

//get json result data
function getResult(data,paramsForFunc){
        $('#tabViewLink').css("display","none");
        $('#tabEditLink').css("display","none");
        $('.nav-tabs li:eq(0) a').tab('show');
        //$('body').html($('body').html()+data);

        getJson(paramsForFunc,refreshTable,null,null);
        $('body').append(data);//alert stat
}

//refreshing tables
function refreshTable(content,paramsForFunc){
    dataGrid.clear();
    //localStorage.removeItem( 'DataTables_datatable_'+window.location.pathname );//remove table state
    $('#tableContainer').html(content);
    bindGrid();
}

//init jquery datatable
function bindGrid(){
    dataGrid=$('#datatable').DataTable(
        {
            stateSave: true,
            responsive:true,
            autoWidth:false
        }
    );
}

//clearing controls
function clearCtrl(ctrlList){
    for(var i=0;i<ctrlList.length;i++){
        if($('#'+ctrlList[i]).val()!=-1) //doesn't clear insert flag of IDi
            $('#'+ctrlList[i]).val("");
    }
}