<?php
require_once 'app/controller/system/include.php';


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


//Address
Flight::route('GET /v1/main/address', array('Address', 'selectAll'));

Flight::route('GET /v1/main/address/@id', array('Address', 'select'));

Flight::route('POST /v1/main/address', array('Address', 'insert'));

Flight::route('PUT /v1/main/address/@id', array('Address', 'update'));

Flight::route('DELETE /v1/main/address/@id', array('Address', 'delete'));


//User
Flight::route('GET /v1/main/user', array('User', 'selectAll'));

Flight::route('GET /v1/main/user/@id', array('User', 'select'));

Flight::route('POST /v1/main/user', array('User', 'insert'));

Flight::route('PUT /v1/main/user/@id', array('User', 'update'));

Flight::route('DELETE /v1/main/user/@id', array('User', 'delete'));



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


Flight::map('process', function($url) {
	$request = Flight::request();
	switch ($request->method) {

		case 'GET':
		method_get($url, $_GET);

		case 'POST':
		$post = json_decode(file_get_contents("php://input"), true);
		method_post($url, $post);
		
		case 'PUT':
		$put = json_decode(file_get_contents("php://input"), true);
		method_put($url, $put);
		
		case 'DELETE':
		$delete = json_decode(file_get_contents("php://input"), true);
		method_delete($url, $delete);

		case 'OPTIONS':
		$options = json_decode(file_get_contents("php://input"), true);
		method_options($url, $options);

		case 'PATCH':
		$patch = json_decode(file_get_contents("php://input"), true);
		method_patch($url, $patch);

		default: 
		Flight::notFound("Http verbs not recognized.");
	}
});

Flight::set('flight.log_errors', true);
Flight::set('flight.handle_errors', true);

Flight::start();
?>