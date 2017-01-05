<?php

class Coordinate {

	public $latitude;
	public $longitude;
	public $altitude;
	public $course;


	public function __construct($latitude, $longitude, $altitude, $course) {
		$this->latitude = (double) $latitude;
		$this->longitude = (double) $longitude;
		$this->altitude = (int) $altitude;
		$this->course = (int) $course;
	}
}

?>