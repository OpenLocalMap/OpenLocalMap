#    OpenLocalMap OpenSource web mapping for local government
#    Copyright (C) <2014>  <Ben Calnan>
#
#    This program is free software: you can redistribute it and/or modify
#    it under the terms of the GNU General Public License as published by
#    the Free Software Foundation, either version 3 of the License, or
#    (at your option) any later version.
#
#    This program is distributed in the hope that it will be useful,
#    but WITHOUT ANY WARRANTY; without even the implied warranty of
#    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
#    GNU General Public License for more details.
#
#    You should have received a copy of the GNU General Public License
#    along with this program.  If not, see <http://www.gnu.org/licenses/>.
import variableSetup

class DBconn:
##   public DB;
##   public $stid;

    connectionString =  variableSetup.metaDBConnectionStr
    username = variableSetup.metaUser
    passwrd = variableSetup.metaPass
    llpgConnectionString = variableSetup.llpgDBConnectionStr
    llpgusername = variableSetup.llpgUser
    llpgpaswrd = variableSetup.llpgPass

    def __init__(self, type):

        try:
            if type == "Meta":
                pass
                #self.DB = new PDO(self::connectionString,  self::username, self::passwrd);
            else:
                pass
                #self.DB = new PDO(self::llpgConnectionString,  self::llpgusername, self::llpgpaswrd);
        except Exception:
            pass

##         catch ( Exception $errorConnecting)
##                {
##                    echo 'Caught Exception: ', $errorConnecting->getMessage(), "\n";
##                }


    def setStid(Query):
        self.stid = self.DB.query(Query)

        if (!self.stid):
            e = oci_error(self.DB)
            trigger_error(htmlentities(e['message'], ENT_QUOTES), E_USER_ERROR);




    def getArray():
        #THIS RETURNS MULTIPLE ROWS
        result = this.stid.fetchAll(PDO::FETCH_ASSOC)
        return result



    def getSingleRow():
        #THIS RETURNS A SINGLE ROW
        row = self.stid.fetch(PDO::FETCH_ASSOC)
        return row




