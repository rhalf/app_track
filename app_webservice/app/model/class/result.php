<?php

class Result {
	public $Code = 0;
	public $Type = "";
	public $Message = "";

	const SYSTEM = 1;
	const PDO = 2;
	const SERVER = 3;

	public function __construct($code, $type, $message) {
		$this->Code = $code;
		$this->Message = $message;
		$this->Type = $type;

	}
}

?>