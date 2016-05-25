<?php
require_once 'app/controller/system/include.php';


Flight::route('OPTIONS /*', function() {
	Flight::preFlight();
}, true);


//AppClient
Flight::route('GET /v1/main/appclient', array('AppClient', 'selectAll'));

Flight::route('GET /v1/main/appclient/@id', array('AppClient', 'select'));

Flight::route('POST /v1/main/appclient', array('AppClient', 'insert'));

Flight::route('PUT /v1/main/appclient/@id', array('AppClient', 'update'));

Flight::route('DELETE /v1/main/appclient/@id', array('AppClient', 'delete'));

//AppDatabase
Flight::route('GET /v1/main/appdatabase', array('AppDatabase', 'selectAll'));

Flight::route('GET /v1/main/appdatabase/@id', array('AppDatabase', 'select'));

Flight::route('POST /v1/main/appdatabase', array('AppDatabase', 'insert'));

Flight::route('PUT /v1/main/appdatabase/@id', array('AppDatabase', 'update'));

Flight::route('DELETE /v1/main/appdatabase/@id', array('AppDatabase', 'delete'));

//AppInfo
Flight::route('GET /v1/main/appinfo', array('AppInfo', 'selectAll'));

Flight::route('GET /v1/main/appinfo/@id', array('AppInfo', 'select'));

Flight::route('POST /v1/main/appinfo', array('AppInfo', 'insert'));

Flight::route('PUT /v1/main/appinfo/@id', array('AppInfo', 'update'));

Flight::route('DELETE /v1/main/appinfo/@id', array('AppInfo', 'delete'));


//AppLog
Flight::route('GET /v1/main/applog', array('AppLog', 'selectAll'));

Flight::route('GET /v1/main/applog/@id', array('AppLog', 'select'));

Flight::route('POST /v1/main/applog', array('AppLog', 'insert'));

Flight::route('PUT /v1/main/applog/@id', array('AppLog', 'update'));

Flight::route('DELETE /v1/main/applog/@id', array('AppLog', 'delete'));


//AppNote
Flight::route('GET /v1/main/appnote', array('AppNote', 'selectAll'));

Flight::route('GET /v1/main/appnote/@id', array('AppNote', 'select'));

Flight::route('POST /v1/main/appnote', array('AppNote', 'insert'));

Flight::route('PUT /v1/main/appnote/@id', array('AppNote', 'update'));

Flight::route('DELETE /v1/main/appnote/@id', array('AppNote', 'delete'));


//=========================================================================


//Address
Flight::route('GET /v1/main/address', array('Address', 'selectAll'));

Flight::route('GET /v1/main/address/@id', array('Address', 'select'));

Flight::route('POST /v1/main/address', array('Address', 'insert'));

Flight::route('PUT /v1/main/address/@id', array('Address', 'update'));

Flight::route('DELETE /v1/main/address/@id', array('Address', 'delete'));

//Collection
Flight::route('GET /v1/main/collection', array('Collection', 'selectAll'));

Flight::route('GET /v1/main/collection/@id', array('Collection', 'select'));

Flight::route('POST /v1/main/collection', array('Collection', 'insert'));

Flight::route('PUT /v1/main/collection/@id', array('Collection', 'update'));

Flight::route('DELETE /v1/main/collection/@id', array('Collection', 'delete'));

//Company
Flight::route('GET /v1/main/company', array('Company', 'selectAll'));

Flight::route('GET /v1/main/company/@id', array('Company', 'select'));

Flight::route('POST /v1/main/company', array('Company', 'insert'));

Flight::route('PUT /v1/main/company/@id', array('Company', 'update'));

Flight::route('DELETE /v1/main/company/@id', array('Company', 'delete'));

//CompanyInfo
Flight::route('GET /v1/main/companyinfo', function() {
	$company = Flight::request()->query->company;

	if ($company) {
		CompanyInfo::selectByCompany($company);
	} else {
		CompanyInfo::selectAll();
	}
});

Flight::route('GET /v1/main/companyinfo/@id', array('CompanyInfo', 'select'));

