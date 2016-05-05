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

				
				array_push($result, $geofence);
			}

			
			Flight::ok($result);

		} catch (PDOException $pdoException) {
			Flight::error($pdoException);
		} catch (Exception $exception) {
			Flight::error($exception);
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
				Flight::notFound("id not found");
			}

			$row = $query->fetch(PDO::FETCH_ASSOC);

			
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


			Flight::ok($geofence);

		} catch (PDOException $pdoException) {
			Flight::error($pdoException);
		} catch (Exception $exception) {
			Flight::error($exception);
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
			$result->Status = Result::INSERTED;
			$result->Id = $connection->lastInsertId();
			$result->Message = 'Done';

			Flight::ok($result);

		} catch (PDOException $pdoException) {
			Flight::error($pdoException);
		} catch (Exception $exception) {
			Flight::error($exception);
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

			$query->bindParam(':id', $id, PDO::PARAM_INT);

			$query->execute();

			$result = new Result();
			$result->Status = Result::UPDATED;
			$result->Id = $id;
			$result->Message = 'Done.';

			Flight::ok($result);

		} catch (PDOException $pdoException) {
			Flight::error($pdoException);
		} catch (Exception $exception) {
			Flight::error($exception);
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

			Flight::ok($result);

		} catch (PDOException $pdoException) {
			Flight::error($pdoException);
		} catch (Exception $exception) {
			Flight::error($exception);
		} finally {
			$connection = null;
		}
	}
}

?>