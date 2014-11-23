
//    OpenLocalMap OpenSource web mapping for local government
//    Copyright (C) <2014>  <Ben Calnan>
//
//    This program is free software: you can redistribute it and/or modify
//    it under the terms of the GNU General Public License as published by
//    the Free Software Foundation, either version 3 of the License, or
//    (at your option) any later version.
//
//    This program is distributed in the hope that it will be useful,
//    but WITHOUT ANY WARRANTY; without even the implied warranty of
//    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
//    GNU General Public License for more details.
//
//    You should have received a copy of the GNU General Public License
//    along with this program.  If not, see <http://www.gnu.org/licenses/>.
       
            
                $(function() {
                    $( ".accordion" ).accordion({
                        heightStyle: "content",
                        collapsible: true
                    });
                    $( ".accordion2" ).accordion({
                        heightStyle: "content",
                        collapsible: true
                        //active: false
                    });
                    $( ".accordion3" ).accordion({
                        heightStyle: "content",
                        collapsible: true,
                        active: false
                    });
                    $( "#pleaseWaitDialog" ).dialog({
                        dialogClass: "no-close",
                        autoOpen: false,
                        height:105,
                        width:200,
                        resizable: false

                     });
                    $( "#noDownloadDialog" ).dialog({
                        //dialogClass: "no-close",
                        autoOpen: false,
                        height:200,
                        width:330,
                        resizable: false,
                        modal: true,
                        buttons: { 'OK':function(){
                                $(this).dialog("close");                            
                            }
                     }

                     });
                     
                     
                     
                     $( "#downloadDialog" ).dialog({
        
                        autoOpen: false,
                        height:230,
                        width:470,
                        resizable: false,
                        modal: true,
                        buttons: {
                            'Data (KML)':function(){
                                $(this).dialog("close");
                                  var layerName = $(this).data('link'); // Get the stored result
                                  var path = kmllink + layerName;                                  
                                  $(location).attr('href', path);                                
                            },
                            'Data (CSV)':function(){
                                $(this).dialog("close");
                                  var layerName = $(this).data('link'); // Get the stored result
                                  var path = csvlink + layerName;
                                  $(location).attr('href', path);                                
                            },
                            'Metadata': function(){
                                var metaPath =  $(this).data('metaURL');
                                //alert (metaPath);
                                $(this).dialog("close");                                                                
                                //$(location).attr('href', metaPath);
                                 window.open(metaPath); 
                                
                            }
                        }

                     });
                     
                      $( "#downloadDataDialog" ).dialog({
        
                        autoOpen: false,
                        height:230,
                        width:370,
                        resizable: false,
                        modal: true,
                        buttons: {
                            'Data (KML)':function(){
                                $(this).dialog("close");
                                  var layerName = $(this).data('link'); // Get the stored result
                                  var path = kmllink + layerName;                                  
                                  $(location).attr('href', path);                                
                            },
                            'Data (CSV)':function(){
                                $(this).dialog("close");
                                  var layerName = $(this).data('link'); // Get the stored result
                                  var path = csvlink + layerName;
                                  $(location).attr('href', path);                                
                            }
                        }

                     });
                     
                       $( "#downloadMetaDialog" ).dialog({
        
                        autoOpen: false,
                        height:230,
                        width:250,
                        resizable: false,
                        modal: true,
                        buttons: {
                            'Download Metadata': function(){
                                var metaPath =  $(this).data('metaURL');
                                $(this).dialog("close");                                                                
                                $(location).attr('href', metaPath);
                                
                            }
                        }

                     });
                     
                     
                    $( "#oldIEDialog" ).dialog({
                        dialogClass: "no-close",
                        autoOpen: false,
                        height:220,
                        width:500,
                        resizable: false,
                        modal: true,
                        buttons: {
                            'Ok':function(){
                                $(this).dialog("close");
                            }}
                        
                     });
                     
                    $( "#pollutionDialog" ).dialog({
                         dialogClass: "no-close",
                        autoOpen: false,
                        resizable: false,
                        height:300,
                        width:600,
                        modal: true,
                        buttons: {
                            Ok:function(){
                                
                                $(this).dialog("close");
                            },
                            Cancel: function(){
                                
                                $(this).dialog("close");
                                $( "#dialogAccordian" ).accordion('option', 'active' , 0);
                            }
                        }
                    });
                    
                  
                    
                    $( "#dialogAccordian" ).on( "accordionactivate", function( event, ui ) {  
                        var sectionNumber = $( "#dialogAccordian" ).accordion('option', 'active' );
                            if (sectionNumber === 2){
                                    pollutionDisclaim();
                                 }
                    } );
                    
                        $( "#drawDiv" ).click(function() {
                        $( "#book" ).slideDown( "slow", function() {
                        // Animation complete.
                        });
                        });
                    
                });
              
               

            function uncheckall(){
                $(':checkbox:checked').removeAttr('checked');
            
            }   




