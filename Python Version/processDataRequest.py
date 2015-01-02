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

import DBconn
import queryClass
import searchClass
import xyCoordsLLPGClass
import getColumnsClass

import cgi
import cgitb

def main():
##    action = filter_input(INPUT_POST, 'action')

    if action == "search":
        searchResults  = searchClass()
        return searchResults.returnSearchResults()
    elif action == "getXYLLPG":
        UPRN = filter_input(INPUT_POST, 'UPRN')
        XYCoords = xyCoordsLLPGClass(UPRN)
        return XYCoords.getXYCoordsLLPG()
    elif action == "getData":
        layerlist = filter_input(INPUT_POST, 'layerlist')
        RequestList = getColumnsClass()
        answer = RequestList.getPopUpData(layerlist)
        return answer;


if __name__ == '__main__':
    main()

