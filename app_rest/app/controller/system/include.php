<?php
$root = $_SERVER['DOCUMENT_ROOT'];

//Framework
require_once('/library/flight/flight/Flight.php');

//System Interfaces
require_once('/app/model/interface/iquery.php');

//System Classes
require_once('/app/model/class/database.php');
require_once('/app/model/class/url.php');
require_once('/app/model/class/result.php');
require_once('/app/model/class/coordinate.php');

//Database Classes
require_once('/app/model/class/company.php');
require_once('/app/model/class/user.php');
require_once('/app/model/class/vehicle.php');
require_once('/app/model/class/model.php');
require_once('/app/model/class/address.php');
require_once('/app/model/class/unit.php');

require_once('/app/model/class/driver.php');
require_once('/app/model/class/companyinfo.php');
require_once('/app/model/class/unitsim.php');
require_once('/app/model/class/usersim.php');
require_once('/app/model/class/unitsim.php');
require_once('/app/model/class/userinfo.php');

require_once('/app/model/class/collection.php');
require_once('/app/model/class/vehiclecollection.php');

// require_once('/app/model/class/route.php');
// require_once('/app/model/class/poi.php');
// require_once('/app/model/class/geofence.php');

//Database Enumeration Classes
require_once('/app/model/class/nation.php');
require_once('/app/model/class/privilege.php');
require_once('/app/model/class/field.php');
require_once('/app/model/class/status.php');
require_once('/app/model/class/unittype.php');
require_once('/app/model/class/simvendor.php');

//System Functions
require_once('app/controller/system/function.php');
require_once('app/controller/method/get.php');
require_once('app/controller/method/post.php');
require_once('app/controller/method/put.php');
require_once('app/controller/method/delete.php');

?>