<?php 

class Geofence implements IQuery {

	public $Id;
	public $Company;
	public $Name;
	public $Desc;
	public $Coordinates;
	public $Type;
	public $SpeedMinL;
	public $SpeedMaxL;
	public $SpeedMinH;
	public $SpeedMaxH;
	public $IsGlobal;
	public $IsVisible;
	

	public function __construct() {
	}

	public static function onSelect(Url $url, $data) {
		$database = Flight::get('database');
		$connection = new PDO("mysql:host=$database->Ip;dbname=$database->Database", $database->Username, $database->Password);
		$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$connection->setAttribute(PDO::ATTR_EMULATE_PREPARES, true);

		try {

			if (!empty($url->Id)) {
				$sql = "SELECT * FROM geofence WHERE id = :id;";
				$query = $connection->prepare($sql);
				$query->bindParam(':id',$url->Id, PDO::PARAM_INT);
			} else if (isset($data['name'])) {
				$sql = "SELECT * FROM geofence WHERE geofence_name LIKE :name;";
				$query = $connection->prepare($sql);
				$query->bindParam(':name',$data['name'], PDO::PARAM_STR);
			} else {
				$sql = "SELECT * FROM geofence;";
				$query = $connection->prepare($sql);
			}

			$query->execute();

			$result = new Result();
			$result->Item = $query->rowCount();
			$result->Object = array();

			$rows = $query->fetchAll(PDO::FETCH_ASSOC);

			foreach ($rows as $row) {	
				$geofence = new Geofence();
				$geofence->Id = (int) $row['id'];
				$geofence->Company = (int) $row['company_id'];
				$geofence->Name = $row['geofence_name'];
				$geofence->Desc = $row['geofence_desc'];
				$geofence->Coordinates = $row['geofence_coordinates'];
				$geofence->Type = (int) $row['geofence_type'];
				$geofence->SpeedMinL =  (int) $row['geofence_speed_min_l'];
				$geofence->SpeedMaxL = (int) $row['geofence_speed_max_l'];
				$geofence->SpeedMinH = (int) $row['geofence_speed_min_h'];
				$geofence->SpeedMaxH = (int) $row['geofence_speed_max_h'];
				$geofence->IsGlobal = (int) $row['geofence_is_global'];
				$geofence->IsVisible = (int) $row['geofence_is_visible'];

				
				array_push($result->Object, $geofence);
			}

			$result->Status = Result::SUCCESS;
			$result->Message = 'Done.';

		} catch (PDOException $pdoException) {
			$result = new Result();
			$result->Status = Result::ERROR;
			$result->Message = $pdoException->getMessage();
		} catch (Exception $exception) {
			$result = new Result();
			$result->Status = Result::ERROR;
			$result->Message = $exception->getMessage();
		}

		$connection = null;

		return $result;
	}
	public static function onInsert(Url $url, $data) {
		$database = Flight::get('database');
		$connection = new PDO("mysql:host=$database->Ip;dbname=$database->Database", $database->Username, $database->Password);
		$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$connection->setAttribute(PDO::ATTR_EMULATE_PREPARES, true);

		try {

			if (!isset($data['Object'])) {
				throw new Exception("Input object is not set.");
			}

			$geofence = json_decode($data['Object']);
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
				geofence_type,
				geofence_speed_min_l,
				geofence_speed_max_l,
				geofence_speed_min_h,
				geofence_speed_max_h,
				geofence_is_global,
				geofence_is_visible)
			VALUES
			(
				:company_id, 
				:geofence_name, 
				:geofence_desc, 
				:geofence_coordinates, 
				:geofence_type, 
				:geofence_speed_min_l, 
				:geofence_speed_max_l, 
				:geofence_speed_min_h,
				:geofence_speed_max_h,
				:geofence_is_global,
				:geofence_is_visible
				);";


			$query = $connection->prepare($sql);

			$query->bindParam(':company_id', $geofence->Company, PDO::PARAM_INT);
			$query->bindParam(':geofence_name', $geofence->Name, PDO::PARAM_STR);
			$query->bindParam(':geofence_desc', $geofence->Desc, PDO::PARAM_STR);
			$query->bindParam(':geofence_coordinates', $geofence->Coordinates, PDO::PARAM_STR);
			$query->bindParam(':geofence_type', $geofence->Type, PDO::PARAM_INT);
			$query->bindParam(':geofence_speed_min_l', $geofence->SpeedMinL, PDO::PARAM_INT);
			$query->bindParam(':geofence_speed_max_l', $geofence->SpeedMaxL, PDO::PARAM_INT);
			$query->bindParam(':geofence_speed_min_h', $geofence->SpeedMinH, PDO::PARAM_INT);
			$query->bindParam(':geofence_speed_max_h', $geofence->SpeedMaxH, PDO::PARAM_INT);
			$query->bindParam(':geofence_is_global', $geofence->IsGlobal, PDO::PARAM_INT);
			$query->bindParam(':geofence_is_visible', $geofence->IsVisible, PDO::PARAM_INT);

			$query->execute();

			$result = new Result();
			$result->Status = Result::SUCCESS;
			$result->Item = $query->rowCount();
			$result->Message = 'Done.';

		} catch (PDOException $pdoException) {
			$result = new Result();
			$result->Status = Result::ERROR;
			$result->Message = $pdoException->getMessage();
		} catch (Exception $exception) {
			$result = new Result();
			$result->Status = Result::ERROR;
			$result->Message = $exception->getMessage();
		}

