<?php header( 'X-UA-Compatible: IE=edge,chrome=1' ); ?>


 <!--OpenLocalMap OpenSource web mapping for local government
    Copyright (C) <2014>  <Ben Calnan>

    This program is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program.  If not, see <http://www.gnu.org/licenses/>.
-->



<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<!doctype html>
<!--[if lt IE 7 ]> <html class="ie6"> <![endif]-->
<!--[if IE 7 ]>    <html class="ie7"> <![endif]-->
<!--[if IE 8 ]>    <html class="ie8"> <![endif]-->
<!--[if IE 9 ]>    <html class="ie9" xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en"> <![endif]-->
<!--[if (gt IE 9)|!(IE)]><html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en" class=""> <![endif]-->



<!--<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">-->
<head>
<meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=9" />
        <title>OpenLocalMap</title>
        
            <link href="http://cdnjs.cloudflare.com/ajax/libs/ol3/3.11.1/ol.css" rel="stylesheet"  type="text/css">
            <link href="./css/styling.css" type="text/css" rel="stylesheet"></link>
            <link href="http://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.11.1/jquery-ui.css" rel="stylesheet" >
            
            <script src="http://cdnjs.cloudflare.com/ajax/libs/ol3/3.11.1/ol.js" type="text/javascript"></script>
            <script src="http://cdnjs.cloudflare.com/ajax/libs/jquery/1.11.0/jquery.js"></script>
            <script src="http://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.11.1/jquery-ui.min.js"></script>
            <script src="http://cdnjs.cloudflare.com/ajax/libs/proj4js/2.2.1/proj4.js"></script>
            <script src="./js/variableSetup.js"></script>
            <script src="./js/LLPGSearch.js"></script>

        <link rel="stylesheet" href="v3.0.0/resources/layout.css">
</head>
    
    
<body onload="uncheckall()" >
        <div id="pollutionDialog" title="Disclaimer" style="font-size:12px"></div>
        <div id="pleaseWaitDialog" title="Please Wait" >></div>
        <div id="oldIEDialog" title="Upgrade Browser"></div>
        <div id="downloadDialog" title="Download Data"></div>
        <div id="downloadDataDialog" title="Download Data"></div>
        <div id="downloadMetaDialog" title="Download Data"></div>
        <div id="noDownloadDialog" title="Data unavailable"></div>
         
<!--Rebrand as necessary-->
<div style="position: absolute; top: 0%; width:100%; height:10%;font-size: 42px; color:grey;background-color: white; font-family: arial; padding-top:10px">< Open<span style="color:yellow">Local</span>Map > </div>     
   

<div style='position: absolute; top: 10%; width:100%; height:90%;'>
<div id='TOC' style ='position: relative; height:100%; width:25%;float:left; font-family: arial; overflow-y: auto'>
    
<div style = 'text-align:left'  class = "accordion">
    <!--This needs to go into metadata -->
<h3>Base Layers</h3>
    <div>
            <li  >
                <input name='baseRadio' id='OSMRadioButton' value='OpenStreetmap' checked='checked' type='radio' onclick="extractBaseLayerName(this)" autocomplete='off'>       
                OpenStreetMap
            </li>
          <li>
                <input name='baseRadio' id='OSRadioButton' value='OrdnanceSurvey' type='radio'  autocomplete='off' onclick="extractBaseLayerName(this)" >
                Ordnance Survey<br>
            </li>
            
   
    </div>


