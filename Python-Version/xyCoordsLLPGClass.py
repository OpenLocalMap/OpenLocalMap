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


import queryClass

class xyCoordsLLPGClass:


    def __init__(self, uprn):
        self.UPRN = uprn
        self.getXYquery()

    def getXYquery(self):

        ##print queryClass.getXYofLLPGpoint(self.UPRN)
        self.xyQuery =  queryClass.getXYofLLPGpoint(self.UPRN);

    def getXYCoordsLLPG(self):
        self.xy_DB = DBconn("LLPG")
        self.setStid(xyQuery)
        self.xyCoords = xy_DB.getSingleRow()
        self.xyCoords = "{\"xyCoords\":[{\"X\":\"" + xyCoords['X'] + "\",\"Y\":\"" + xyCoords['Y'] + "\"}]}"
        return self.xyCoords;
