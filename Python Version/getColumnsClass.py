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
import json

class getColumnsClass:

##    live_DB;
    totalArray = []
##    query
##    columnString
    def __init__(self):
        self.live_DB = DBconn.DBconn("Meta")


    def getPopUpData(layerlist):

        layerArray = json.loads(layerlist)

        for layer in layerArray:
            Layername = layer[0]
            RecordPK = layer[1]

            #GET ORACLE NAME, FRIENDLYNAME DATACOLUMN NAMES and FRIENDLY NAMES for Layer

            self.query = "select * from " + metaschema + "." + metatable + " where LAYERNAME = '" + Layername + "'"
            self.live_DB.setStid(self.query)
            LayerStuff = self.live_DB.getArray()

            FriendlyLayer = LayerStuff[0]['FRIENDLYNAME']
            Workspace  = LayerStuff[0]['WORKSPACE']

            Column1 = LayerStuff[0]['DATA1']
            Column2 = LayerStuff[0]['DATA2']
            Column3 = LayerStuff[0]['DATA3']
            Column4 = LayerStuff[0]['DATA4']
            Column5 = LayerStuff[0]['DATA5']

            Friendly1 = LayerStuff[0]['DATAFRIENDLY1']
            Friendly2=  LayerStuff[0]['DATAFRIENDLY2']
            Friendly3 = LayerStuff[0]['DATAFRIENDLY3']
            Friendly4 = LayerStuff[0]['DATAFRIENDLY4']
            Friendly5 = LayerStuff[0]['DATAFRIENDLY5']

            #BUILD UP COLUMN LIST


            if Column1 is not None:
                self.columnString = Column1

            if LayerStuff[0]['DATA2'] is not None:
                self.columnString = self.columnString + ", " + LayerStuff[0]['DATA2']

            if LayerStuff[0]['DATA3'] is not None:
                self.columnString = self.columnString + ", " + LayerStuff[0]['DATA3']

            if LayerStuff[0]['DATA4'] is not None:
                self.columnString = self.columnString + ", " + LayerStuff[0]['DATA4']

            if LayerStuff[0]['DATA5'] is not None:
                self.columnString = self.columnString + ", " + LayerStuff[0]['DATA5']


            #SEARCH ORACLE TABLE for record values using ORALCE NAME AND DATACOLUMN NAMES
            #HAVE TO USE MI_PRINX AS STANDARD PK FOR NOW. COULD STORE IN LAYER.
            self.query = "select " + self.columnString + " from " + LayerStuff[0]['ORACLENAME']  + " where MI_PRINX = '" + RecordPK + "'"

            self.live_DB.setStid(self.query)
            RecordStuff = self.live_DB.getArray()
            FinalArray = []
            FinalArray["LayerName"] = FriendlyLayer

            FinalArray["GeoserverLayer"] = Workspace + ":" + Layername

            if RecordStuff[0][Column1] is not None:
                FinalArray[Friendly1] = RecordStuff[0][Column1]

            if RecordStuff[0][Column2] is not None:
                FinalArray[Friendly2] = RecordStuff[0][Column2]

            if RecordStuff[0][Column3] is not None:
                FinalArray[Friendly3] = RecordStuff[0][Column3]

            if RecordStuff[0][Column4] is not None:
                FinalArray[Friendly4] = RecordStuff[0][Column4]

            if RecordStuff[0][Column5] is not None:
                FinalArray[Friendly5] = RecordStuff[0][Column5]

        #ADD ALL TO ARRAY


            self.totalArray.append(FinalArray)


        #ENCODE TO JSON

        return json.dumps(self.totalArray)




