<?php

class Coordinate {
	public $Latitude;
	public $Longitude;
	public $Altitude;

	public function __construct($latitude, $longitude, $altitude) {
		$this->Latitude = (double) $latitude;
		$this->Longitude = (double) $longitude;
		$this->Altitude = (double) $altitude;

	}
}

?>