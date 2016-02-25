<?php 

require_once('/app/model/interface/iquery.php');

class Vehicle implements IQuery {

	public $Id;
	public $DtSubscribed;
	public $Registration;
	public $MaInitial;
	public $MaLimit;
	public $MaMaintenance;
	public $SpeedMax;
	public $Status;
	public $Fuel;
	public $Model;
	public $Driver;
	public $Unit;
	public $Company;


	public function __construct() {
	}

	public static function onSelect($get){
		$database = Flight::get('database');
		$connection = new PDO("mysql:host=$database->Ip;dbname=$database->Database", $database->Username, $database->Password);
		$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$connection->setAttribute(PDO::ATTR_EMULATE_PREPARES, true);

		$array['result'] = array();
		$array['vehicle'] = array();


		try {
			if (isset($get['id'])) {
				$sql = "SELECT * FROM vehicle WHERE id = :id;";
			} else {
				$sql = "SELECT * FROM vehicle;";
			}
			

			$query = $connection->prepare($sql);
			$query->bindParam(':id', $get['id'], PDO::PARAM_INT);

			$query->execute();

			$rows = $query->fetchAll(PDO::FETCH_ASSOC);

			if (!$rows) {
				throw new PDOException( "Object with id " . $get['id'] ." doesn't exist.", '02000');
			}

			foreach ($rows as $row) {	
				$vehicle = new User();
				$vehicle->Id = (int) $row['id'];
				$vehicle->DtSubscribed = $row['vehicle_dt_subscribed'];
				$vehicle->Registration = $row['vehicle_registration'];
				$vehicle->MaInitial = $row['vehicle_ma_initial'];
				$vehicle->MaMaintenance = $row['vehicle_ma_maintenance'];
				$vehicle->SpeedMax = $row['vehicle_speed_max'];
				$vehicle->Status = $row['e_status_id'];
				$vehicle->Fuel = $row['vehicle_fuel'];
				$vehicle->Model = (int) $row['model_id'];
				$vehicle->Driver = (int) $row['driver_id'];
				$vehicle->Unit = (int) $row['unit_id'];
				$vehicle->Company = (int) $row['company_id'];


				array_push($array['vehicle'], $vehicle);
			}

			$result = new Result(0, RESULT::PDO, "Success");
			$array['result'] = $result;

		} catch (PDOException $pdoException) {
			$result = new Result($pdoException->getCode(), RESULT::PDO, $pdoException->getMessage());
			$array['result'] = $result;
		} catch (Exception $exception) {
			$result = new Result(1, RESULT::SYSTEM, $exception->getMessage());
			$array['result'] = $result;
		}


		$connection = null;

		return $array;
	}
	public static function onInsert($post){
		$database = Flight::get('database');
		$connection = new PDO("mysql:host=$database->Ip;dbname=$database->Database", $database->Username, $database->Password);
		$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$connection->setAttribute(PDO::ATTR_EMULATE_PREPARES, true);

		try {

			$array['result'] = array();

			if(!isset($post['object'])) {
				throw new Exception("Input object is null", 1);
			}

			$json = $post['object'];

			$object = json_decode($json);

			$vehicle = $object->vehicle[0];

			$sql = "
			INSERT INTO vehicle 
			(vehicle_name, vehicle_password, vehicle_hash, vehicle_dt_created, vehicle_dt_expired, vehicle_dt_login, vehicle_dt_active, e_privilege_id, e_status_id, company_id)
			VALUES
			(:vehicle_name, :vehicle_password, :vehicle_hash, :vehicle_dt_created, :vehicle_dt_expired, :vehicle_dt_login, :vehicle_dt_active, :e_privilege_id, :e_status_id, :company_id);";


			$query = $connection->prepare($sql);

			$query->bindParam(':vehicle_name', $vehicle->Name, PDO::PARAM_STR);
			$query->bindParam(':vehicle_password', $vehicle->Password, PDO::PARAM_STR);
			$query->bindParam(':vehicle_hash', $vehicle->Hash, PDO::PARAM_STR);
			$query->bindParam(':vehicle_dt_created', $vehicle->DtCreated, PDO::PARAM_STR);
			$query->bindParam(':vehicle_dt_expired', $vehicle->DtExpired, PDO::PARAM_STR);
			$query->bindParam(':vehicle_dt_login', $vehicle->DtLogin, PDO::PARAM_STR);
			$query->bindParam(':vehicle_dt_active', $vehicle->DtActive, PDO::PARAM_STR);
			$query->bindParam(':e_privilege_id', $vehicle->Privilege, PDO::PARAM_INT);
			$query->bindParam(':e_status_id', $vehicle->Status, PDO::PARAM_INT);
			$query->bindParam(':company_id', $vehicle->Company, PDO::PARAM_INT);


			$query->execute();

			$result = new Result(0, RESULT::PDO, "Success");
			$array['result'] = $result;

		} catch (PDOException $pdoException) {
			$result = new Result($pdoException->getCode(), RESULT::PDO, $pdoException->getMessage());
			$array['result'] = $result;
		} catch (Exception $exception) {
			$result = new Result(1, RESULT::SYSTEM, $exception->getMessage());
			$array['result'] = $result;
		}

		$connection = null;

		return $array;
	}
	public static function onUpdate($put){
		$database = Flight::get('database');

		$connection = new PDO("mysql:host=$database->Ip;dbname=$database->Database", $database->Username, $database->Password);
		$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$connection->setAttribute(PDO::ATTR_EMULATE_PREPARES, true);

		//$connection->beginTransaction();

		$array['result'] = array();

		try {
			if (!isset($put['id']) || !isset($put['object'])) {
				throw new Exception("Input object and id are null.", 1);
			}

			$id = $put['id'];
			$object = json_decode($put['object']);

			$vehicle = $object->vehicle[0];

			$sql = "
			UPDATE vehicle 
			SET 
			vehicle_name = :vehicle_name,
			vehicle_password = :vehicle_password, 
			vehicle_hash = :vehicle_hash,
			vehicle_dt_created = :vehicle_dt_created,
			vehicle_dt_expired = :vehicle_dt_expired,
			vehicle_dt_login = :vehicle_dt_login,
			vehicle_dt_active = :vehicle_dt_active,
			e_privilege_id = :e_privilege_id,
			e_status_id = :e_status_id,
			company_id = :company_id
			WHERE
			id = :id;";

			$query = $connection->prepare($sql);

			$query->bindParam(':vehicle_name', $vehicle->Name, PDO::PARAM_STR);
			$query->bindParam(':vehicle_password', $vehicle->Password, PDO::PARAM_STR);
			$query->bindParam(':vehicle_hash', $vehicle->Hash, PDO::PARAM_STR);
			$query->bindParam(':vehicle_dt_created', $vehicle->DtCreated, PDO::PARAM_STR);
			$query->bindParam(':vehicle_dt_expired', $vehicle->DtExpired, PDO::PARAM_STR);
			$query->bindParam(':vehicle_dt_login', $vehicle->DtLogin, PDO::PARAM_STR);
			$query->bindParam(':vehicle_dt_active', $vehicle->DtActive, PDO::PARAM_STR);
			$query->bindParam(':e_privilege_id', $vehicle->Privilege , PDO::PARAM_INT);
			$query->bindParam(':e_status_id', $vehicle->Status, PDO::PARAM_INT);
			$query->bindParam(':company_id', $vehicle->Company, PDO::PARAM_INT);

			$query->bindParam(':id', $id, PDO::PARAM_INT);

			$query->execute();


			//$connection->commit();

			$result = new Result(0, RESULT::PDO, "Success");
			$array['result'] = $result;

		} catch (PDOException $pdoException) {
			//$connection->rollback();
			$result = new Result($pdoException->getCode(), RESULT::PDO, $pdoException->getMessage());
			$array['result'] = $result;
		} catch (Exception $exception) {
			//$connection->rollback();
			$result = new Result(1, RESULT::SYSTEM, $exception->getMessage());
			$array['result'] = $result;
		}

		$connection = null;

		return $array;
	}

	public static function onDelete($delete){
		$database = Flight::get('database');

		$connection = new PDO("mysql:host=$database->Ip;dbname=$database->Database", $database->Username, $database->Password);
		$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$connection->setAttribute(PDO::ATTR_EMULATE_PREPARES, true);

		$array['result'] = array();


		try {
			if (!isset($delete['id'])) {
				throw new Exception("Input id is null", 1);
			}

			$id = $delete['id'];

			$sql = "
			DELETE FROM vehicle 
			WHERE
			id = :id";

			$query = $connection->prepare($sql);

			$query->bindParam(':id', $id, PDO::PARAM_INT);

			$query->execute();

			$result = new Result(0, RESULT::PDO, "Success");
			$array['result'] = $result;

		} catch (PDOException $pdoException) {
			$result = new Result($pdoException->getCode(), RESULT::PDO, $pdoException->getMessage());
			$array['result'] = $result;
		} catch (Exception $exception) {
			$result = new Result(1, RESULT::SYSTEM, $exception->getMessage());
			$array['result'] = $result;
		}

		$connection = null;

		return $array;
	}

}

?>