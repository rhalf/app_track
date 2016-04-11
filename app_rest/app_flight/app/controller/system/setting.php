<?php 

//Session
session_start();


//Database
Flight::register('dbMain', 'PDO', array('mysql:host=184.107.179.178;dbname=app_main','admin','admin'), function($dbMain){
	$dbMain->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$dbMain->setAttribute(PDO::ATTR_EMULATE_PREPARES, true);
});
Flight::register('dbData', 'PDO', array('mysql:host=184.107.179.178;dbname=app_data','admin','admin'), function($dbData){
	$dbData->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$dbData->setAttribute(PDO::ATTR_EMULATE_PREPARES, true);
});



// Flight::before('json', function() {
// 	header('Access-Control-Allow-Origin: *');
// 	header('Access-Control-Allow-Methods: GET,PUT,POST,DELETE,OPTIONS,PATCH');
// 	header('Access-Control-Allow-Headers: Content-Type');
// 	header('Content-Type: application/json; charset=UTF-8');

// });

//Api
$keys = array(
	'49xSgp6MDZFV3wb2' => 'Testing',
	'CjXSJrGje33Njj4G' => 'Reserve'
);




//Api Version
Flight::set('api_key', $keys);
Flight::set('api_version', 'v1');

?>	