<?php 
    include("./includes/variableSetup.php");
    require_once("./includes/tocCreater.php");
    
    $tocObject1 = new tocCreater();
    $wmsURL = wmslegendURL;
   
    $totalArray = $tocObject1->returnSectionHeadings(1);
    $level2sArray = $tocObject1->returnSectionHeadings(2);
    $levels3Array = $tocObject1->returnSectionHeadings(3);
    
    $resultString = "";
    $resultString2 = "";
    $resultString3 = "";
    
     
    foreach ($totalArray as $arrayValue) {
       
           $yesno = in_array($arrayValue, $level2sArray);
             
                $resultString = $resultString."<h3>".$arrayValue."</h3>";
                $resultString = $resultString."<div>";  
                
           if ($yesno == false){ //DOES DIV CONTAIN A SECOND TIER ONE?  IF NO.
                       $layerlist1Array = $tocObject1->returnLayerlist($arrayValue,1);
                        foreach ($layerlist1Array as $layerlist1Value){
                                    $LayerAddress = $layerlist1Value['WS'].":".$layerlist1Value['LNAME']; 
                                    $resultString = $resultString."<li style=\"list-style-image:url('".$wmsURL.$layerlist1Value['WS'].":".$layerlist1Value['LNAME']."')\">";                                     
                                    $resultString = $resultString."<span class='pointer' onclick=\"showDownload('".$LayerAddress."','".$layerlist1Value['META_XML_LOCATION']."','".$layerlist1Value['ALLOWDATADOWNLOAD']."','".$layerlist1Value['ALLOWMETADOWNLOAD']."')\" ><img src='images/download164.png' alt='Download this Layer as KML' style='width:16px;height:16px;border:0; padding-right:3px;'></span> ";
                                    $resultString = $resultString."<input type=\"checkbox\" class=\"checkBoxClass\" value='".$layerlist1Value['WS'].":".$layerlist1Value['LNAME']."' onclick=\"toggleLayer(this)\"  >";    
                                    $resultString = $resultString.$layerlist1Value['FNAME'];  
                                    $resultString = $resultString."</li>";   
                            } 
                           
                    }
           else { //YES DOES CONTAIN A SECOND TIER ONE

                
                $resultString = $resultString."<div style = 'text-align:left' id ='dialogAccordian' class='accordion2'>";//SECOND TIER ACCORDIAN
                $subArray2 = $tocObject1->returnsubLayers($arrayValue,1);
                    foreach ($subArray2 as $searchValue2){
                        $yesno2 = in_array($searchValue2, $levels3Array);
                        $resultString = $resultString."<h3>".$searchValue2."</h3>";
                        $resultString = $resultString."<div>";  //Container Div for lists
                        
                         if ($yesno2==false){ //IF No level 3 then proceed to create normal level 2 divs. 
                             $layerlist2Array = $tocObject1->returnLayerlist($searchValue2,2); //Get layers in level2
                             foreach ($layerlist2Array as $layerlist2Value){     
                                         $LayerAddress2 = $layerlist2Value['WS'].":".$layerlist2Value['LNAME']; 
                                        $resultString = $resultString."<li style=\"list-style-image:url('".$wmsURL.$layerlist2Value['WS'].":".$layerlist2Value['LNAME']."')\">";                                          
                                        $resultString = $resultString."<span class='pointer' onclick=\"showDownload('".$LayerAddress2."','".$layerlist2Value['META_XML_LOCATION']."','".$layerlist2Value['ALLOWDATADOWNLOAD']."','".$layerlist2Value['ALLOWMETADOWNLOAD']."')\" ><img src='images/download164.png' alt='Download this Layer as KML' style='width:16px;height:16px;border:0; padding-right:3px;'></span> ";
                                         $resultString = $resultString."<input type=\"checkbox\" class=\"checkBoxClass\" value='".$layerlist2Value['WS'].":".$layerlist2Value['LNAME']."' onclick=\"toggleLayer(this)\"  >";    
                                        $resultString = $resultString.$layerlist2Value['FNAME'];  
                                        $resultString = $resultString."</li>";
                                     }
                             
                         }
                         else {
                            //LEVEL THREE GOES HERE
                            $resultString = $resultString."<div style = 'text-align:left' class='accordion3'>";//h2
                            $subArray3 = $tocObject1->returnsubLayers($searchValue2,2); 
                            foreach ($subArray3 as $subValue3){
                                $layerlist3Array = $tocObject1->returnLayerlist($subValue3,3);  
                                $resultString = $resultString."<h3>".$subValue3."</h3>";
                                $resultString = $resultString."<div>";                                        
                                
                                    foreach ($layerlist3Array as $layerlist3Value){     
                                         $LayerAddress3 = $layerlist3Value['WS'].":".$layerlist3Value['LNAME']; 
                                        $resultString = $resultString."<li style=\"list-style-image:url('".$wmsURL.$layerlist3Value['WS'].":".$layerlist3Value['LNAME']."')\">"; 
                                         $resultString = $resultString."<span class='pointer' onclick=\"showDownload('".$LayerAddress3."','".$layerlist3Value['META_XML_LOCATION']."','".$layerlist3Value['ALLOWDATADOWNLOAD']."','".$layerlist3Value['ALLOWMETADOWNLOAD']."')\" ><img src='images/download164.png' alt='Download this Layer as KML' style='width:16px;height:16px;border:0; padding-right:3px;'></span> ";                                        
                                        $resultString = $resultString."<input type=\"checkbox\" class=\"checkBoxClass\" value='".$layerlist3Value['WS'].":".$layerlist3Value['LNAME']."' onclick=\"toggleLayer(this)\"  >";    
                                   
                                        $resultString = $resultString.$layerlist3Value['FNAME'];
                                        
                                        $resultString = $resultString."</li>";
                                     }
                                
                                
                                
                                
                                $resultString = $resultString."</div>";//Closes Container Div for section (level3)  
                            }

                                 
                                 
                            $resultString = $resultString."</div>"; //Closes Accordian3
                         }
                         
                      $resultString = $resultString."</div>"; //Closes Container Div for section (level2)  
                    }
                    
                

                 // CLOSE TIER TWO STUFF          
                $resultString = $resultString."</div>"; //Closes Accordian2
           }
//        
                
//                //TIER ONE STUFF
                $resultString = $resultString."</div>"; //Closes Section one DIV           
    }
           
