<?php
$root = $_SERVER['DOCUMENT_ROOT'];

//Framework
require_once('/library/flight/flight/Flight.php');
//System Classes
require_once('/app/model/class/database.php');
require_once('/app/model/class/url.php');
require_once('/app/model/class/result.php');
require_once('/app/model/class/coordinate.php');

//Database Classes
require_once('/app/model/class/company.php');
require_once('/app/model/class/nation.php');
require_once('/app/model/class/privilege.php');
require_once('/app/model/class/user.php');
require_once('/app/model/class/vehicle.php');
require_once('/app/model/class/model.php');
require_once('/app/model/class/address.php');





//System Functions
require_once('app/controller/system/function.php');
require_once('app/controller/method/get.php');
require_once('app/controller/method/post.php');
require_once('app/controller/method/put.php');
require_once('app/controller/method/delete.php');

?>