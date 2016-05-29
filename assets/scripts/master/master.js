/**
 * Created by PhpStorm.
 * User: cHiN
 * Date: 2015-09-04
 * Time: 12:13 AM
 */

$(function() {

    $('#side-menu').metisMenu();

});

//Loads the correct sidebar on window load,
//collapses the sidebar on window resize.
// Sets the min-height of #page-wrapper to window size
$(function() {
    $(window).bind("load resize", function() {
        var topOffset = 50;
        var width = (this.window.innerWidth > 0) ? this.window.innerWidth : this.screen.width;
        if (width < 768) {
            $('div.navbar-collapse').addClass('collapse');
            topOffset = 100; // 2-row-menu
        } else {
            $('div.navbar-collapse').removeClass('collapse');
        }

        var height = ((this.window.innerHeight > 0) ? this.window.innerHeight : this.screen.height) - 1;
        height = height - topOffset;
        if (height < 1) height = 1;
        if (height > topOffset) {
            $("#page-wrapper").css("min-height", (height) + "px");
        }
    });

    //highlighting nav links
    var url = window.location;
    var element = $('ul.nav a').filter(function() {
        return this.href == url; //return this.href == url || url.href.indexOf(this.href) == 0;
    }).addClass('active').parent().parent().addClass('in').parent();
    if (element.is('li')) {
        element.addClass('active');
    }

    localStorage.removeItem( 'DataTables_datatable_'+window.location.pathname );//remove table state
});

/*
* invokes 'func' function with json result data and 'paramsForFunc'
*/
function getJson(urli,func,postData,paramsForFunc){
    setLoader(true);
    $.ajax({
    url : urli,
    type: "POST",
    data:postData,
    success: function(data, textStatus, jqXHR)
    {
        //data - response from server
        //alert(data);
        func(data,paramsForFunc);
        setLoader(false);
    },
    error: function (jqXHR, textStatus, errorThrown)
    {
        //alert(errorThrown);
        setLoader(false);
        setLoadContent(0,textStatus+" : "+errorThrown);
    }
});
}

/*
 * invokes 'func' function with json result data and 'paramsForFunc'
 */
function setJson(urli,func,postData,paramsForFunc){
    setLoader(true);
    $.ajax({
        url : urli,
        type: "POST",
        data:postData,
        success: function(data, textStatus, jqXHR)
        {
            //data - response from server
            //alert(data);
            func(data,paramsForFunc);
            setLoader(false);
        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            //alert(errorThrown);
            setLoader(false);
            setLoadContent(0,textStatus+" : "+errorThrown);
        }
    });
}


function setLoader(loadFlag){
    $('#loaderImg').css("visibility",loadFlag?"visible":"hidden");
}

function setLoadContent(IsSuccess,message){
    var loader=$('#loaderContent');
    loader.css("visibility","visible");

    loader.html(message);
    loader.removeClass().addClass("alert");
    if(IsSuccess==1){
        loader.addClass("alert-success");
        setTimeout(function(){
            loader.css("visibility","hidden");
        },1500);
    }else if(IsSuccess==0){
        loader.addClass("alert-danger alert-dismissible");
        loader.html(loader.html()+"<button type='button' class='close' onclick='$(\"#loaderContent\").css(&quot;visibility&quot;,&quot;hidden&quot;)' aria-label='Close'><span aria-hidden='true'>&times;</span></button>");
    }
}