<?php
require_once 'app/controller/system/include.php';
require_once 'app/controller/system/setting.php';


//Main Entry Point
Flight::route('/(@version(/@category(/@class(/@id:[0-9]+))))', function($version, $category, $class, $id){

	try {
		$url = new Url();
		$url->Version = $version;
		$url->Category = $category;
		$url->Class = $class;
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

		//Checking version if correct
		if ($url->Version != Flight::get('api_version')){
			Flight::notFound("Api version not found.");
			return;
		}


		$result = null;

		//Checking category if exist
		switch ($url->Category) {
			//=======================================Main
			case 'main':
			$result = Flight::process($url);
			break;

			//=======================================Data
			case 'data':
			$result = Flight::process($url);
			break;

			//=======================================Session
			case 'session':
			$result = Flight::process($url);
			break;

			default:
			Flight::notFound("Category not found.");

		}

		Flight::result(200,$result);

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
		$post = json_decode(file_get_contents("php://input"), true);
		return method_post($url, $post);
		
		case 'PUT':
		$put = json_decode(file_get_contents("php://input"), true);
		return method_put($url, $put);
		
		case 'DELETE':
		$delete = json_decode(file_get_contents("php://input"), true);
		return method_delete($url, $delete);

		case 'OPTIONS':
		$options = json_decode(file_get_contents("php://input"), true);
		return method_option($url, $options);

		case 'PATCH':
		$patch = json_decode(file_get_contents("php://input"), true);
		return method_patch($url, $patch);

		default: 
		Flight::notFound("Http verbs not recognized.");
	}
});


//Status Codes
Flight::map('noContent', function($message){
	$result = new Result();
	$result->Status = Result::ERROR;
	$result->Message = $message;
	Flight::result(204,$result);
});
Flight::map('notAuthorized', function($message){
	$result = new Result();
	$result->Status = Result::ERROR;
	$result->Message = $message;
	Flight::result(401,$result);
});
Flight::map('notFound', function($message){
	$result = new Result();
	$result->Status = Result::ERROR;
	$result->Message = $message;
	Flight::result(404,$result);
});
Flight::map('error', function(Exception $exception){
	$result = new Result();
	$result->Status = Result::ERROR;
	$result->Message = $exception->getMessage();
	Flight::result(501,$result);
});

Flight::map('result', function($status, $result) {
	Flight::response()
	->status($status)
	->header('Access-Control-Allow-Origin', '*')
	->header('Access-Control-Allow-Methods', 'GET,PUT,POST,DELETE,OPTIONS,PATCH')
	->header('Access-Control-Allow-Headers', 'Content-Type')
	->header('Access-Control-Allow-Headers', 'Content-Type')

	->header('Content-Type', 'application/json')
	->write(utf8_decode(json_encode($result)))
	->send();
});


Flight::set('flight.log_errors', true);
Flight::set('flight.handle_errors', true);

Flight::start();
?>