<?php

require_once 'app/controller/system/include.php';
require_once 'app/controller/system/setting.php';


//Database
$database1 = new Database("184.107.179.178", 3306, "app_main", "admin", "admin");
$database2 = new Database("184.107.179.178", 3306, "app_data_{year}", "admin", "admin");
Flight::set('database1', $database1);
Flight::set('database2', $database2);

//Main Entry Point
Flight::route('/(@version(/@category(/@class(/@id:[0-9]+))))', function($version, $category, $class, $id){

	if (empty($version) || empty($category) || empty($class)) {
		Flight::notFound("Not found.");
	}

	if ($version != "v1"){
		Flight::notFound("Not found.");
	}

	$data = null;
	$result = null;


	switch ($category) {
		case 'main':
		Flight::set('database', Flight::get('database1'));
		$data = Flight::process($class);
		break;
		case 'data':
		Flight::set('database', Flight::get('database2'));
		$data = Flight::process($class);
		break;
		default:
		Flight::notFound("Category $category not found.");
		break;
	}

	
	echo json_indent(json_encode($data));
});


Flight::map('process', function($class) {
	$data = null;
	$request = Flight::request();
	switch ($request->method) {
		case 'GET':
		$data = method_get($class, $_GET);
		break;
		case 'POST':
		$data = method_post($class, $_POST);
		break;
		case 'PUT':
		parse_str(file_get_contents("php://input"),$put);
		$data = method_put($class, $put);
		break;
		case 'DELETE':
		parse_str(file_get_contents("php://input"),$delete);
		$data = method_delete($class, $delete);
		break;
	}
	return $data;
});



Flight::map('error', function(Exception $exception){
	$data['result'] = array();
	$data['result'] = new Result(501, Result::SYSTEM,$exception->getMessage());	
	Flight::halt(501, json_indent(json_encode($data)));
});

Flight::map('noContent', function(){
	$data['result'] = array();
	$data['result'] = new Result(204, Result::SERVER,"No Content!");
	Flight::halt(204, json_indent(json_encode($data)));
});

Flight::map('notFound', function($message){
	$data['result'] = array();
	$data['result'] = new Result(404, Result::SERVER,$message);
	Flight::halt(404, json_indent(json_encode($data)));
});

Flight::set('flight.log_errors', true);
Flight::start();
?>