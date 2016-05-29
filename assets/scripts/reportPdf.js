/**
 * Created by cHiN on 2015-10-11.
 */

//svg id ,image id
var reportName = "Invoice";

function convertToPDF(svgId,imgId,repName){
    reportName = repName;
    var svg  = $("#"+svgId)[0];
    var img=$("#"+imgId)[0];

    var svgUri=svgDataURL(svg);

    getImageFromUrl(svgUri,img,createPDF);
}

//getting svg data uri
function svgDataURL(svg) {
    var svgAsXML = (new XMLSerializer).serializeToString(svg);
    return "data:image/svg+xml," + encodeURIComponent(svgAsXML);
}

//loading images
var getImageFromUrl = function(svgUri,img,callback) {

    //window.open(svgUri);
    var tempImg=new Image();
    tempImg.width=img.width;
    tempImg.height=img.height;
    tempImg.src = svgUri;

    tempImg.onError = function() {
        alert('Cannot load image');
    };
    tempImg.onload = function() {
        var dataPng=svgToPng(tempImg);
        //window.open(dataPng);
        img.src=dataPng;
        callback(img);
    };

};

//converting svg -> png through canvas
function svgToPng(tempImg){
    var canvas = document.createElement('canvas');
    //var canvas=document.getElementById('can');
    canvas.width = tempImg.width;
    canvas.height = tempImg.height;
    var context = canvas.getContext('2d');
    context.drawImage(tempImg, 0, 0);
    return canvas.toDataURL('image/jpg');
}


//jsPdf function
var createPDF = function(imgData) {
    //alert(imgData.height +" - "+imgData.width);
    //1mm <-> 3.8px
    var imgHeight = parseInt((imgData.height/imgData.width)*280);//290 - A4 height(mm)
    //alert(imgHeight);
    imgHeight = imgHeight > 290 ? imgHeight : 290;

    var doc = new jsPDF('p', 'mm', [imgHeight, 290]); //var doc = new jsPDF('landscape');
    doc.addImage(imgData, 'JPG', 5, 5,280, imgHeight-5, reportName); //http://stackoverflow.com/questions/23104008/where-to-change-default-pdf-page-width-and-font-size-in-jspdf-debug-js
    doc.save(reportName+'.pdf');
};

