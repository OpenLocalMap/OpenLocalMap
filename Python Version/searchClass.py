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

import re
import queryClass

class searchClass:

##    #filterString;
##    # numrows;
##    # searchArray;
    bgcolor = "#ffffff"





    def __init__(self):
        #self.filterString = filter_input(INPUT_POST, 'filter');
        self.filterString = "TEST"
        query = self.createSearchQuery()
        conn= DBconn("LLPG");
        conn.setStid(query);


        self.searchArray = conn.getArray()
        self.numrows = len(self.searchArray)



##    def count_array():
##        count =  len(self.searchArray)

##      foreach (Self.searchArray as $countValue)
##                {
##                    count++;
##                }
##                    return count;



    def returnSearchResults(self):
        if self.numrows == 0 :
            return self.return_no_results_Index_Map()
                        ##echo Self.return_no_results_Index_Map()
        else:
            return self.return_results_Index_Map()
##        echo Self.return_results_Index_Map()





    def return_no_results_Index_Map(self):
        no_results_string =  "<div style=\"padding: 5px 1px\">Sorry, your search: &quot;"  + self.filterString + "&quot; returned zero results </div>"
        return no_results_string




    def return_results_Index_Map(self):
            newCount=1
            results_string =""
            results_string = results_string +  "<div id='be'>"

            for searchValue in self.searchArray:
                FlatName = ""
                FlatNumber = ""
                BuildingName = ""
                BuildingNumber  =""

                #Picks up required data from main form
                UPRNData = searchValue['UPRN']

                if searchValue['FLATNAME']:
                   FlatName =ucwords(strtolower(searchValue['FLATNAME'])) + ","

                if searchValue['FLATNUMBER']:
                    FlatNumber= searchValue['FLATNUMBER'] + ","

                if searchValue['NAME1']:
                    BuildingName = ucwords(strtolower(searchValue['NAME1'])) + ","

                if searchValue['NUMBER1']:
                    BuildingNumber = searchValue['NUMBER1'] + ","

                StreetData = ucwords(strtolower(searchValue['STREET'])) + ","
                TownData = ucwords(strtolower(searchValue['POSTTOWN1']))
                PostcodeData = searchValue['POSTCODE']

                self.setBackgroundColour()

                addressString= FlatName + " " + FlatNumber + " " + BuildingName + " " + BuildingNumber + " " + StreetData + " " + TownData + " " + PostcodeData
                rowNumber = newCount

                results_string = results_string + "<div style=\"padding: 5px 1px; border-bottom-style:solid; border-bottom-width:1px; border-color:#C0C0C0\" id=$rowNumber onmouseout=\"changeRowColourBack($rowNumber,'')\" onmouseover=\"changeRowColour($rowNumber)\" title=\"Click here to see more information\" onclick=\"zoomLLPGAddressIndMap($UPRNData)\">"
                results_string = results_string + "<div id='Abstract' style='height:33px; text-align:left;'>"
                results_string = results_string + "<div style='float:left; width:15%; padding-left:5px'><img src='./images/marker.png'></div>"
                results_string = results_string + "<div><span class=\"pointer\">" + addressString + "</span></div>"
                results_string = results_string + "</div>"
                results_string = results_string + "</div>"
                newCount += 1


            results_string = results_string +  "</div>"
            return results_string



    def setBackgroundColour(self):
        if(self.bgcolor=='#ffffff'):
            self.bgcolor='#f1f1f1'
        else:
            self.bgcolor='#ffffff'


    def createSearchQuery(self):


        ##preg_match_all('/(?<!")\b\w+\b|(?<=")\b[^"]+/', self.filterString, $result, PREG_PATTERN_ORDER);
        result = re.findall('/(?<!")\b\w+\b|(?<=")\b[^"]+/', self.filterString)
        numofterms = len(result)
        query = queryClass.getLLPGSearchQuery(numofterms, result)

        return query


