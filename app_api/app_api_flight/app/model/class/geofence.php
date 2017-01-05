<?php 

class Geofence implements IQuery {

	public $Id;
	public $Company;
	public $Name;
	public $Desc;
	public $Coordinates;
	public $SpeedMinL;
	public $SpeedMaxL;
	public $SpeedMinH;
	public $SpeedMaxH;
	public $IsVisible;
	

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
				$geofence->Id = (int) $row['id'];
				$geofence->Company = Company::select($row['company_id']);
				$geofence->Name = $row['geofence_name'];
				$geofence->Desc = $row['geofence_desc'];
				$geofence->Coordinates = json_decode($row['geofence_coordinates']);
				$geofence->SpeedMinL =  (int) $row['geofence_speed_min_l'];
				$geofence->SpeedMaxL = (int) $row['geofence_speed_max_l'];
				$geofence->SpeedMinH = (int) $row['geofence_speed_min_h'];
				$geofence->SpeedMaxH = (int) $row['geofence_speed_max_h'];
				$geofence->IsVisible = (bool)  $row['geofence_is_visible'];

				
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
			$geofence->Id = (int) $row['id'];
			$geofence->Company = Company::select($row['company_id']);
			$geofence->Name = $row['geofence_name'];
			$geofence->Desc = $row['geofence_desc'];
			$geofence->Coordinates = json_decode($row['geofence_coordinates']);
			$geofence->SpeedMinL =  (int) $row['geofence_speed_min_l'];
			$geofence->SpeedMaxL = (int) $row['geofence_speed_max_l'];
			$geofence->SpeedMinH = (int) $row['geofence_speed_min_h'];
			$geofence->SpeedMaxH = (int) $row['geofence_speed_max_h'];
			$geofence->IsVisible = (bool) $row['geofence_is_visible'];

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
				$geofence->Id = (int) $row['id'];
				$geofence->Company = Company::select($row['company_id']);
				$geofence->Name = $row['geofence_name'];
				$geofence->Desc = $row['geofence_desc'];
				$geofence->Coordinates = json_decode($row['geofence_coordinates']);
				$geofence->SpeedMinL =  (int) $row['geofence_speed_min_l'];
				$geofence->SpeedMaxL = (int) $row['geofence_speed_max_l'];
				$geofence->SpeedMinH = (int) $row['geofence_speed_min_h'];
				$geofence->SpeedMaxH = (int) $row['geofence_speed_max_h'];
				$geofence->IsVisible = (bool) $row['geofence_is_visible'];

				
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
				$geofence->Id = (int) $row['id'];
				$geofence->Company = Company::select($row['company_id']);
				$geofence->Name = $row['geofence_name'];
				$geofence->Desc = $row['geofence_desc'];
				$geofence->Coordinates = json_decode($row['geofence_coordinates']);
				$geofence->SpeedMinL =  (int) $row['geofence_speed_min_l'];
				$geofence->SpeedMaxL = (int) $row['geofence_speed_max_l'];
				$geofence->SpeedMinH = (int) $row['geofence_speed_min_h'];
				$geofence->SpeedMaxH = (int) $row['geofence_speed_max_h'];
				$geofence->IsVisible = (bool) $row['geofence_is_visible'];

				
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

			$query->bindParam(':company_id', $geofence->Company->Id, PDO::PARAM_INT);
			$query->bindParam(':geofence_name', $geofence->Name, PDO::PARAM_STR);
			$query->bindParam(':geofence_desc', $geofence->Desc, PDO::PARAM_STR);
			
			$json = json_encode($geofence->Coordinates);
			$query->bindParam(':geofence_coordinates', $json, PDO::PARAM_STR);
			
			$query->bindParam(':geofence_speed_min_l', $geofence->SpeedMinL, PDO::PARAM_INT);
			$query->bindParam(':geofence_speed_max_l', $geofence->SpeedMaxL, PDO::PARAM_INT);
			$query->bindParam(':geofence_speed_min_h', $geofence->SpeedMinH, PDO::PARAM_INT);
			$query->bindParam(':geofence_speed_max_h', $geofence->SpeedMaxH, PDO::PARAM_INT);
			$query->bindParam(':geofence_is_visible', $geofence->IsVisible, PDO::PARAM_BOOL);

			$query->execute();
			
			$result = new Result();
			$result->Status = Result::INSERTED;
			$result->Id = $connection->lastInsertId();
			$result->Message = 'Done';

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

			$query->bindParam(':company_id', $geofence->Company->Id, PDO::PARAM_INT);
			$query->bindParam(':geofence_name', $geofence->Name, PDO::PARAM_STR);
			$query->bindParam(':geofence_desc', $geofence->Desc, PDO::PARAM_STR);

			$json = json_encode($geofence->Coordinates);
			$query->bindParam(':geofence_coordinates', $json, PDO::PARAM_STR);

			$query->bindParam(':geofence_speed_min_l', $geofence->SpeedMinL, PDO::PARAM_INT);
			$query->bindParam(':geofence_speed_max_l', $geofence->SpeedMaxL, PDO::PARAM_INT);
			$query->bindParam(':geofence_speed_min_h', $geofence->SpeedMinH, PDO::PARAM_INT);
			$query->bindParam(':geofence_speed_max_h', $geofence->SpeedMaxH, PDO::PARAM_INT);
			$query->bindParam(':geofence_is_visible', $geofence->IsVisible, PDO::PARAM_BOOL);

			$query->bindParam(':id', $id, PDO::PARAM_INT);

			$query->execute();

			$result = new Result();
			$result->Status = Result::UPDATED;
			$result->Id = $id;
			$result->Message = 'Done.';

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
			$result->Status = Result::DELETED;
			$result->Message = 'Done';
			$result->Id = $id;

			return $result;

		} catch (PDOException $pdoException) {
			throw $pdoException;
		} catch (Exception $exception) {
			throw $exception;
		} finally {
			$connection = null;
		}
	}
}

?>