Flight::route('POST /v1/main/companyinfo', array('CompanyInfo', 'insert'));

Flight::route('PUT /v1/main/companyinfo/@id', array('CompanyInfo', 'update'));

Flight::route('DELETE /v1/main/companyinfo/@id', array('CompanyInfo', 'delete'));




//Driver
Flight::route('GET /v1/main/driver', array('Driver', 'selectAll'));

Flight::route('GET /v1/main/driver/@id', array('Driver', 'select'));

Flight::route('POST /v1/main/driver', array('Driver', 'insert'));

Flight::route('PUT /v1/main/driver/@id', array('Driver', 'update'));

Flight::route('DELETE /v1/main/driver/@id', array('Driver', 'delete'));

//Field
Flight::route('GET /v1/main/field', array('Field', 'selectAll'));

Flight::route('GET /v1/main/field/@id', array('Field', 'select'));

Flight::route('POST /v1/main/field', array('Field', 'insert'));

Flight::route('PUT /v1/main/field/@id', array('Field', 'update'));

Flight::route('DELETE /v1/main/field/@id', array('Field', 'delete'));

//Geofence
Flight::route('GET /v1/main/geofence', array('Geofence', 'selectAll'));

Flight::route('GET /v1/main/geofence/@id', array('Geofence', 'select'));

Flight::route('POST /v1/main/geofence', array('Geofence', 'insert'));

Flight::route('PUT /v1/main/geofence/@id', array('Geofence', 'update'));

Flight::route('DELETE /v1/main/geofence/@id', array('Geofence', 'delete'));

//Nation
Flight::route('GET /v1/main/nation', array('Nation', 'selectAll'));

Flight::route('GET /v1/main/nation/@id', array('Nation', 'select'));

Flight::route('POST /v1/main/nation', array('Nation', 'insert'));

Flight::route('PUT /v1/main/nation/@id', array('Nation', 'update'));

Flight::route('DELETE /v1/main/nation/@id', array('Nation', 'delete'));

//Poi
Flight::route('GET /v1/main/poi', array('Poi', 'selectAll'));

Flight::route('GET /v1/main/poi/@id', array('Poi', 'select'));

Flight::route('POST /v1/main/poi', array('Poi', 'insert'));

Flight::route('PUT /v1/main/poi/@id', array('Poi', 'update'));

Flight::route('DELETE /v1/main/poi/@id', array('Poi', 'delete'));


//Privilege
Flight::route('GET /v1/main/privilege', array('Privilege', 'selectAll'));

Flight::route('GET /v1/main/privilege/@id', array('Privilege', 'select'));

Flight::route('POST /v1/main/privilege', array('Privilege', 'insert'));

Flight::route('PUT /v1/main/privilege/@id', array('Privilege', 'update'));

Flight::route('DELETE /v1/main/privilege/@id', array('Privilege', 'delete'));

//Route
Flight::route('GET /v1/main/route', array('Route', 'selectAll'));

Flight::route('GET /v1/main/route/@id', array('Route', 'select'));

Flight::route('POST /v1/main/route', array('Route', 'insert'));

Flight::route('PUT /v1/main/route/@id', array('Route', 'update'));

Flight::route('DELETE /v1/main/route/@id', array('Route', 'delete'));

//SimVendor
Flight::route('GET /v1/main/simvendor', array('SimVendor', 'selectAll'));

Flight::route('GET /v1/main/simvendor/@id', array('SimVendor', 'select'));

Flight::route('POST /v1/main/simvendor', array('SimVendor', 'insert'));

Flight::route('PUT /v1/main/simvendor/@id', array('SimVendor', 'update'));

Flight::route('DELETE /v1/main/simvendor/@id', array('SimVendor', 'delete'));


//Status
Flight::route('GET /v1/main/status', array('Status', 'selectAll'));

Flight::route('GET /v1/main/status/@id', array('Status', 'select'));

Flight::route('POST /v1/main/status', array('Status', 'insert'));

Flight::route('PUT /v1/main/status/@id', array('Status', 'update'));

