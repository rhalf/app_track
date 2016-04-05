<?php
require_once 'app/controller/system/include.php';
require_once 'app/controller/system/setting.php';


//Main Entry Point
Flight::route('/(@version(/@category(/@class(/@format(/@id:[0-9]+)))))', function($version, $category, $class, $format, $id){

	try {
		$url = new Url();
		$url->Version = $version;
		$url->Category = $category;
		$url->Class = $class;
		$url->Format = $format;
		$url->Id = $id;

		$request = Flight::request();

		//Checking content-type 
		// if ($request->type != 'application/json'){
		// 	Flight::notFound("The content-type not found.");
		// 	return;
		// }

		//Checking if api_key is valid
		// $key = $request->query->api_key;
		// $keys = Flight::get('api_key');
		// if (!isset($keys[$key])){
		// 	Flight::notAuthorized("Unauthorized api key.");
		// 	return;
		// } 

		//Checking version, category, class, format if empty
		if (empty($url->Version)) {
			Flight::notFound("Parameter api version not found.");
			return;
		}
		if (empty($url->Category)) {
			Flight::notFound("Parameter api category not found.");
			return;
		}
		if (empty($url->Class)) {
			Flight::notFound("Parameter api class not found.");
			return;
		}
		if (empty($url->Format)) {
			Flight::notFound("Parameter api format not found.");
			return;
		}

		//Checking version if correct
		if ($url->Version != Flight::get('api_version')){
			Flight::notFound("Api version not found.");
			return;
		}
		//Checking format if correct 
		if (!($url->Format=='json') && !($url->Format=='xml')){
			Flight::notFound("Format not supported.");
			return;
		}


		$result = null;

		//Checking category if exist
		switch ($url->Category) {
			//=======================================Main
			case 'main':
			if (!isset($_SESSION['user'])) {
				Flight::notAuthorized('Authorization is needed.');
			}
			Flight::set('database', Flight::get('db1'));
			$result = Flight::process($url);
			break;

			//=======================================Data
			case 'data':
			if (!isset($_SESSION['user'])) {
				Flight::notAuthorized('Authorization is needed.');
			}
			Flight::set('database', Flight::get('db2'));
			$result = Flight::process($url);
			break;

			//=======================================Session
			case 'session':
			Flight::set('database', Flight::get('db1'));
			$result = Flight::process($url);
			break;
			
			default:
			Flight::notFound("Category not found.");
			$result = Flight::process($url);
			break;
		}

		if ($url->Format == 'json') {
			Flight::sendJson($result);
		}

		if ($url->Format == 'xml') {
			Flight::sendXml($result);
		}
	} catch (Exception $exception) {
		Flight::error($exception);
	}
});


Flight::map('process', function($url) {
	$request = Flight::request();
	switch ($request->method) {

		case 'GET':
		return method_get($url, $_GET);

		case 'POST':
		//return method_post($url, $_POST);
		$post = json_decode(file_get_contents("php://input"), true);
		return method_post($url, $post);
		
		case 'PUT':
		parse_str(file_get_contents("php://input"),$put);
		return method_put($url, $put);
		
		case 'DELETE':
		parse_str(file_get_contents("php://input"),$delete);
		return method_delete($url, $delete);
	}
	Flight::notFound("Method verbs not recognized.");
});


//Main Exit Point
Flight::map('sendJson', function(Result $result) {
	header('Access-Control-Allow-Origin: *');  
	header('Content-Type: application/json');
	Flight::json($result);
});

Flight::map('sendXml', function(Result $result) {
	header('Access-Control-Allow-Origin: *');  
	header('Content-Type: application/xml');
	echo xmlrpc_encode($result);
});


//Status Codes
Flight::map('noContent', function($message){
	Flight::halt(204, $message);
});
Flight::map('notAuthorized', function($message){
	Flight::halt(401, $message);
});
Flight::map('notFound', function($message){
	Flight::halt(404, $message);
});
Flight::map('error', function(Exception $exception){
	Flight::halt(501, $exception->getMessage());
});

Flight::set('flight.log_errors', true);
Flight::start();
?>