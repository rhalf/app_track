<?php

//Status Codes

//ok
Flight::map('ok', function($result){

	Flight::response()
	->status(200)
	->header('Access-Control-Allow-Origin', '*')
	->header('Access-Control-Allow-Methods', 'GET,PUT,POST,DELETE,OPTIONS,PATCH')
	->header('Access-Control-Allow-Headers', 'Content-Type')

	->header('Content-Type', 'application/json')
	->write(utf8_decode(json_encode($result)))
	->send();

});

//created
Flight::map('created', function($message){
	$result = new Result();
	$result->Status = Result::SUCCESS;
	$result->Message = $message;
	Flight::result(201,$result);
});

//bad request
Flight::map('badRequest', function($message){
	$result = new Result();
	$result->Status = Result::ERROR;
	$result->Message = $message;
	Flight::result(400,$result);
});
//unauthorized
Flight::map('unauthorized', function($message){
	$result = new Result();
	$result->Status = Result::ERROR;
	$result->Message = $message;
	Flight::result(401,$result);
});
//forbidden
Flight::map('forbidden', function($message){
	$result = new Result();
	$result->Status = Result::ERROR;
	$result->Message = $message;
	Flight::result(403,$result);
});
//notFound
Flight::map('notFound', function($message){
	$result = new Result();
	$result->Status = Result::NOTFOUND;
	$result->Message = $message;
	Flight::result(404, $result);
});

// Flight::map('noContent', function($message){
// 	$result = new Result();
// 	$result->Status = Result::ERROR;
// 	$result->Message = $message;
// 	Flight::result(204,$result);
// });

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

	->header('Content-Type', 'application/json')
	->write(utf8_decode(json_encode($result)))
	->send();
});

?>