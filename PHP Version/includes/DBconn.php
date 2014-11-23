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


class DBconn{
   public $DB;
   public $stid;
   
   const connectionString = metaDBConnectionStr;
   const username = metaUser;
   const passwrd = metaPass;
   
   const llpgConnectionString = llpgDBConnectionStr;
   const llpgusername = llpgUser;
   const llpgpaswrd = llpgPass;
   
    function __construct($type){//Could just use same name as class, but this is old style php
    
        
        try    {
                    if ($type === "Meta"){
                        $this->DB = new PDO(self::connectionString,  self::username, self::passwrd);
                    }
                    else {
                          $this->DB = new PDO(self::llpgConnectionString,  self::llpgusername, self::llpgpaswrd);
                    }
                } 
         catch ( Exception $errorConnecting)
                {             
                    echo 'Caught Exception: ', $errorConnecting->getMessage(), "\n";
                }
    }
    
    function setStid($Query){     
        $this->stid = $this->DB->query($Query);
        if (!$this->stid) {
            $e = oci_error($this->DB);
            trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
        }
   }
        
     
    function getArray(){//THIS RETURNS MULTIPLE ROWS
        $result = $this->stid->fetchAll(PDO::FETCH_ASSOC);
        return $result;
        
    }
    
    function getSingleRow(){   //THIS RETURNS A SINGLE ROW
        $row = $this->stid->fetch(PDO::FETCH_ASSOC);
        return $row;       
    }
 
    
   
}   


  ?>