echo $resultString;

?>

<!--Closes Accordian1-->
                        </div> 
    
<!--    Closes TOC-->
                        </div>
    

    
                        <div id='map' style='height:100%; width:75%;float:left;'>
                         <!--<button class='draw-box' onclick='startDraw("LineString")' >Draw Lines</button>-->
                              <div id="SearchDivArea">
                                    <div id="indexMapSearchdiv">
                                    <span><input value="" type="text" id="searchfilterIndex" size="28" style="margin:3px 1px;padding:3px" title="Enter your search term here"></input>
                                    <input type="button" id="searchbutton" onclick="searchIndexMapLLPG()" value="Search LLPG" style="display:inline;  padding:2px" title="Click here to search the database for the search term" ></input></span>
                                    <div id="IndexMapLLPGResults"></div>  
                                    </div>
                              </div>
                       <div id="rnc" class="Home-button ol-unselectable">
                           <a id="anchor" href="#Home-button"><img src="images/home-icon.png" alt ="Home"></a>
                        </div>
                        <div id="drawDiv" class="draw-button ol-unselectable">
                            <a id="drawLink" href="#draw-button"><img src="images/draw-icon.png"></a>
                        </div>
                         
                         <div id="pointDiv" class="point-button ol-unselectable">
                            <a id="pointLink" href="#point-button"><img src="images/point-icon.png"></a>
                        </div>
                         
                        <div id="lineDiv" class="line-button ol-unselectable">
                            <a id="lineLink" href="#line-button"><img src="images/line-icon.png"></a>
                        </div>
                        <div id="polyDiv" class="poly-button ol-unselectable">
                            <a id="polyLink" href="#poly-button"><img src="images/poly-icon.png"></a>
                        </div>
                         
                             <div id="measureDiv" class="measure-button ol-unselectable">
                           <a id="measureLink" href="#measure-button"><img src="images/measure-icon.png"></a>
                        </div>
                         
                           <div id='popup' class='ol-popup'>
                                <a href='#' id='popup-closer' class='ol-popup-closer'></a>
                                <div id='popup-content'></div>                
                            </div>
                         
                        <div id="drawBox" style="text-align:left">
                                <div class="itemHeader" style="padding-bottom:10px;">
                                    <div style="width:220px; height:24px">
                                        <div style="width:90%; float:left">Drawing mode</div>
                                        <div class="pointer" onclick="shutdownDraw()" style="text-align: center; width:10%;float:left; color:black"><b>X</b>
                                        </div>
                                    </div>
<!--                                    <span><b>Drawing Mode</b></span>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
                                    <span class="pointer" style="color:black" onclick="shutdownDraw()">✖</span>-->
                                </div>
                                <div>
                                    <span class="attributeKey">Shape Type: </span>
                                    <span class="attributeValue" id ="shapeID" >None selected<span>
                                </div>
                        </div>
                            <div id="measureResults" style="text-align:left">
                                
                                <div class="itemHeader" style = "padding-bottom:10px;">
                                    <!--//<span><b>Distance</b></span>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp<span class="pointer" style="color:black" onclick="measureShutdown()">✖</span>-->
                                    <div style="width:220px; height:24px">
                                        <div style="width:90%; float:left">Measuring Tool</div>
                                        <div class="pointer" onclick="measureShutdown()" style="text-align: center; width:10%;float:left; color:black"><b>X</b></div>
                                    </div>
                                </div>
                                <div style = "padding-bottom:3px;"><span class="attributeKey">Element Length</span><span class="attributeValue" id ="elementlength" ><span></div>
                                            <div style = "padding-bottom:3px;"><span class="attributeKey">Total Length</span><span class="attributeValue" id ="totalLength" ></span></div>      
                            </div>
                        </div> 
    
                        
                                 
    
<!--    Closes TOC/Map Container -->
            </div>

            
   
<script type="text/javascript" src="./js/OL_layers.js"></script>
      
    </body>
</html>
