OpenLocalMap
============

This project aims to create a develop a simple WMS based web mapping application for use by local authorities or charities that can be quickly deployed to deliver spatial information. The project also aims provide a method for delivering data and metadata if required. 

The application's content and style is controlled by metadata tables stored within a database or XML file allowing layers to be quickly added or adjusted.  

The project is built in HTML5 (so won't work in Ie8), PHP, jQuery, jQuery UI, Openlayers 3,  proj4js and currently uses an Oracle Database to store the controlling metadata. 

The WMS layers themselves need to be hosted on a wms server (such as Geoserver) with a spatial database behind it. 

The ultimate aim is to provide a simple to use cross platform application that local government can quickly deploy to deliver spatial information. 

There is a early version of the application adapted for Hackney Local Authority live at www.map.hackney.gov.uk/MapHackney3

In the future hopefully this will also work with MySQL, SQLServer,  Postgresql or a local xml file. There is a also a .NET version in the pipeline and plans to replace jQueryUI with bootstrap. 


Installation
============

Openlayers3 needs to be extracted into the root directory (Available here http://openlayers.org/)


WMS Server

This application uses WMS layers hosted by a WMS server (e.g. Geoserver, MapServer or ArcGIS server) which is set up and maintained seperately. 

Database

Create metadata table to hold layer information. 

Run SQL for relevant db in your database and add layers as appropriate (See SQL Folder for more details and SQL Files) (not complete for all databases)

Fill out the fields in the newly created metadata table as required.  


Application 

Add connection strings to wms server and database in includes/variableSetup.php and js/variableSetup.js

LLPG Address module is not complete and so you be removed at present. 