Flight::route('DELETE /v1/main/status/@id', array('Status', 'delete'));

//Unit
Flight::route('GET /v1/main/unit', array('Unit', 'selectAll'));

Flight::route('GET /v1/main/unit/@id', array('Unit', 'select'));

Flight::route('POST /v1/main/unit', array('Unit', 'insert'));

Flight::route('PUT /v1/main/unit/@id', array('Unit', 'update'));

Flight::route('DELETE /v1/main/unit/@id', array('Unit', 'delete'));

//UnitSim
Flight::route('GET /v1/main/unitsim', array('UnitSim', 'selectAll'));

Flight::route('GET /v1/main/unitsim/@id', array('UnitSim', 'select'));

Flight::route('POST /v1/main/unitsim', array('UnitSim', 'insert'));

Flight::route('PUT /v1/main/unitsim/@id', array('UnitSim', 'update'));

Flight::route('DELETE /v1/main/unitsim/@id', array('UnitSim', 'delete'));

//UnitType
Flight::route('GET /v1/main/unittype', array('UnitType', 'selectAll'));

Flight::route('GET /v1/main/unittype/@id', array('UnitType', 'select'));

Flight::route('POST /v1/main/unittype', array('UnitType', 'insert'));

Flight::route('PUT /v1/main/unittype/@id', array('UnitType', 'update'));

Flight::route('DELETE /v1/main/unittype/@id', array('UnitType', 'delete'));


//VehicleModel
Flight::route('GET /v1/main/vehiclemodel', array('VehicleModel', 'selectAll'));

Flight::route('GET /v1/main/vehiclemodel/@id', array('VehicleModel', 'select'));

Flight::route('POST /v1/main/vehiclemodel', array('VehicleModel', 'insert'));

Flight::route('PUT /v1/main/vehiclemodel/@id', array('VehicleModel', 'update'));

Flight::route('DELETE /v1/main/vehiclemodel/@id', array('VehicleModel', 'delete'));

//User
Flight::route('GET /v1/main/user', array('User', 'selectAll'));

Flight::route('GET /v1/main/user/@id', array('User', 'select'));

Flight::route('POST /v1/main/user', array('User', 'insert'));

Flight::route('PUT /v1/main/user/@id', array('User', 'update'));

Flight::route('PUT /v1/main/user/@id/credential', array('User', 'updateCredential'));

Flight::route('DELETE /v1/main/user/@id', array('User', 'delete'));

//UserInfo
Flight::route('GET /v1/main/userinfo', function() {
	$user = Flight::request()->query->user;

	if ($user) {
		UserInfo::selectByUser($user);
	} else {
		UserInfo::selectAll();
	}
});

Flight::route('GET /v1/main/userinfo/@id', array('UserInfo', 'select'));

Flight::route('POST /v1/main/userinfo', array('UserInfo', 'insert'));

Flight::route('PUT /v1/main/userinfo/@id', array('UserInfo', 'update'));

Flight::route('DELETE /v1/main/userinfo/@id', array('UserInfo', 'delete'));

//UserSim
Flight::route('GET /v1/main/usersim', function() {
	$user = Flight::request()->query->user;

	if ($user) {
		UserSim::selectByUser($user);
	} else {
		UserSim::selectAll();
	}
});

Flight::route('GET /v1/main/usersim/@id', array('UserSim', 'select'));

Flight::route('POST /v1/main/usersim', array('UserSim', 'insert'));

Flight::route('PUT /v1/main/usersim/@id', array('UserSim', 'update'));

Flight::route('DELETE /v1/main/usersim/@id', array('UserSim', 'delete'));


//Vehicle
Flight::route('GET /v1/main/vehicle', array('Vehicle', 'selectAll'));

Flight::route('GET /v1/main/vehicle/@id', array('Vehicle', 'select'));

Flight::route('POST /v1/main/vehicle', array('Vehicle', 'insert'));

Flight::route('PUT /v1/main/vehicle/@id', array('Vehicle', 'update'));

Flight::route('DELETE /v1/main/vehicle/@id', array('Vehicle', 'delete'));

