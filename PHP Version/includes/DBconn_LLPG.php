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

class DBconn_LLPG{
   public $orcDB;
   public $stid;
   
   const connectionString = llpgDBConnectionStr;
   const username = llpgUser;
   const passwrd = llpgPass;
   
   
    function __construct(){//Could just use same name as class, but this is old style php
         try    {
                $this->orcDB = oci_connect(self::username, self::passwrd, self::connectionString);       
                } 
         catch ( Exception $errorConnecting)
                {             
                    echo 'Caught Exception', $errorConnecting->getMessage(), "\n";
                }
    }
    
    function setStid($Query){       
       $this->stid = oci_parse($this->orcDB,$Query); 
        if (!$this->stid) {
            $e = oci_error($this->orcDB);
            trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
        }
   }
        
    function getSingleRow(){   //THIS RETURNS A SINGLE ROW
        //$this->setStid($query);
        oci_execute($this->stid);
        $row = oci_fetch_array($this->stid, OCI_ASSOC+OCI_RETURN_NULLS);
        return $row;       
    }
     
    function getArray(){//THIS RETURNS AN ARRAY IN ROW FORM
        //$this->setStid($query);
        oci_execute($this->stid);
        oci_fetch_all($this->stid, $result, null, null, OCI_FETCHSTATEMENT_BY_ROW);
        return $result;
        
    }
    
    function getCount(){   
        //$this->setStid($countQuery);
	oci_execute($this->stid) or die(oci_error($this->stid));
	// Necessary because oci_num_rows() only gathers rows returned to the buffer via oci_fetch*() functions when using SELECT statements.
	oci_fetch_all($this->stid, $array);
	// Won't actually be needing the data, so we can unset that.
	unset($array);
        $countResult = oci_num_rows($this->stid);
	//oci_free_statement($this->stid); CHECK IF THIS MESSSES THINGS UP //PUT IN DESTRUCTOR?
        return $countResult;
        
    }
    
    function bindOracleprocedure($filterString)
    
        {
            oci_bind_by_name($this->stid, ":filtstr", $filterString);            
        }
    
    function runQuery()          
    {
        oci_execute($this->stid) or die(oci_error($this->stid));
    }
    
   
}   


  ?>