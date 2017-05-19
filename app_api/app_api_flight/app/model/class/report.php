<?php 
/*
	Created by 		:		Rhalf Wendel D Caacbay
	Created on 		:		20170430

	Modified by 	:		#
	Modified on 	:		#

	functions 		:		Defines the class report and supplies the requests such as select, insert, update & delete.
*/
class Report {

	public $vehicle;
	public $type;


	public $dateFrom;
	public $dateTo;
	
	public $totalDistance;
	public $totalFuel;
	public $totalTime;

	public $geofences = array();
	public $areas = array();

	public $datas;

	
	public function __construct() {

	}

	public function getHistorical($param) {

		$report = new Report();
		$report->vehicle = $param->vehicle;
		$report->type = 'historical';
		$report->dateFrom = $param->dateFrom;
		$report->dateTo = $param->dateTo;

		$historical = Historical::generate($param);

		$report->datas = $historical;

		// foreach ($historical as $index => $row) {
		// 	$report->totalDistance += $row->io->odo;
		// 	$report->totalFuel += $row->io->odo / 11.0;
		// 	$report->totalTime += $row->io->runtime;
		// }

		return $report;
	}
	public function getRunning($param) {

		$report = new Report();
		$report->vehicle = $param->vehicle;
		$report->type = 'running';
		$report->dateFrom = $param->dateFrom;
		$report->dateTo = $param->dateTo;

		$historical = Historical::generate($param);
		$running = Running::generate($historical, $param);

		$report->datas = $running;

		foreach ($running as $index => $row) {
			// if ($row->status) {
				$report->totalDistance += $row->distance;
				$report->totalFuel += $row->distance / 11.0;
				$report->totalTime += $row->time;
			// }
		}

		return $report;
	}
	public function getIdling($param) {

		$report = new Report();
		$report->vehicle = $param->vehicle;
		$report->type = 'idling';
		$report->dateFrom = $param->dateFrom;
		$report->dateTo = $param->dateTo;


		$historical = Historical::generate($param);
		$idling = Idling::generate($historical, $param);

		$report->datas = $idling;

		foreach ($idling as $index => $row) {
			// if ($row->status) {
				$report->totalDistance += $row->distance;
				$report->totalFuel += $row->distance / 11.0;
				$report->totalTime += $row->time;
			// }
		}

		return $report;
	}
	public function getGeofencing($param) {

		$report = new Report();
		$report->vehicle = $param->vehicle;
		$report->type = 'geofencing';
		$report->dateFrom = $param->dateFrom;
		$report->dateTo = $param->dateTo;


		$historical = Historical::generate($param);
		$geofencing = Geofencing::generate($historical, $param);

		$report->datas = $geofencing;

		foreach ($geofencing as $index => $row) {
			// if ($row->status) {
				$report->totalDistance += $row->distance;
				$report->totalFuel += $row->distance / 11.0;
				$report->totalTime += $row->time;
				
				array_push($report->geofences, $row->geofenceTo); 
				array_push($report->areas, $row->areaTo); 
			// }
		}

		return $report;
	}
	public function getAreaing($param) {

		$report = new Report();
		$report->vehicle = $param->vehicle;
		$report->type = 'areaing';
		$report->dateFrom = $param->dateFrom;
		$report->dateTo = $param->dateTo;


		$historical = Historical::generate($param);
		$areaing = Areaing::generate($historical, $param);

		$report->datas = $areaing;

		foreach ($areaing as $index => $row) {
			// if ($row->status) {
				$report->totalDistance += $row->distance;
				$report->totalFuel += $row->distance / 11.0;
				$report->totalTime += $row->time;
				
				array_push($report->geofences, $row->geofenceTo); 
				array_push($report->areas, $row->areaTo); 
			// }
		}

		return $report;
	}
	public function getIgnition($param) {

		$report = new Report();
		$report->vehicle = $param->vehicle;
		$report->type = 'ignition';	
		$report->dateFrom = $param->dateFrom;
		$report->dateTo = $param->dateTo;


		$historical = Historical::generate($param);
		$ignition = Ignition::generate($historical, $param);


		$report->datas = $ignition;

		foreach ($ignition as $index => $row) {
			// if ($row->status) {
				$report->totalDistance += $row->distance;
				$report->totalFuel += $row->distance / 11.0;
				$report->totalTime += $row->time;
			// }
		}

		return $report;
	}
	public function getSpeeding($param) {

		$report = new Report();
		$report->vehicle = $param->vehicle;
		$report->type = 'speeding';
		$report->dateFrom = $param->dateFrom;
		$report->dateTo = $param->dateTo;


		$historical = Historical::generate($param);
		$speeding = Speeding::generate($historical, $param);

		$report->datas = $speeding;

		foreach ($speeding as $index => $row) {
			// if ($row->status) {
				$report->totalDistance += $row->distance;
				$report->totalFuel += $row->distance / 11.0;
				$report->totalTime += $row->time;
			// }
		}

		return $report;
	}
	public function getPowercutting($param) {

		$report = new Report();
		$report->vehicle = $param->vehicle;
		$report->type = 'powercutting';
		$report->dateFrom = $param->dateFrom;
		$report->dateTo = $param->dateTo;


		$historical = Historical::generate($param);
		$powercutting = Powercutting::generate($historical, $param);


		$report->datas = $powercutting;

		foreach ($powercutting as $index => $row) {
			// if ($row->status) {
				$report->totalDistance += $row->distance;
				$report->totalFuel += $row->distance / 11.0;
				$report->totalTime += $row->time;
			// }
		}

		return $report;
	}
}
?>