<?php 

class Header {
	public $dtServer;
	public $dtClient;
	public $command;
	public $event;
	public $length;
	

	public function __construct($dtServer, $dtClient, $command, $event, $length) {
		$this->dtServer = $dtServer;
		$this->dtClient = $dtClient;
		$this->command = $command;
		$this->event = $event;	
		$this->length = $length;
	}

}

?>
