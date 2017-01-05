<?php 

class Gprs {
	public $signal;
	public $status;
	

	public function __construct($signal, $status) {
		$this->signal = (int) $status;
		$this->status = (int) $status;
	}

}

?>
