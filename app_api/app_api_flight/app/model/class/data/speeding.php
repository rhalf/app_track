<?php 
/*
	Created by 		:		Rhalf Wendel D Caacbay
	Created on 		:		20170430

	Modified by 	:		#
	Modified on 	:		#

	functions 		:		Defines the class speeding and generates overspeeding report base on historical data.
*/
class Speeding implements IQuery {

	public $id;
	public $status;
	public $coordinateFrom;
	public $coordinateTo;
	public $dtFrom;
	public $dtTo;
	public $time;
	public $distance;
	public $speedMax;
	public $speedAve;
	public $geofenceFrom;
	public $geofenceTo;
	public $areaFrom;
	public $areaTo;


	public function __construct() {
	}


	public static function generate($historical, $param) {

		try {

$array = array();

		
			//================================================================
			$index = 0;
			$id = 0;

			$statusNow = null;
			$statusOld = null;

			$dtFrom = $param->dateFrom;
			$dtTo = null;


			$distance = 0;
			$distanceFrom = null;
			$distanceTo = null;

			$time = 0;
			$timeFrom = null;
			$timeTo = null;

			$geofenceFrom = null;
			$geofenceTo = null;

			$areaFrom = null;
			$areaTo = null;

			$speedSum = 0;
			$speedDiv = 1;
			$speedMax = 0;

			$coordinateFrom = null;
			$coordinateTo = null;



	 		foreach($historical as $index => $unitData) {

	 				//Updating flag
	 				if($unitData->io->speed > $param->vehicle->speedMax) {
	 					$statusNow = true;
	 				} else {
	 					$statusNow = false;
	 				}

	 				//First value
	 				if ($index == 0) {
	 					$distanceFrom = $unitData->io->odo;
	 					$timeFrom = $unitData->io->runtime;
	 					$coordinateFrom = $unitData->gps->coordinate;
	 					$geofenceFrom = $unitData->geofence;
	 					$areaFrom = $unitData->area;
	 				}

	 		

					if($statusNow != $statusOld) {

	 					$statusOld = $statusNow;

	 					$dtTo = $unitData->header->dtClient;
	 					$distanceTo = $unitData->io->odo;
	 					$timeTo = $unitData->io->runtime;
	 					$coordinateTo = $unitData->gps->coordinate;
	 					$geofenceTo = $unitData->geofence;
	 					$areaTo = $unitData->area;

	 					$obj = new Speeding();
	 					$obj->id = ++$id;
	 					$obj->status = !$statusNow;
	 					$obj->dtFrom = $dtFrom;
	 					$obj->dtTo = $dtTo;
	 					$obj->time = $timeTo - $timeFrom;
	 					$obj->distance = $distanceTo - $distanceFrom;
	 					$obj->speedAve = $speedSum / $speedDiv;
	 					$obj->speedMax = $speedMax;
	 					$obj->coordinateFrom = $coordinateFrom;
	 					$obj->coordinateTo = $coordinateTo;
	 					$obj->geofenceFrom = $geofenceFrom;
	 					$obj->geofenceTo = $geofenceTo;
						$obj->areaFrom = $areaFrom;
	 					$obj->areaTo = $areaTo;

	 					array_push($array, $obj);


						$dtFrom = $dtTo;
	 					$distanceFrom = $distanceTo;
	 					$timeFrom = $timeTo;
	 					$coordinateFrom = $coordinateTo;
	 					$geofenceFrom = $geofenceTo;
	 					$areaFrom = $areaTo;

 						$speedSum = 0;
						$speedDiv = 1;
						$speedMax = 0;
	 				}


	 				if (($index + 1) == sizeof($historical)) {

	 					$dtTo = $unitData->header->dtClient;
	 					$distanceTo = $unitData->io->odo;
	 					$timeTo = $unitData->io->runtime;
	 					$coordinateTo = $unitData->gps->coordinate;
	 					$geofenceTo = $unitData->geofence;
	 					$areaTo = $unitData->area;

	 					$obj = new Speeding();
	 					$obj->id = ++$id;
	 					$obj->status = $statusNow;
	 					$obj->dtFrom = $dtFrom;
	 					$obj->dtTo = $param->dateTo;
	 					$obj->time = $timeTo - $timeFrom;
	 					$obj->distance = $distanceTo - $distanceFrom;
	 					$obj->speedAve = $speedSum / $speedDiv;
	 					$obj->speedMax = $speedMax;
	 					$obj->coordinateFrom = $coordinateFrom;
	 					$obj->coordinateTo = $coordinateTo;
	 					$obj->geofenceFrom = $geofenceFrom;
	 					$obj->geofenceTo = $geofenceTo;
						$obj->areaFrom = $areaFrom;
	 					$obj->areaTo = $areaTo;

	 					array_push($array, $obj);
	 				}

	 				//Updating value		
	 				$distance += $unitData->io->odo;
	 				$time += $unitData->io->runtime;


				if ($statusNow) {
					$speedSum += $unitData->io->speed;
					$speedDiv++;
					$speedMax = ($speedMax < $unitData->io->speed) ? $unitData->io->speed : $speedMax; 
				}
 				
	 		}
			
			return $array;

	
		} catch (Exception $exception) {
			throw $exception;
		} 
	}

}
?>
