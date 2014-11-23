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


include("DBConn.php");
require_once("queryClass.php");
require_once("searchClass.php");
require_once("xyCoordsLLPGClass.php");
include("getColumnsClass.php");
$action = filter_input(INPUT_POST, 'action');

switch ($action) {
        case "search":
                $searchResults  = new searchClass();
                echo $searchResults->returnSearchResults();
		break;        
        case "getXYLLPG":
               $UPRN = filter_input(INPUT_POST, 'UPRN');
               $XYCoords = new xyCoordsLLPGClass($UPRN);
               echo $XYCoords->getXYCoordsLLPG();
               break;         
        case "getData":
              $layerlist = filter_input(INPUT_POST, 'layerlist'); 
              $RequestList = new getColumnsClass();
              $answer = $RequestList->getPopUpData($layerlist);           
              echo $answer;
            break;
}

?>
