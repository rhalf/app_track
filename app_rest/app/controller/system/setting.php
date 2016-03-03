<?php 

//Session
session_start();

//Database
$db1 = new Database("184.107.179.178", 3306, "app_main", "admin", "admin");
$db2 = new Database("184.107.179.178", 3306, "app_data_{year}", "admin", "admin");

Flight::set('db1', $db1);
Flight::set('db2', $db2);

//Api
$keys = array(
	'49xSgp6MDZFV3wb2' => 'Testing',
	'CjXSJrGje33Njj4G' => 'Reserve'
);

Flight::set('api_key', $keys);
Flight::set('api_version', 'v1');

?>
