<?php

class Coordinate {
	public $Latitude;
	public $Longitude;

	public function __construct($latitude, $longitude) {
		$this->Latitude = (double) $latitude;
		$this->Longitude = (double) $longitude;
	}
}

?>