<?php

class Result {
	public $Status = null;
	public $Item = null;
	public $Message = null;
	public $Object = null;
	
	const SUCCESS = 0;
	const ERROR = 1;

	public function __construct() {
	}
}

?>