<?php

class Result {

	public $Status = null;		//State Error or Success
	public $Id = null;			//Affected Id
	public $Message = null;		//Details
	


	const SUCCESS = 'SUCCESS';
	const ERROR = 'ERROR';

	const INSERTED = 'INSERTED';
	const UPDATED = 'UPDATED';
	const DELETED = 'DELETED';

	const NOTFOUND = 'NOTFOUND';
	const BADREQUEST = 'BADREQUEST';
	const UNAUTHORIZED = 'UNAUTHORIZED';
	const FORBIDDEN = 'FORBIDDEN';

	public function __construct(){

	}


}

?>