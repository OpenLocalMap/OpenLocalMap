<?php
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




require_once("./includes/DBconn_Live_1.php");
class tocCreater {

 
function returnSectionHeadings($level){
    //This is used
switch ($level){
    case 1:
        //All Section Headings
        $query = "select distinct GROUP1, MENUORDER from ".metaschema.".".metatable." order by MENUORDER"; 
        $column = "GROUP1";
        break; 
    case 2: 
        //Section Headings with Sublevel in (For using in logic, when deciding whether to include a 2nd Accordian)
        $query = "select distinct GROUP1 from ".metaschema.".".metatable." where GROUP2 is NOT NULL";
        $column = "GROUP1";
        break;        
    case 3: 
        //Section Headings with second Sublevel in (For using in logic, when deciding whether to include a 3rd Accordi
        $query = "select distinct GROUP2 from ".metaschema.".".metatable." where GROUP3 is NOT NULL";
        $column = "GROUP2";
        break;

}
    $this->DB_connection->setStid($query);
    $totalArray = $this->DB_connection->getArray();
     return $this->stripArray($totalArray, $column);    
}


function returnLayerlist($sectionTitle, $Level){
    //this is used
        switch ($Level) {
            case 1:
                //Returns layers from 0 sublevels
                $query = "select LAYERNAME as LNAME, FRIENDLYNAME as FNAME, WORKSPACE as WS, GROUP1 as GRP1B, GROUP2 as GRP2B, ITEMORDER, META_XML_LOCATION, ALLOWDATADOWNLOAD, ALLOWMETADOWNLOAD from ".metaschema.".".metatable." where GROUP1 like '".$sectionTitle."' order by ITEMORDER";              
            break;
            case 2:
                //Returns all layers from 1st sublevel (Using sublevel section header variable as part of query)
                $query =  "select LAYERNAME as LNAME, FRIENDLYNAME as FNAME, GROUP3 as GRP3, WORKSPACE as WS, META_XML_LOCATION, ALLOWDATADOWNLOAD, ALLOWMETADOWNLOAD from ".metaschema.".".metatable." WHERE GROUP2 like '".$sectionTitle."'";                
            break;
            case 3:
                 //Returns all layers from 2nd sublevel (Using sublevel section header variable as part of query)
                $query =  "select LAYERNAME as LNAME, FRIENDLYNAME as FNAME, GROUP3 as GRP3, WORKSPACE as WS, META_XML_LOCATION, ALLOWDATADOWNLOAD, ALLOWMETADOWNLOAD from ".metaschema.".".metatable." WHERE GROUP3 like '".$sectionTitle."'";
            break;

        }
        
        
        
        $this->DB_connection->setStid($query);
        return $this->DB_connection->getArray();
 }
 

 function returnsubLayers($sectionTitle, $Level){
    //this is used
        switch ($Level) {
    
        
            case 1:
            //Select all section headings in first sublevel (for 2rd level accordian)
            $query =  "select distinct GROUP2 from ".metaschema.".".metatable." WHERE GROUP1 like '".$sectionTitle."'"; 
            $column = "GROUP2";
            break;
        
            case 2:
            //Select all section headings in second sublevel (for 3rd level accordian)
            $query =  "select distinct GROUP3 from ".metaschema.".".metatable." WHERE GROUP2 like '".$sectionTitle."'"; 
            $column = "GROUP3";
            break;
                
        }
        
        $this->DB_connection->setStid($query);
        $totalArray =$this->DB_connection->getArray();

     return $this->stripArray($totalArray, $column); 
        
        
 }

 
function stripArray($totalArray, $column){
    $i =0; 
    $cleanArray =  array();
      foreach ($totalArray as $valueA) {
          
         $cleanArray[$i] = $valueA[$column];
          $i++;
     }        
     return $cleanArray;
    
}
 
 
 
 function __construct() {
     $this->DB_connection = new DBconn_Live1;
 }
 
 

 
 
 
 
}
