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

class queryClass {
 //NEEDS TO MODIFIED 
  
   public static function getLLPGSearchQuery($numofterms,$result){
        
        $LLPGquery = "SELECT UPRN as UPRN, FLATNAME, FLATNUMBER, \"NAME\" as NAME1, STREETNUMBER as NUMBER1, STREET,POSTCODE, POSTTOWN as POSTTOWN1 ";
        $LLPGquery = $LLPGquery."FROM ".LLPGtable." WHERE"; //FROM LIVE
        
          for ($i = 0; $i < count($result[0]); $i++) {
                                            if ($i < ($numofterms-1)){
                                                    $LLPGquery = $LLPGquery." CONTAINS (POSTTOWN, '".$result[0][$i]."') > 0 ";
                                                    $LLPGquery = $LLPGquery." AND ";                                 

                                            }
                                            else {

                                                $LLPGquery = $LLPGquery." CONTAINS (POSTTOWN, '".$result[0][$i]."') > 0 ";
                                            }
                                        }
        $LLPGquery = $LLPGquery." ORDER BY STREET ASC ";//NEEDS TO BE BY FLATNAME?
        
        return $LLPGquery;
    }
    
   
            
            public static function getXYofLLPGpoint($UPRN){
                
                $xyQuery = "select t.x as X, t.y as Y "; 
                $xyQuery = $xyQuery."from ".LLPGtable." a, "; 
                $xyQuery = $xyQuery."table(sdo_util.getvertices(a.GEOLOC)) t ";
                $xyQuery = $xyQuery."where a.UPRN = ".$UPRN;
                            
               return $xyQuery;             
            }
           
            
}



?>
