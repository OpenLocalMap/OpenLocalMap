
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

//////////////////IE Stuff////////////////////////////////////////////////////
$(function () {
            // Detecting IE
     
            if ($('html').is('.ie6, .ie7, .ie8')) {
               
                  document.getElementById("oldIEDialog").innerHTML = "This application requires Internet Explorer 9 and above to work correctly. Please upgrade your browser or use Mozilla Firefox or Google Chrome";
                  $( "#oldIEDialog" ).dialog("open");    
        
            }
            });

//////////////////////////////////////////////////////////////////////////////


//////////////////////////POP UP STUFF//////////////////////////////////////
var container = document.getElementById('popup');
var content = document.getElementById('popup-content');
var closer = document.getElementById('popup-closer');

//closer not rendered yet, use jquery?
closer.onclick = function() {
  container.style.display = 'none';
  closer.blur();
  return false;
};
        
var overlay = new ol.Overlay({
  element: container
});


/////////////////////////////////////////////////////////////////////////////


////////////////////STUFF FOR TAKING LAT LONG FROM HEADER////////////////////
          var myappurl = window.location.search;
          var urlquery = myappurl.split("&");
          var slice1 = String(urlquery.slice(1, 2));
          var slice2 = String(urlquery.slice(2, 3));

          var lat = Number(slice1.substr(4));  //'534094';
          var lon = Number(slice2.substr(4)); // '184677';
          var centerCoords; 

          proj4.defs("EPSG:27700","+proj=tmerc +lat_0=49 +lon_0=-2 +k=0.9996012717 +x_0=400000 +y_0=-100000 +ellps=airy +towgs84=446.448,-125.157,542.06,0.15,0.247,0.842,-20.489 +units=m +no_defs");

         if (lon === 0 ){

             zoom =13;
             centerCoords = [-6500, 6719165];

         } 
            else 
         {           

             zoom = 20;
             centerCoords = ol.proj.transform([lat,lon], 'EPSG:27700', 'EPSG:3857');

         }
///////////////////////////////////////////////////////////////////////////////


///Global - Change!///////
var wmsURL = 'link to wms goes here';
var boundaryName = "name to give boundary";
var boundaryWMSname = "wms boundary name";

//////////////////////////////////////

var imageFormat = 'image/png';
var OpenStreetMapLayer =  new ol.layer.Tile({ 
     name: "OpenStreetMap", 
     source: new ol.source.OSM()
    });


var attribution = "<div style='width:220px'><img src='./images/os_logo.gif' height=20px><span> &copy;Crown Copyright 2014. 100019635</span><div>";
var initialBoundary = new ol.layer.Tile({
    name: boundaryName,
    source: new ol.source.TileWMS({
      url: wmsURL,
      params: { 'LAYERS': boundaryWMSname, 
                'FORMAT': imageFormat, 
                'TILED': true},
      serverType: 'geoserver'
  })
});

var OSMasterMapLayer = new ol.layer.Tile({
      name: "OSMasterMap", 
      source: new ol.source.TileWMS({
      url: wmsURL,
      params: {'LAYERS': 'osmm:OSMM_WEB', 
               'FORMAT': imageFormat, 
               'TILED': true},
      serverType: 'geoserver',
      attributions: [
            new ol.Attribution({
                html: attribution                
            })
        ]
  })
});





var Projection = new ol.proj.Projection({
    code: 'EPSG:3857',
    units: 'm'
});

var view = new ol.View({
    projection: Projection,
    center: centerCoords,    
    zoom: zoom
});

var map = new ol.Map({
    target: 'map',
    layers: [OpenStreetMapLayer,initialBoundary],
    view: view,
    overlays: [overlay]
});


var wmsSource = new ol.source.TileWMS({
    params: {
                'LAYERS': boundaryWMSname,
                'FORMAT': imageFormat
            },                       
    serverType: 'geoserver',
    url: wmsURL
});      



    map.addControl(new ol.control.ZoomSlider()); 
    map.addControl(new ol.control.ScaleLine({           
        projection: Projection      
    }));



var resetHome = function(e) {
  // prevent #resetHome anchor from getting appended to the url
  e.preventDefault();
  measureShutdown();
  shutdownDraw();
  toggleBaseLayers("OpenStreetmap");

  map.getView().setCenter([-6500, 6719165]);
  map.getView().setZoom(13);
  if (xy.length >0) {
        map.removeLayer(vectorLayer);
      
    }
    document.getElementById('OSMRadioButton').checked = true;
    
    map.getLayers().forEach(function(layer){
        
        if (layer.get('name') === "OpenStreetMap" ||
             layer.get('name') === "OSMasterMap"   || 
              layer.get('name') === boundaryName   || 
                layer.get('name') === "addressLocation"   
                )
            {
               
                    
                }
            else{
                layer.setVisible(false);
              
            }


     


    }); 
                    
        uncheckall();                                                               

    
};

