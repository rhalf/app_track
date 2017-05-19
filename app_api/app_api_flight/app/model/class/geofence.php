<?php 
/*
	Created by 		:		Rhalf Wendel D Caacbay
	Created on 		:		20170430

	Modified by 	:		#
	Modified on 	:		#

	functions 		:		Defines the class geofence and supplies the requests such as select, insert, update & delete.
*/
class Geofence implements IQuery {

	public $id;
	public $company;
	public $name;
	public $desc;
	public $coordinates;
	public $speedMinL;
	public $speedMaxL;
	public $speedMinH;
	public $speedMaxH;
	public $isVisible;
	

	public function __construct() {
	}

	public static function selectAll() {
		
		$connection = Flight::dbMain();

		try {

			$sql = "SELECT * FROM geofence;";
			$query = $connection->prepare($sql);


			$query->execute();

			$rows = $query->fetchAll(PDO::FETCH_ASSOC);

			$result = array();

			foreach ($rows as $row) {	
				$geofence = new Geofence();
				$geofence->id = (int) $row['id'];
				$geofence->company = Company::select($row['company_id']);
				$geofence->name = $row['geofence_name'];
				$geofence->desc = $row['geofence_desc'];
				$geofence->coordinates = json_decode($row['geofence_coordinates']);
				$geofence->speedMinL =  (int) $row['geofence_speed_min_l'];
				$geofence->speedMaxL = (int) $row['geofence_speed_max_l'];
				$geofence->speedMinH = (int) $row['geofence_speed_min_h'];
				$geofence->speedMaxH = (int) $row['geofence_speed_max_h'];
				$geofence->isVisible = (bool)  $row['geofence_is_visible'];

				
				array_push($result, $geofence);
			}

			
			return $result;

		} catch (PDOException $pdoException) {
			throw $pdoException;
		} catch (Exception $exception) {
			throw $exception;
		} finally {
			$connection = null;
		}
	}

	public static function select($id) {
		
		$connection = Flight::dbMain();

		try {

			$sql = "SELECT * FROM geofence WHERE id = :id;";
			$query = $connection->prepare($sql);
			$query->bindParam(':id',$id, PDO::PARAM_INT);

			$query->execute();

			if ($query->rowCount() < 1){
				return null;
			}

			$row = $query->fetch(PDO::FETCH_ASSOC);

			
			$geofence = new Geofence();
			$geofence->id = (int) $row['id'];
			$geofence->company = Company::select($row['company_id']);
			$geofence->name = $row['geofence_name'];
			$geofence->desc = $row['geofence_desc'];
			$geofence->coordinates = json_decode($row['geofence_coordinates']);
			$geofence->speedMinL =  (int) $row['geofence_speed_min_l'];
			$geofence->speedMaxL = (int) $row['geofence_speed_max_l'];
			$geofence->speedMinH = (int) $row['geofence_speed_min_h'];
			$geofence->speedMaxH = (int) $row['geofence_speed_max_h'];
			$geofence->isVisible = (bool) $row['geofence_is_visible'];

			return $geofence;

		} catch (PDOException $pdoException) {
			throw $pdoException;
		} catch (Exception $exception) {
			throw $exception;
		} finally {
			$connection = null;
		}
	}

	public static function selectByCompany($id) {
		
		$connection = Flight::dbMain();

		try {

			$sql = "SELECT * FROM geofence WHERE company_id = :company_id";
			$query = $connection->prepare($sql);
			$query->bindParam(':company_id',$id, PDO::PARAM_INT);


			$query->execute();

			$rows = $query->fetchAll(PDO::FETCH_ASSOC);

			$result = array();

			foreach ($rows as $row) {	
				$geofence = new Geofence();
				$geofence->id = (int) $row['id'];
				$geofence->company = Company::select($row['company_id']);
				$geofence->name = $row['geofence_name'];
				$geofence->desc = $row['geofence_desc'];
				$geofence->coordinates = json_decode($row['geofence_coordinates']);
				$geofence->speedMinL =  (int) $row['geofence_speed_min_l'];
				$geofence->speedMaxL = (int) $row['geofence_speed_max_l'];
				$geofence->speedMinH = (int) $row['geofence_speed_min_h'];
				$geofence->speedMaxH = (int) $row['geofence_speed_max_h'];
				$geofence->isVisible = (bool) $row['geofence_is_visible'];

				
				array_push($result, $geofence);
			}

			
			return $result;

		} catch (PDOException $pdoException) {
			throw $pdoException;
		} catch (Exception $exception) {
			throw $exception;
		} finally {
			$connection = null;
		}
	}

