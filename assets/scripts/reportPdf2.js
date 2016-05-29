/**
 * Created by cHiN on 2015-10-11.
 */

var reportName = "Invoice";
var a4WidthMultiplier = 210; //a4 width (mm)
var a4HeightMultiplier = 297; //A4 height(mm)

function convertToPDF(svgId,imgId,repName){
    reportName = repName;
    var svg  = $("#"+svgId)[0];
    var img=$("#"+imgId)[0];

    var svgUri=svgDataURL(svg);

    createPDF(svgUri,img,createPages);
}

//getting svg data uri
function svgDataURL(svg) {
    var svgAsXML = (new XMLSerializer).serializeToString(svg);
    return "data:image/svg+xml," + encodeURIComponent(svgAsXML);
}

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

//loading images
var createPDF = function(svgUri,img,callback) {

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
        img.onload = function(){ //http://stackoverflow.com/questions/15048279/drawimage-not-working
            callback(img);
        };
    };

};

//paging pdf
var createPages = function(imgData){
    var pages = new Array();

    var calculatedHeight = parseInt((imgData.height/imgData.width)*a4WidthMultiplier);//keeping image aspect-ratio

    var pageImageHeight = (a4HeightMultiplier/a4WidthMultiplier)*imgData.width; //page real px height
    var pageImageWidth = imgData.width; //page real px width

    var page;
    if(calculatedHeight>a4HeightMultiplier){
        for(var y=0;y<imgData.height;y+=pageImageHeight){
            page = createPage(imgData,0,y,pageImageWidth,pageImageHeight);
            pages.push(page);
        }
    }
    else{
        page = createPage(imgData,0,0,pageImageWidth,pageImageHeight);
        pages.push(page);
    }
    savePDF(pages);
};

//create one page image
function createPage(imgData,left,top,width,height){
    var canvas = document.createElement('canvas');
    canvas.width = width;
    canvas.height = height;
    var context = canvas.getContext('2d');
    context.drawImage(imgData, left,top,width,height,0,0,width,height); //https://developer.mozilla.org/en/docs/Web/API/CanvasRenderingContext2D/drawImage
    return canvas.toDataURL('image/jpg');
}


//jsPdf function
function savePDF (pages) {

    var doc = new jsPDF('p', 'mm', 'a4'); //var doc = new jsPDF('landscape');

    for(var i =0 ;i<pages.length;i++){
        //window.open(pages[i]);
        doc.addImage(pages[i], 'JPG', 3, 5,a4WidthMultiplier-6, a4HeightMultiplier-10, reportName+i); //http://stackoverflow.com/questions/23104008/where-to-change-default-pdf-page-width-and-font-size-in-jspdf-debug-js
        if(i!=pages.length-1)
            doc.addPage();
    }

    doc.save(reportName+'.pdf');
}