///////MEASURING STUFF/////////////////
var measureLayer;
var measure;
var measureSwitch = false; 
var lengthTotal = 0;
var lastCoord =[];
var length;
var eventobjectLength;
var infoObject;

var measureStyle = new ol.style.Style({
                    fill : new ol.style.Fill({
                            color : 'rgba(255, 255, 255, 0.2)'
                    }),
                    stroke : new ol.style.Stroke({
                            color : '#009933',
                            width : 2
                    }),
                    image : new ol.style.Circle({
                            radius : 7,
                            fill : new ol.style.Fill({
                                    color : '#009933'
                            })
                    })
                    });


function measureShutdown(){
    
    map.un('singleclick',calcLength,eventobjectLength);
    map.on('singleclick', startInfoWindow, infoObject);
    measureSwitch =false;
    map.removeInteraction(measure);

    lengthTotal = 0;
    lastCoord = [];

    document.getElementById("measureResults").style.visibility="hidden";
    
}


function resetTotal(){
    lengthTotal = 0;
    document.getElementById("totalLength").innerHTML = " = 0m";
}

function startMeasure(e) {
      e.preventDefault();
    shutdownDraw();
    map.un('singleclick',startInfoWindow, infoObject);
    if (measureSwitch ===false){
                measureSwitch =true;
                
                measureLayer = new ol.layer.Vector({
                        source : new ol.source.Vector(),
                        style : measureStyle
                });
                
                measure = new ol.interaction.Draw({
                        source:measureLayer.getSource(),
                        type: 'LineString'
                });
                
                map.addInteraction(measure);

                document.getElementById("elementlength").innerHTML = " = 0m";
                document.getElementById("totalLength").innerHTML = " = 0m";
                document.getElementById("measureResults").style.visibility="visible";
                
                map.on('singleclick', calcLength, eventobjectLength);
                map.on('dblclick', endElementDraw, eventobjectLength);
    }
    else {

        measureShutdown();

    }
    
    
};



function endElementDraw(evt){
    lengthTotal = 0;
    length = 0;
    lastCoord = [];

    }
    

function calcLength(evt){
        var newCoord = ol.proj.transform(evt.coordinate, 'EPSG:3857','EPSG:27700');
        document.getElementById("elementlength").innerHTML = " = 0m";
        document.getElementById("totalLength").innerHTML = " = 0m";
        if (lastCoord.length > 0){
            
             var elementLine = new ol.geom.LineString([newCoord,lastCoord]);

            length = Math.round(elementLine.getLength() );
            lengthTotal = lengthTotal + length; 
            document.getElementById("elementlength").innerHTML = " = " + length + "m";
            document.getElementById("totalLength").innerHTML = " = " + lengthTotal + "m";
            document.getElementById("measureResults").style.visibility="visible";
            lastCoord = newCoord;       
            
            
        }
        
        else{
          lastCoord = newCoord;
         
        }
        
        };
          
  
 
///////////////////////DRAWING STUFF//////////////////////////////  
var draw;
var drawLayer;
var drawSwitch = false; 

function startDraw(e, shapeType){
    e.preventDefault();
if (shapeType === "LineString"){
    document.getElementById("shapeID").innerHTML = "Line";
}
else{
    document.getElementById("shapeID").innerHTML = shapeType;
}




  
        map.removeInteraction(draw);
        map.removeLayer(drawLayer);
        drawLayer = new ol.layer.Vector({
        source : new ol.source.Vector(),
            style : new ol.style.Style({
                    fill : new ol.style.Fill({
                            color : 'rgba(255, 255, 255, 0.2)'
                    }),
                    stroke : new ol.style.Stroke({
                            color : '#009933',
                            width : 2
                    }),
                    image : new ol.style.Circle({
                            radius : 7,
                            fill : new ol.style.Fill({
                                    color : '#009933'
                            })
                    })
            })
        });
        
        draw = new ol.interaction.Draw({
              source:drawLayer.getSource(),
              type: shapeType
      });
    map.addLayer(drawLayer);
    map.addInteraction(draw);
    
 
     
     
};


