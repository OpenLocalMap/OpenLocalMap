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

class getColumnsClass {
    

    private $live_DB;
    private $totalArray = array();   
    private $query; 
    private $columnString; 
    
    function __construct() {
        $this->live_DB = new DBconn("Meta");
    }    
    function getPopUpData($layerlist){
        $layerArray = json_decode($layerlist);
        foreach ($layerArray as $layer){
            $Layername = $layer[0];
            $RecordPK = $layer[1];
            //GET ORACLE NAME, FRIENDLYNAME DATACOLUMN NAMES and FRIENDLY NAMES for Layer 
            
            $this->query = "select * from ".metaschema.".".metatable." where LAYERNAME = '".$Layername."'";             
            $this->live_DB->setStid($this->query);  
            $LayerStuff = $this->live_DB->getArray();
            
            $FriendlyLayer = $LayerStuff[0]['FRIENDLYNAME'];
            $Workspace  = $LayerStuff[0]['WORKSPACE'];

            
            $Column1 = $LayerStuff[0]['DATA1'];
            $Column2 = $LayerStuff[0]['DATA2'];
            $Column3 = $LayerStuff[0]['DATA3'];
            $Column4 = $LayerStuff[0]['DATA4'];
            $Column5 = $LayerStuff[0]['DATA5'];
            
            $Friendly1 = $LayerStuff[0]['DATAFRIENDLY1'];
            $Friendly2=  $LayerStuff[0]['DATAFRIENDLY2'];
            $Friendly3 = $LayerStuff[0]['DATAFRIENDLY3'];
            $Friendly4 = $LayerStuff[0]['DATAFRIENDLY4'];
            $Friendly5 = $LayerStuff[0]['DATAFRIENDLY5'];
                    
                //BUILD UP COLUMN LIST
            
             
            if (!empty($Column1)){                
                $this->columnString = $Column1;
            }
              if (!empty($LayerStuff[0]['DATA2'])){                
                        $this->columnString = $this->columnString.", ".$LayerStuff[0]['DATA2'];         
              }
               if (!empty($LayerStuff[0]['DATA3'])){                
                        $this->columnString = $this->columnString.", ".$LayerStuff[0]['DATA3'];            
              }
              
               if (!empty($LayerStuff[0]['DATA4'])){                
                        $this->columnString = $this->columnString.", ".$LayerStuff[0]['DATA4'];            
                }
              
               if (!empty($LayerStuff[0]['DATA5'])){                
                        $this->columnString = $this->columnString.", ".$LayerStuff[0]['DATA5'];            
              }
              
            
    
              
              
            //SEARCH ORACLE TABLE for record values using ORALCE NAME AND DATACOLUMN NAMES 
            //HAVE TO USE MI_PRINX AS STANDARD PK FOR NOW. COULD STORE IN LAYER. 
            $this->query = "select ".$this->columnString." from ".$LayerStuff[0]['ORACLENAME']." where MI_PRINX = '".$RecordPK."'"; 
            
            $this->live_DB->setStid($this->query);      
            $RecordStuff = $this->live_DB->getArray();
            $FinalArray = array();
            $FinalArray["LayerName"] = $FriendlyLayer;
            
            $FinalArray["GeoserverLayer"] = $Workspace.":".$Layername;
            
             if (!empty($RecordStuff[0][$Column1])){             
                        $FinalArray[$Friendly1] = $RecordStuff[0][$Column1];
              }
            if (!empty($RecordStuff[0][$Column2])){            
                        $FinalArray[$Friendly2] = $RecordStuff[0][$Column2];
            } 
            if (!empty($RecordStuff[0][$Column3])){                
                        $FinalArray[$Friendly3] = $RecordStuff[0][$Column3];
            } 
              if (!empty($RecordStuff[0][$Column4])){             
                        $FinalArray[$Friendly4] = $RecordStuff[0][$Column4];
            } 
               if (!empty($RecordStuff[0][$Column5])){             
                        $FinalArray[$Friendly5] = $RecordStuff[0][$Column5];
            } 

            
            //ADD ALL TO ARRAY
            
              array_push($this->totalArray,$FinalArray);
          
        }
        
        //ENCODE TO JSON
        
        return json_encode($this->totalArray);
    }
    
    
     
}
