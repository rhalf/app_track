<?php
$root = $_SERVER['DOCUMENT_ROOT'];

//Framework
require_once('/asset/library/flight/flight/Flight.php');

//System Interfaces
require_once('/app/model/interface/iquery.php');

//System Classes
require_once('/app/model/class/database.php');
// require_once('/app/model/class/url.php');
require_once('/app/model/class/result.php');
require_once('/app/model/class/coordinate.php');

//Database Enumeration Classes
require_once('/app/model/class/nation.php');
require_once('/app/model/class/privilege.php');
require_once('/app/model/class/field.php');
require_once('/app/model/class/status.php');
require_once('/app/model/class/unittype.php');
require_once('/app/model/class/unitstatus.php');
require_once('/app/model/class/simvendor.php');

//Database Classes
require_once('/app/model/class/company.php');
require_once('/app/model/class/user.php');
require_once('/app/model/class/vehicle.php');
require_once('/app/model/class/trackeetype.php');
require_once('/app/model/class/companyaddress.php');
require_once('/app/model/class/unit.php');

require_once('/app/model/class/driver.php');
require_once('/app/model/class/companyinfo.php');
require_once('/app/model/class/userinfo.php');
require_once('/app/model/class/useronline.php');

require_once('/app/model/class/collection.php');
require_once('/app/model/class/vehiclecollection.php');

require_once('/app/model/class/route.php');
require_once('/app/model/class/poi.php');
require_once('/app/model/class/geofence.php');
require_once('/app/model/class/area.php');

require_once('/app/model/class/sim.php');

require_once('app/model/class/appnote.php');
require_once('app/model/class/appdatabase.php');
// require_once('app/model/class/appsetting.php');
require_once('app/model/class/appclient.php');
require_once('app/model/class/appinfo.php');
require_once('app/model/class/applog.php');

//
require_once('app/model/class/unitdata.php');
require_once('app/model/class/header.php');
require_once('app/model/class/gps.php');
require_once('app/model/class/gprs.php');
require_once('app/model/class/io.php');


//Session
require_once('app/model/session/session.php');


//System Functions
// require_once('app/controller/method/get.php');
// require_once('app/controller/method/post.php');
// require_once('app/controller/method/put.php');
// require_once('app/controller/method/delete.php');
// require_once('app/controller/method/options.php');
// require_once('app/controller/method/patch.php');


require_once('app/controller/system/function.php');
require_once 'app/controller/system/statuscode.php';
require_once 'app/controller/system/setting.php';





?>