function shutdownDraw(){

    
    map.on('singleclick', startInfoWindow, infoObject);    
    document.getElementById("drawBox").style.visibility="hidden";
    //drawSwitch =false;
    map.removeInteraction(draw);
    map.removeLayer(drawLayer);
    document.getElementById("pointDiv").style.visibility="hidden";
    document.getElementById("lineDiv").style.visibility="hidden";
    document.getElementById("polyDiv").style.visibility="hidden";
    drawOpenToggle = false;
    
}


var a = document.getElementById('anchor');
a.addEventListener('click', resetHome, false);
a.addEventListener('touchstart', resetHome, false);


var c = document.getElementById('measureLink');
c.addEventListener('click', startMeasure, false);
c.addEventListener('touchstart', startMeasure, false);




var b = document.getElementById('drawLink');
b.addEventListener('click', showDrawOptions, false);
b.addEventListener('touchstart', showDrawOptions, false);

var d= document.getElementById('pointLink');
d.addEventListener('click', function(e){ startDraw(e, "Point"); }, false);
d.addEventListener('touchstart', function(e){  startDraw(e, "Point"); }, false);

var e= document.getElementById('lineLink');
e.addEventListener('click', function(e){ startDraw(e, "LineString"); }, false);
e.addEventListener('touchstart', function(e){ startDraw(e, "LineString"); }, false);

var f= document.getElementById('polyLink');
f.addEventListener('click', function(e){ startDraw(e, "Polygon"); }, false);
f.addEventListener('touchstart', function(e){ startDraw(e, "Polygon"); }, false);

        
map.addControl(new ol.control.Control({element: document.getElementById('rnc')}));
map.addControl(new ol.control.Control({element: document.getElementById('drawDiv')}));
map.addControl(new ol.control.Control({element: document.getElementById('measureDiv')}));
map.addControl(new ol.control.Control({element: document.getElementById('pointDiv')}));
map.addControl(new ol.control.Control({element: document.getElementById('lineDiv')}));
map.addControl(new ol.control.Control({element: document.getElementById('polyDiv')}));

var drawOpenToggle = false; 
function showDrawOptions(evt){
    evt.preventDefault();
    measureShutdown();
    document.getElementById("drawBox").style.visibility="visible";

    if (drawOpenToggle === false){
        map.un('singleclick',startInfoWindow, infoObject);
        document.getElementById("pointDiv").style.visibility="visible";
        document.getElementById("lineDiv").style.visibility="visible";
        document.getElementById("polyDiv").style.visibility="visible";
        drawOpenToggle = true;
    }
    else {
        shutdownDraw();
        
    }

}


/////////////////////////INFOWINDOW STUFF//////////////////////////////////////

map.on('singleclick', startInfoWindow, infoObject);

function startInfoWindow(evt){
    
  content.innerHTML = '';
  
  var coordinate = evt.coordinate; //Picks up click coordinates
  var viewResolution = view.getResolution(); //Picks up map current resolution
  var layersCollection3 = map.getLayers(); 

  //NEED TO REPLACE THIS BIT WITH ALL VSIBLE LAYERS

var i;
var LayerString = ""; 

    for (i = 0; i <= ((layersCollection3.a.length-1)); i++)
    {                                                  

        if (layersCollection3.item(i).p.name === "OpenStreetMap" ||
             layersCollection3.item(i).p.name === "OSMasterMap"   || 
              layersCollection3.item(i).p.name === boundaryName   || 
                layersCollection3.item(i).p.name === "addressLocation"   
                )
            {
               
                    
                }
            else{
                
                if (layersCollection3.item(i).getVisible() === true){
                    LayerString = LayerString + layersCollection3.item(i).p.name + ",";
                }
            }
    }   



var LayerStringTrim = LayerString.substring(0, LayerString.length - 1);


getURL(LayerStringTrim, coordinate,viewResolution);

}

  var superCoord; 
  
function getURL(LayerStringTrim, coordinate,viewResolution){
    
    superCoord = coordinate;
    
    var url = initialBoundary.getSource().getGetFeatureInfoUrl(coordinate, viewResolution, Projection,
            {
             'INFO_FORMAT': 'text/javascript',
             'QUERY_LAYERS':LayerStringTrim,  
             'LAYERS':LayerStringTrim,      
             'feature_count':'10'
            });

    url = url + "&format_options=callback:getJson";
    
    getJSON(url);

}




function getJSON(url){
    

    $.ajax({
                        jsonp: false,
                        jsonpCallback: 'getJson',
                        type: 'GET',
                        url: url,
                        async: false,
                        dataType: 'jsonp',
                        success: function(data) {
                            useJSON(data);
                        }
                    });
                
}
var numberRecords;
function useJSON(data){
    numberRecords =0;
    var i = 0;
    var layername =  [2];
    var layerlist =[];
    for (i = 0; i < data.features.length; i++ ){
        layername  = data.features[i].id.split(".");
        //console.log(layername);
        layerlist[i]= layername;
    }
    numberRecords = i;
    var dataString = JSON.stringify(layerlist);
    getDataFromDB(dataString);
}