		$connection = null;

		return $result;
	}
	public static function onUpdate(Url $url, $data) {
		$database = Flight::get('database');
		$connection = new PDO("mysql:host=$database->Ip;dbname=$database->Database", $database->Username, $database->Password);
		$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$connection->setAttribute(PDO::ATTR_EMULATE_PREPARES, true);

		try {
			if (empty($url->Id)) {
				throw new Exception("Input id is empty.");
			}

			if (!isset($data['Object'])) {
				throw new Exception("Input object is not set.");
			}

			$geofence = json_decode($data['Object']);
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
			geofence_type = :geofence_type,
			geofence_speed_min_l = :geofence_speed_min_l,
			geofence_speed_max_l = :geofence_speed_max_l,
			geofence_speed_min_h = :geofence_speed_min_h,
			geofence_speed_max_h = :geofence_speed_max_h,
			geofence_is_global = :geofence_is_global,
			geofence_is_visible = :geofence_is_visible
			WHERE
			id = :id;";

			$query = $connection->prepare($sql);

			$query->bindParam(':company_id', $geofence->Company, PDO::PARAM_INT);
			$query->bindParam(':geofence_name', $geofence->Name, PDO::PARAM_STR);
			$query->bindParam(':geofence_desc', $geofence->Desc, PDO::PARAM_STR);
			$query->bindParam(':geofence_coordinates', $geofence->Coordinates, PDO::PARAM_STR);
			$query->bindParam(':geofence_type', $geofence->Type, PDO::PARAM_INT);
			$query->bindParam(':geofence_speed_min_l', $geofence->SpeedMinL, PDO::PARAM_INT);
			$query->bindParam(':geofence_speed_max_l', $geofence->SpeedMaxL, PDO::PARAM_INT);
			$query->bindParam(':geofence_speed_min_h', $geofence->SpeedMinH, PDO::PARAM_INT);
			$query->bindParam(':geofence_speed_max_h', $geofence->SpeedMaxH, PDO::PARAM_INT);
			$query->bindParam(':geofence_is_global', $geofence->IsGlobal, PDO::PARAM_INT);
			$query->bindParam(':geofence_is_visible', $geofence->IsVisible, PDO::PARAM_INT);



			$query->bindParam(':id', $url->Id, PDO::PARAM_INT);

			$query->execute();

			$result = new Result();
			$result->Status = Result::SUCCESS;
			$result->Item = $query->rowCount();
			$result->Message = 'Done.';

		} catch (PDOException $pdoException) {
			$result = new Result();
			$result->Status = Result::ERROR;
			$result->Message = $pdoException->getMessage();
		} catch (Exception $exception) {
			$result = new Result();
			$result->Status = Result::ERROR;
			$result->Message = $exception->getMessage();
		}

		$connection = null;
		return $result;
	}
	public static function onDelete(Url $url, $data) {
		$database = Flight::get('database');
		
		$connection = new PDO("mysql:host=$database->Ip;dbname=$database->Database", $database->Username, $database->Password);
		$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$connection->setAttribute(PDO::ATTR_EMULATE_PREPARES, true);

		try {
			
			if (empty($url->Id)) {
				throw new Exception("Input id is empty");
			}

			$sql = "
			DELETE FROM geofence 
			WHERE
			id = :id";

			$query = $connection->prepare($sql);

			$query->bindParam(':id', $url->Id, PDO::PARAM_INT);

			$query->execute();

			$result = new Result();
			$result->Status = Result::SUCCESS;
			$result->Item = $query->rowCount();
			$result->Message = 'Done.';

		} catch (PDOException $pdoException) {
			$result = new Result();
			$result->Status = Result::ERROR;
			$result->Message = $pdoException->getMessage();
		} catch (Exception $exception) {
			$result = new Result();
			$result->Status = Result::ERROR;
			$result->Message = $exception->getMessage();
		}

		$connection = null;
		return $result;
	}
}

?>