	public static function selectByIsGlobal($value) {
		
		$connection = Flight::dbMain();

		try {

			$sql = "SELECT * FROM geofence WHERE geofence_is_global = :value;";
			$query = $connection->prepare($sql);
			$query->bindParam(':value',$value, PDO::PARAM_INT);

			$query->execute();

			$rows = $query->fetchAll(PDO::FETCH_ASSOC);

			$result = array();

			foreach ($rows as $row) {	
				$geofence = new Geofence();
				$geofence->id = (int) $row['id'];
				$geofence->company = Company::select($row['company_id']);
				$geofence->name = $row['geofence_name'];
				$geofence->desc = $row['geofence_desc'];
				$geofence->coordinates = json_decode($row['geofence_coordinates']);
				$geofence->speedMinL =  (int) $row['geofence_speed_min_l'];
				$geofence->speedMaxL = (int) $row['geofence_speed_max_l'];
				$geofence->speedMinH = (int) $row['geofence_speed_min_h'];
				$geofence->speedMaxH = (int) $row['geofence_speed_max_h'];
				$geofence->isVisible = (bool) $row['geofence_is_visible'];

				
				array_push($result, $geofence);
			}

			
			return $result;

		} catch (PDOException $pdoException) {
			throw $pdoException;
		} catch (Exception $exception) {
			throw $exception;
		} finally {
			$connection = null;
		}
	}

	public static function insert() {
		
		$connection = Flight::dbMain();

		try {

			$geofence = json_decode(file_get_contents("php://input"));

			if ($geofence == null) {
				throw new Exception(json_get_error());
			}

			$sql = "
			INSERT INTO geofence 
			(
			company_id, 
			geofence_name,
			geofence_desc,
			geofence_coordinates,
			geofence_speed_min_l,
			geofence_speed_max_l,
			geofence_speed_min_h,
			geofence_speed_max_h,
			geofence_is_visible)
			VALUES
			(
			:company_id, 
			:geofence_name, 
			:geofence_desc, 
			:geofence_coordinates, 
			:geofence_speed_min_l, 
			:geofence_speed_max_l, 
			:geofence_speed_min_h,
			:geofence_speed_max_h,
			:geofence_is_visible
			);";


			$query = $connection->prepare($sql);

			$query->bindParam(':company_id', $geofence->company->id, PDO::PARAM_INT);
			$query->bindParam(':geofence_name', $geofence->name, PDO::PARAM_STR);
			$query->bindParam(':geofence_desc', $geofence->desc, PDO::PARAM_STR);
			
			$json = json_encode($geofence->coordinates);
			$query->bindParam(':geofence_coordinates', $json, PDO::PARAM_STR);
			
			$query->bindParam(':geofence_speed_min_l', $geofence->speedMinL, PDO::PARAM_INT);
			$query->bindParam(':geofence_speed_max_l', $geofence->speedMaxL, PDO::PARAM_INT);
			$query->bindParam(':geofence_speed_min_h', $geofence->speedMinH, PDO::PARAM_INT);
			$query->bindParam(':geofence_speed_max_h', $geofence->speedMaxH, PDO::PARAM_INT);
			$query->bindParam(':geofence_is_visible', $geofence->isVisible, PDO::PARAM_BOOL);

			$query->execute();
			
			$result = new Result();
			$result->status = Result::INSERTED;
			$result->id = $connection->lastInsertid();
			$result->message = 'Done';

			return $result;

		} catch (PDOException $pdoException) {
			throw $pdoException;
		} catch (Exception $exception) {
			throw $exception;
		} finally {
			$connection = null;
		}
	}
	public static function update($id) {
		
		$connection = Flight::dbMain();

		try {

			$geofence = json_decode(file_get_contents("php://input"));

			if ($geofence == null) {
				throw new Exception(json_get_error());
			}

			$sql = "
			UPDATE geofence 
			SET 
			company_id = :company_id,
			geofence_name = :geofence_name,
			geofence_desc = :geofence_desc,
			geofence_coordinates = :geofence_coordinates,
			geofence_speed_min_l = :geofence_speed_min_l,
			geofence_speed_max_l = :geofence_speed_max_l,
			geofence_speed_min_h = :geofence_speed_min_h,
			geofence_speed_max_h = :geofence_speed_max_h,
			geofence_is_visible = :geofence_is_visible
			WHERE
			id = :id;";

			$query = $connection->prepare($sql);

			$query->bindParam(':company_id', $geofence->company->id, PDO::PARAM_INT);
			$query->bindParam(':geofence_name', $geofence->name, PDO::PARAM_STR);
			$query->bindParam(':geofence_desc', $geofence->desc, PDO::PARAM_STR);

			$json = json_encode($geofence->coordinates);
			$query->bindParam(':geofence_coordinates', $json, PDO::PARAM_STR);

			$query->bindParam(':geofence_speed_min_l', $geofence->speedMinL, PDO::PARAM_INT);
			$query->bindParam(':geofence_speed_max_l', $geofence->speedMaxL, PDO::PARAM_INT);
			$query->bindParam(':geofence_speed_min_h', $geofence->speedMinH, PDO::PARAM_INT);
			$query->bindParam(':geofence_speed_max_h', $geofence->speedMaxH, PDO::PARAM_INT);
			$query->bindParam(':geofence_is_visible', $geofence->isVisible, PDO::PARAM_BOOL);

			$query->bindParam(':id', $id, PDO::PARAM_INT);

			$query->execute();

			$result = new Result();
			$result->status = Result::UPDATED;
			$result->id = $id;
			$result->message = 'Done.';

			return $result;

		} catch (PDOException $pdoException) {
			throw $pdoException;
		} catch (Exception $exception) {
			throw $exception;
		} finally {
			$connection = null;
		}
	}