//VehicleCollection
Flight::route('GET /v1/main/vehiclecollection', array('VehicleCollection', 'selectAll'));

Flight::route('GET /v1/main/vehiclecollection/@id', array('VehicleCollection', 'select'));

Flight::route('POST /v1/main/vehiclecollection', array('VehicleCollection', 'insert'));

Flight::route('PUT /v1/main/vehiclecollection/@id', array('VehicleCollection', 'update'));

Flight::route('DELETE /v1/main/vehiclecollection/@id', array('VehicleCollection', 'delete'));


//UserOnline
Flight::route('GET /v1/main/useronline', array('UserOnline', 'selectAll'));

Flight::route('GET /v1/main/useronline/@id', array('UserOnline', 'select'));

Flight::route('POST /v1/main/useronline', array('UserOnline', 'insert'));

Flight::route('PUT /v1/main/useronline/@id', array('UserOnline', 'update'));

Flight::route('DELETE /v1/main/useronline/@id', array('UserOnline', 'delete'));



//=========================================================================

Flight::route('POST /v1/session/login', array('Session', 'login'));

Flight::route('POST /v1/session/logout', array('Session', 'logout'));


//=========================================================================

// 	try {
// 		$url = new Url();
// 		$url->Version = $version;
// 		$url->Category = $category;
// 		$url->Class = $class;
// 		$url->Id = $id;

// 		$request = Flight::request();

// 		//Checking content-type 
// 		// if ($request->type != 'application/json'){
// 		// 	Flight::notFound("The content-type not found.");
// 		// 	return;
// 		// }

// 		//Checking if api_key is valid
// 		// $key = $request->query->api_key;
// 		// $keys = Flight::get('api_key');
// 		// if (!isset($keys[$key])){
// 		// 	Flight::notAuthorized("Unauthorized api key.");
// 		// 	return;
// 		// } 

// 		//Checking version, category, class, format if empty
// 		if (empty($url->Version)) {
// 			Flight::notFound("Parameter api version not found.");
// 			return;
// 		}
// 		if (empty($url->Category)) {
// 			Flight::notFound("Parameter api category not found.");
// 			return;
// 		}
// 		if (empty($url->Class)) {
// 			Flight::notFound("Parameter api class not found.");
// 			return;
// 		}

// 		//Checking version if correct
// 		if ($url->Version != Flight::get('api_version')){
// 			Flight::notFound("Api version not found.");
// 			return;
// 		}

// 		//Checking category if exist
// 		switch ($url->Category) {
// 			//=======================================Main
// 			case 'main':
// 			Flight::process($url);
// 			break;

// 			//=======================================Data
// 			case 'data':
// 			Flight::process($url);
// 			break;

// 			//=======================================Session
// 			case 'session':
// 			$result = Flight::process($url);
// 			break;

// 			default:
// 			Flight::notFound("Category not found.");
// 		}

// 	} catch (Exception $exception) {
// 		Flight::badRequest($exception->getMessage());
// 	}
// });


// Flight::map('process', function($url) {
// 	$request = Flight::request();
// 	switch ($request->method) {

// 		case 'GET':
// 		method_get($url, $_GET);

// 		case 'POST':
// 		$post = json_decode(file_get_contents("php://input"), true);
// 		method_post($url, $post);

// 		case 'PUT':
// 		$put = json_decode(file_get_contents("php://input"), true);
// 		method_put($url, $put);

// 		case 'DELETE':
// 		$delete = json_decode(file_get_contents("php://input"), true);
// 		method_delete($url, $delete);

// 		case 'OPTIONS':
// 		$options = json_decode(file_get_contents("php://input"), true);
// 		method_options($url, $options);

// 		case 'PATCH':
// 		$patch = json_decode(file_get_contents("php://input"), true);
// 		method_patch($url, $patch);

// 		default: 
// 		Flight::notFound("Http verbs not recognized.");
// 	}
// });

Flight::set('flight.log_errors', true);
Flight::set('flight.handle_errors', true);

Flight::start();
?>