function getDataFromDB(datastring){
    $.ajax({
                        type: "POST",
                        url: "./includes/processDataRequest.php",
                        data:       { 
                                    action: 'getData',
                                    layerlist: datastring
                                },      
                        success: function(data) {
                                  //console.log(datastring);
                                    var obj = JSON.parse(data);
                                       //console.log(obj);
                                       useMyJson(obj);  
                                     }               
                    });
          
    
}
    
var iconWMS = wmsURL + "REQUEST=GetLegendGraphic&VERSION=1.0.0&FORMAT=image/png&WIDTH=20&HEIGHT=20&LAYER=";

function useMyJson(obj){

    var htmlString = "<div id ='itemContainer' >";
    if (numberRecords > 1) {
        htmlString = htmlString + "<div style='font-family:Quattrocento Sans; padding: 5px; font-size: 12px; width:100%; text-align:left'> <i>" + numberRecords + " records found</i></div>";
    }
    var i = 0;
    
      for (i = 0; i < obj.length; i++ ){
          htmlString = htmlString + "<div class='itemFeatureInfo'>";
          htmlString = htmlString + "<span ><img style='margin-bottom:-3px' src='" + iconWMS + obj[i].GeoserverLayer + "'></span><span class='itemHeader'>&nbsp" + obj[i].LayerName + "</span><br/><br/>";
          //console.log(obj[i]);
             for (var key in obj[i]) {  
                    if (obj[i].hasOwnProperty(key)) {
                        if (obj[i][key] !== undefined){
                            if  (key !== "LayerName"){
                                if  (key !== "GeoserverLayer"){
                                    htmlString = htmlString + "<span class='attributeKey'>" + key + ":</span>" + "<span class='attributeValue'>" + obj[i][key] + "</span>";
                                    htmlString = htmlString + "<br/>";
                                 }
                            }
                        }
                    }
                }
        
          htmlString = htmlString + "</div><br/>";
         
     
         }
    
    htmlString = htmlString + "</div>";

    overlay.setPosition(superCoord);
    content.innerHTML = htmlString;
    container.style.display = 'block';
    
     
}




   


  if (lon > 0 ){
  waitforResponseXYCoords(lat,lon);
  
  }

function extractBaseLayerName(element){
    
    var baselayername = String(element.value);
        toggleBaseLayers(baselayername);
}

function toggleBaseLayers(baselayername){

    var layers = map.getLayers().getArray();

    var layerTester = layers.filter(function(layer)
        {

                return layer.get('name') === "OSMasterMap";
        }
        ); 

    switch (baselayername){
           case "OpenStreetmap" : 
            OpenStreetMapLayer.setVisible(true);
            OSMasterMapLayer.setVisible(false);

            break;
        
        
        case "OrdnanceSurvey" :
            OpenStreetMapLayer.setVisible(false);

                if (layerTester.length === 0){
                    map.addLayer(OSMasterMapLayer);
                    OSMasterMapLayer.setVisible(true);//Need this as well because otherwise reset function hides even if added for first time. 
    
                    //this takes layer from top , puts in an object ,then reinserts at bottom
                    var layersCollection = map.getLayers();
             
                    var topLayer = layersCollection.removeAt((layersCollection.a.length)-1);
   
                    layersCollection.insertAt(1, topLayer);
                }

                else   {
                OSMasterMapLayer.setVisible(true);
                }
                
                
                
            break;


            
    }
}


function toggleLayer(element){
        
        

var layername = String(element.value);


var layers = map.getLayers().getArray();

var layerTester = layers.filter(function(layer)
{

    return layer.get('name') === layername;
}
); 



if (layerTester.length === 0){
             
                    var Layer_new = new ol.layer.Tile({
                        name: layername, 
                        source: new ol.source.TileWMS({

                        params: {
                        'LAYERS': layername,
                        'FORMAT': imageFormat

                        },
                        serverType: 'geoserver',
                        url: wmsURL
                        })
                      });  
                      
                      map.addLayer(Layer_new);
          

            }
    else    {
    
                    map.getLayers().forEach(function(layer){
                    if (layer.get('name') === layername) {
                        if (element.checked === true){
                      
                            layer.setVisible(true);
                        }
                        else {
                        
                            layer.setVisible(false);
                        }
                    }
                    });
            }

    
  };  




