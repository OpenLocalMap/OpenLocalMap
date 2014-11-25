///Globals ///////
var wmsURL = '';  //WMS connection string e.g. 
var boundaryName = ""; //Name for Boundary (Can be anything)  - To be made optional
var boundaryWMSname = ""; //Name of Boundary WMS Name (has to be specific)

var serverPath = "";
var kmllink = serverPath + "wms/kml?mode=download&layers=";
var csvlink = serverPath + "wfs?service=wfs&version=2.0.0&request=GetFeature&outputFormat=csv&typeNames=";
var pollutionDialogString = ""; //String for Dialog box (to be moved into metadata)

