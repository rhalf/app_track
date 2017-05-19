<?php
/*
	Created by 		:		Rhalf Wendel D Caacbay
	Created on 		:		20170430

	Modified by 	:		#
	Modified on 	:		#

	functions 		:		Mapping of crud responses on each situation.
*/
//ok
Flight::map('ok', function($result){

	Flight::response()
	->status(200)
	->header('Access-Control-Allow-Origin', '*')
	->header('Content-Type', 'application/json')
	->header('Expires', '0')
	->header('Last-Modified', gmdate("D, d M Y H:i:s") . " GMT")
	->header('Cache-Control', 'no-store, no-cache, must-revalidate')
	->header('Pragma', 'no-cache')



	->write(utf8_decode(json_encode($result)))
	->send();

});

Flight::map('preFlight', function(){
	Flight::response()
	->status(200)
	->header('Access-Control-Allow-Origin', '*')
	->header('Access-Control-Allow-Headers', 'content-type,x-requested-with,x-api-key,X-ACCOUNT-API-KEY,X-USER-API-KEY,account_api_key,user_api_key')
	->header('Access-Control-Allow-Methods', 'GET,POST,PUT,DELETE,OPTIONS')
	->send();
});

//created
Flight::map('created', function($message){
	$result = new Result();
	$result->status = Result::SUCCESS;
	$result->message = $message;
	Flight::result(201,$result);
});

//bad request
Flight::map('badRequest', function($message){
	$result = new Result();
	$result->status = Result::ERROR;
	$result->message = $message;
	Flight::result(400,$result);
});
//unauthorized
Flight::map('unauthorized', function($message){
	$result = new Result();
	$result->status = Result::ERROR;
	$result->message = $message;
	Flight::result(401,$result);
});
//forbidden
Flight::map('forbidden', function($message){
	$result = new Result();
	$result->status = Result::ERROR;
	$result->message = $message;
	Flight::result(403,$result);
});
//notFound
Flight::map('notFound', function($message){
	$result = new Result();
	$result->status = Result::NOTFOUND;
	$result->message = $message;
	Flight::result(404, $result);
});

// Flight::map('noContent', function($message){
// 	$result = new Result();
// 	$result->status = Result::ERROR;
// 	$result->message = $message;
// 	Flight::result(204,$result);
// });

Flight::map('error', function(Exception $exception){
	$result = new Result();
	$result->status = Result::ERROR;
	$result->message = $exception->getMessage();
	Flight::result(501,$result);
});


Flight::map('result', function($status, $result) {
	Flight::response()
	->status($status)
	->header('Access-Control-Allow-Origin', '*')
	->header('Access-Control-Allow-Methods', 'GET,PUT,POST,DELETE,OPTIONS,PATCH')
	->header('Access-Control-Allow-Headers', 'Content-Type')

	->header('Content-Type', 'application/json')
	->write(utf8_decode(json_encode($result)))
	->send();
});

?>