function showDownload(dataDownloadURL,MetaDownloadURL ,AllowDataDownload, AllowMetaDownload){
    
   
    var iconstring = "";
            if(AllowDataDownload === 'YES'){
               
                
                    if(AllowMetaDownload === 'YES'){
                        iconstring = iconstring + "<div class='downloadIcons' ><img src='./images/kml.png' height='70' style='padding-left:45px' ></div>";
                        iconstring = iconstring + "<div class='downloadIcons'><img src='./images/csv-512.png' height='70' style='padding-left:25px'></div>";                   
                        iconstring = iconstring + "<div class='downloadIcons'><img src='./images/inspire.jpg' height='70'></div>";
                        $("#downloadDialog").data('link', dataDownloadURL);
                        $("#downloadDialog").data('metaURL', MetaDownloadURL);
                        document.getElementById("downloadDialog").innerHTML = iconstring;   
                        $("#downloadDialog").dialog('open');  
                    }
                    else{
                        iconstring = iconstring + "<div class='downloadIcons' style='width:50%' ><img src='./images/kml.png' height='70' style='padding-left:20px' ></div>";
                        iconstring = iconstring + "<div class='downloadIcons' style='width:50%'><img src='./images/csv-512.png' height='70'></div>";                   
                        $("#downloadDataDialog").data('link', dataDownloadURL);
                        document.getElementById("downloadDataDialog").innerHTML = iconstring;   
                        $("#downloadDataDialog").dialog('open');   
             
                    }
                    
            }
            else{
                

            
                if(AllowMetaDownload === 'YES'){
                    iconstring = iconstring + "<div class='downloadIcons' style='width:100%'><img src='./images/inspire.jpg' height='70'></div>";
                    $("#downloadMetaDialog").data('metaURL', MetaDownloadURL);
                    document.getElementById("downloadMetaDialog").innerHTML = iconstring;  
                     $("#downloadMetaDialog").dialog('open'); 
                    
                }
                else{
                document.getElementById("noDownloadDialog").innerHTML = "No data is available for this layer to download";    
                $("#noDownloadDialog").dialog('open'); 
                }
                
               
                
            }
           
       
        
    }



function pollutionDisclaim(){
    document.getElementById("pollutionDialog").innerHTML = pollutionDialogString;
    $( "#pollutionDialog" ).dialog("open");    
}

function showPleaseWaitBox(){
    document.getElementById("pleaseWaitDialog").innerHTML = "<img src='./images/ajax-loader.gif' >";
    $( "#pleaseWaitDialog" ).dialog("open");
    }

function hidePleaseWaitBox(){
    document.getElementById("pleaseWaitDialog").innerHTML = "";
    $( "#pleaseWaitDialog" ).dialog("close");
}

function searchIndexMapLLPG(){
    var searchTerm = document.getElementById('searchfilterIndex').value;        
    if (searchTerm !== "")
	{
            startsearch(searchTerm);
	}
    else
        {
            alert("Please input a search term");
        }
}

function startsearch(searchTerm){
    showPleaseWaitBox();
        $.ajax({
            type: "POST",
            url: "./includes/processDataRequest.php",
            data:   { 
                        filter: searchTerm,
                        action: "search"
                    },      
            success: function(data) { 
                          hidePleaseWaitBox();
                          document.getElementById("IndexMapLLPGResults").innerHTML = data;
                          document.getElementById('IndexMapLLPGResults').style.visibility="visible";
                          //alert(data);
                         }   
            
        });
             
}

function zoomLLPGAddressIndMap(UPRN){
    document.getElementById('IndexMapLLPGResults').style.visibility="hidden";
    $.ajax({
            type: "POST",
            url: "./includes/processDataRequest.php",
            data:       { 
                        UPRN: UPRN,
                        action: "getXYLLPG"
                    },      
            success: function(data) {
                                //alert(data);
                                var obj = JSON.parse(data);
                                waitforResponseXYCoords(obj.xyCoords[0].X,obj.xyCoords[0].Y);              
                         }               
        });


    

    
}


var vectorLayer;
var xy = new Array();

function waitforResponseXYCoords(xCord,yCord){
    
    if (xy.length >0) {
        map.removeLayer(vectorLayer);
      
    }
    
    //var obj = JSON.parse(data);
    xy = [xCord, yCord];
    markerCoords = ol.proj.transform(xy, 'EPSG:27700', 'EPSG:3857');
    //alert(markerCoords);
    
    var iconFeature = new ol.Feature({
        geometry: new ol.geom.Point(markerCoords)
        });
        var iconStyle = new ol.style.Style({
                image: new ol.style.Icon(/** @type {olx.style.IconOptions} */ ({
                anchor: [0.5, 46],
                anchorXUnits: 'fraction',
                anchorYUnits: 'pixels',
                opacity: 0.75,
                src: './images/marker.png',
                zIndex: 100000
            }))
        });
        iconFeature.setStyle(iconStyle);
        var vectorSource = new ol.source.Vector({
  features: [iconFeature]
});

vectorLayer = new ol.layer.Vector({
  name: "addressLocation",
  source: vectorSource
});



      map.addLayer(vectorLayer);
      view.setCenter(markerCoords);
      view.setZoom(19);
    
      var radiobtn = document.getElementById("OSRadioButton");
      radiobtn.checked = true;
      toggleBaseLayers("OrdnanceSurvey");
       //OpenStreetMapLayer.setVisible(false);
       //map.addLayer(OSMasterMapLayer);
    
}

function changeRowColour(row){
    var rowArray=new Array();
    rowArray[0] = row;
    document.getElementById(rowArray[0]).style.backgroundColor="#92a585";
}

function changeRowColourBack(row, oldcolour){
    var rowArray=new Array();
    rowArray[0] = row;
    document.getElementById(rowArray[0]).style.backgroundColor=oldcolour;
}