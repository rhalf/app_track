<?php

class Result {
	public $Status = null;		//State Error or Success
	public $Item = null;		//Affected Items
	public $Id = null;			//Affected Id

	public $Message = null;		//Details
	public $Object = null;		//Object Items
	
	const SUCCESS = 0;
	const ERROR = 1;

	public function __construct() {
	}
}

?>