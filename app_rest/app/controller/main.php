<?php
require_once 'app/controller/system/include.php';
require_once 'app/controller/system/setting.php';


//Main Entry Point
Flight::route('/(@version(/@category(/@class(/@format(/@id:[0-9]+)))))', function($version, $category, $class, $format, $id){

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
	$key = $request->query->api_key;
	$keys = Flight::get('api_key');
	if (!isset($keys[$key])){
		Flight::notAuthorized("Unauthorized api key.");
		return;
	} 
	
	//Checking version, category and class if empty
	if (empty($url->Version) || empty($url->Category) || empty($url->Class) || empty($url->Format)) {
		Flight::notFound("Parameter not found.");
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
		case 'main':
		Flight::set('database', Flight::get('db1'));
		$result = Flight::process($url);
		break;
		case 'data':
		Flight::set('database', Flight::get('db2'));
		$result = Flight::process($url);
		break;
		default:
		Flight::notFound("Category $category not found.");
		break;
	}

	if ($url->Format == 'json') {
		Flight::sendJson($result);
	}

	if ($url->Format == 'xml') {
		Flight::sendXml($result);
	}
});


Flight::map('process', function($url) {
	$request = Flight::request();
	switch ($request->method) {
		case 'GET':
		return method_get($url, $_GET);
		break;
		case 'POST':
		return method_post($url, $_POST);
		break;
		case 'PUT':
		parse_str(file_get_contents("php://input"),$put);
		return method_put($url, $put);
		break;
		case 'DELETE':
		parse_str(file_get_contents("php://input"),$delete);
		return method_delete($url, $delete);
		break;
	}
});


//Main Exit Point
Flight::map('sendJson', function(Result $result) {
	header('Content-Type: application/json');
	Flight::json($result);
});

Flight::map('sendXml', function(Result $result) {
	header('Content-Type: application/xml');
	echo xmlrpc_encode($result);
});


//Status Codes
Flight::map('noContent', function(){
	$result = new Result();
	$result->Status = Result::ERROR;
	$result->Message = "No content!";
	Flight::halt(204, json_indent(json_encode($result)));
});
Flight::map('notAuthorized', function($message){
	$result = new Result();
	$result->Status = Result::ERROR;
	$result->Message = $message;
	Flight::halt(401, json_indent(json_encode($result)));
});
Flight::map('notFound', function($message){
	$result = new Result();
	$result->Status = Result::ERROR;
	$result->Message = $message;
	Flight::halt(404, json_indent(json_encode($result)));
});
Flight::map('error', function(Exception $exception){
	$result = new Result();
	$result->Status = Result::ERROR;
	$result->Message = $exception->getMessage();
	Flight::halt(501, json_indent(json_encode($result)));
});

Flight::set('flight.log_errors', true);
Flight::start();
?>