	public static function delete($id) {

		$connection = Flight::dbMain();

		try {

			$sql = "
			DELETE FROM geofence 
			WHERE
			id = :id";

			$query = $connection->prepare($sql);

			$query->bindParam(':id', $id, PDO::PARAM_INT);

			$query->execute();

			$result = new Result();
			$result->status = Result::DELETED;
			$result->message = 'Done';
			$result->id = $id;

			return $result;

		} catch (PDOException $pdoException) {
			throw $pdoException;
		} catch (Exception $exception) {
			throw $exception;
		} finally {
			$connection = null;
		}
	}



	public static function selectByUnit($geofences, $unitData){

			$coordinate = $unitData->gps->coordinate;

			$result = null;
			//$result = array();

			foreach ($geofences as $index => $geofence) {
				if(Geofence::checkPoint($geofence, $coordinate) == true) {
					//array_push($result, $geofence);
					$result =  $geofence->id;
				}
			}

			return $result;
	}


	private static function checkPoint($geofence, $coordinate) {

            
			 $coordinates = $geofence->coordinates;
			 $count = sizeof($geofence->coordinates);

            $result = false;


            for ($index1 = 0, $index2 = $count - 1; $index1 < $count; $index2 = $index1++) {
                if (((($coordinates[$index1]->latitude <= $coordinate->latitude) && ($coordinate->latitude < $coordinates[$index2]->latitude))
                        || (($coordinates[$index2]->latitude <= $coordinate->latitude) && ($coordinate->latitude < $coordinates[$index1]->latitude)))
                        && ($coordinate->longitude < ($coordinates[$index2]->longitude - $coordinates[$index1]->longitude) * ($coordinate->latitude - $coordinates[$index1]->latitude)
                            / ($coordinates[$index2]->latitude - $coordinates[$index1]->latitude) + $coordinates[$index1]->longitude)) {
                    $result = !$result;
                }
            }

            return $result;
    }
	
}

?>
