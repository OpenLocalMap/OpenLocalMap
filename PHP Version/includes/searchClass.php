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

class searchClass {
    
            private $filterString;
            private $numrows;
            private $searchArray;
            private $bgcolor="#ffffff";

            
            public function __construct() {
                $this->filterString = filter_input(INPUT_POST, 'filter');
                $query = $this->createSearchQuery();   
                $conn= new DBconn_LLPG();
                $conn->setStid($query);
                

        
                $this->searchArray = $conn->getArray();
                $this->numrows = $this->count_array();

                
                
            }
            
            
        private function count_array(){
                
                $count = 0;   

                foreach ($this->searchArray as $countValue)
                {
                    $count++;
                }
                    return $count;
            }

        public function returnSearchResults(){
                if ($this->numrows == 0)
                {                     
                        echo $this->return_no_results_Index_Map();             
                }
              
                else
                {
                        echo $this->return_results_Index_Map();
                                                   
                }
        }    
         
       
          private function return_no_results_Index_Map(){
            $no_results_string =  "<div style=\"padding: 5px 1px\">Sorry, your search: &quot;" . $this->filterString . "&quot; returned zero results </div>";                      
            return $no_results_string;
        }
        
        
     
    


    private function return_results_Index_Map(){

            $newCount=1;
           
            $results_string ="";
            $results_string = $results_string. "<div id='be'>" ;


                                    foreach ($this->searchArray as $searchValue){
                                        
                                                    $FlatName = "";
                                                    $FlatNumber ="";		
                                                    $BuildingName ="";   
                                                    $BuildingNumber  =""; 
                                        
                                                    //Picks up required data from main form
                                                    $UPRNData = $searchValue['UPRN'];
                                                    if($searchValue['FLATNAME']){
                                                       $FlatName =ucwords(strtolower($searchValue['FLATNAME'])).",";  
                                                    }
                                                    
                                                      if($searchValue['FLATNUMBER']){
                                                         $FlatNumber= $searchValue['FLATNUMBER'].",";  
                                                      }                                             
                                                    if($searchValue['NAME1']){

                                                        $BuildingName = ucwords(strtolower($searchValue['NAME1'])).",";  
                                                      }     
                                                      if($searchValue['NUMBER1']){
                                                           $BuildingNumber = $searchValue['NUMBER1'].",";  
                                                      }     



                                                    $StreetData = ucwords(strtolower($searchValue['STREET'])).","; 
                                                    $TownData = ucwords(strtolower($searchValue['POSTTOWN1']));
                                                    $PostcodeData = $searchValue['POSTCODE'];


                                                   $this->setBackgroundColour();
                                                   $addressString= $FlatName." ".$FlatNumber." ".$BuildingName." ".$BuildingNumber." ".$StreetData." ".$TownData." ".$PostcodeData;


                                                    $rowNumber = $newCount;
                                                
                                                    
                                                    $results_string = $results_string."<div style=\"padding: 5px 1px; border-bottom-style:solid; border-bottom-width:1px; border-color:#C0C0C0\" id=$rowNumber onmouseout=\"changeRowColourBack($rowNumber,'')\" onmouseover=\"changeRowColour($rowNumber)\" title=\"Click here to see more information\" onclick=\"zoomLLPGAddressIndMap($UPRNData)\">";                                
                                                   
                                                
                                                            $results_string = $results_string."<div id='Abstract' style='height:33px; text-align:left;'>";

                                                
                                                                    $results_string = $results_string."<div style='float:left; width:15%; padding-left:5px'><img src='./images/marker.png'></div>";
                                                                    $results_string = $results_string."<div><span class=\"pointer\">".$addressString."</span></div>";		


                                                            $results_string = $results_string."</div>";     
                                                    $results_string = $results_string."</div>";

                                                    $newCount++;

                                                    
                                                }
    $results_string = $results_string. "</div>";
    return $results_string;
    
}
    

private function setBackgroundColour(){

        if($this->bgcolor=='#ffffff'){
            $this->bgcolor='#f1f1f1';
        }
        else {
            $this->bgcolor='#ffffff';
        }
  
    }

            
private function createSearchQuery(){
            
            //$filterString = $_POST['filter']; //search string
            preg_match_all('/(?<!")\b\w+\b|(?<=")\b[^"]+/', $this->filterString, $result, PREG_PATTERN_ORDER);    
                
            for ($i = 0; $i < count($result[0]); $i++) {}            
            $numofterms = $i;        
            $query = "";                              
            $query = queryClass::getLLPGSearchQuery($numofterms, $result);
            return $query;
            }
}

?>
