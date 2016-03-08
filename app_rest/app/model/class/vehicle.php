<?php 

class Vehicle implements IQuery {

	public $Id;
	public $DtSubscribed;
	public $Plate;
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

	public static function onSelect(Url $url, $get) {
		$database = Flight::get('database');
		$connection = new PDO("mysql:host=$database->Ip;dbname=$database->Database", $database->Username, $database->Password);
		$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$connection->setAttribute(PDO::ATTR_EMULATE_PREPARES, true);

		try {

			if (!empty($url->Id)) {
				$sql = "SELECT * FROM vehicle WHERE id = :id;";
				$query = $connection->prepare($sql);
				$query->bindParam(':id',$url->Id, PDO::PARAM_INT);
			} else if (isset($get['name'])) {
				$sql = "SELECT * FROM vehicle WHERE vehicle_plate LIKE :vehicle_plate;";
				$query = $connection->prepare($sql);
				$query->bindParam(':vehicle_plate',$get['plate'], PDO::PARAM_STR);
			} else {
				$sql = "SELECT * FROM vehicle;";
				$query = $connection->prepare($sql);
			}

			$query->execute();

			$result = new Result();
			$result->Item = $query->rowCount();
			$result->Object['Vehicle'] = array();

			$rows = $query->fetchAll(PDO::FETCH_ASSOC);

			foreach ($rows as $row) {	
				$vehicle = new Vehicle();
				$vehicle->Id = (int) $row['id'];
				$vehicle->DtSubscribed = $row['vehicle_dt_subscribed'];
				$vehicle->Plate = $row['vehicle_plate'];
				$vehicle->MaInitial = $row['vehicle_ma_initial'];
				$vehicle->MaLimit = $row['vehicle_ma_limit'];
				$vehicle->MaMaintenance = $row['vehicle_ma_maintenance'];
				$vehicle->SpeedMax = $row['vehicle_speed_max'];
				$vehicle->Status = $row['e_status_id'];
				$vehicle->Fuel = $row['vehicle_fuel'];
				$vehicle->Model = (int) $row['model_id'];
				$vehicle->Driver = (int) $row['driver_id'];
				$vehicle->Unit = (int) $row['unit_id'];
				$vehicle->Company = (int) $row['company_id'];


				array_push($result->Object['Vehicle'], $vehicle);
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
	public static function onInsert(Url $url, $post) {
		$database = Flight::get('database');

		$connection = new PDO("mysql:host=$database->Ip;dbname=$database->Database", $database->Username, $database->Password);
		$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$connection->setAttribute(PDO::ATTR_EMULATE_PREPARES, true);

		try {

			if (!isset($post['object'])) {
				throw new Exception("Input object is not set.");
			}

			$object = json_decode($post['object']);
			$vehicle = $object->Vehicle[0];

			$sql = "
			INSERT INTO vehicle 
			(
			vehicle_dt_subscribed, 
			vehicle_plate, 
			vehicle_ma_initial, 
			vehicle_ma_limit, 
			vehicle_ma_maintenance, 
			vehicle_speed_max, 
			e_status_id, 
			vehicle_fuel, 
			model_id, 
			driver_id,
			unit_id, 
			company_id
			)
			
			VALUES
			(
			:vehicle_dt_subscribed, 
			:vehicle_plate, 
			:vehicle_ma_initial, 
			:vehicle_ma_limit, 
			:vehicle_ma_maintenance, 
			:vehicle_speed_max, 
			:e_status_id, 
			:vehicle_fuel, 
			:model_id, 
			:driver_id,
			:unit_id, 
			:company_id
			);";


			$query = $connection->prepare($sql);

			$query->bindParam(':vehicle_dt_subscribed', $vehicle->DtSubscribed, PDO::PARAM_STR);
			$query->bindParam(':vehicle_plate', $vehicle->Plate, PDO::PARAM_STR);
			$query->bindParam(':vehicle_ma_initial', $vehicle->MaInitial, PDO::PARAM_INT);
			$query->bindParam(':vehicle_ma_limit', $vehicle->MaLimit, PDO::PARAM_INT);
			$query->bindParam(':vehicle_ma_maintenance', $vehicle->MaMaintenance, PDO::PARAM_INT);
			$query->bindParam(':vehicle_speed_max', $vehicle->SpeedMax, PDO::PARAM_INT);
			$query->bindParam(':e_status_id', $vehicle->Status, PDO::PARAM_INT);
			$query->bindParam(':vehicle_fuel', $vehicle->Fuel, PDO::PARAM_INT);
			$query->bindParam(':model_id', $vehicle->Model, PDO::PARAM_INT);
			$query->bindParam(':driver_id', $vehicle->Driver, PDO::PARAM_INT);
			$query->bindParam(':unit_id', $vehicle->Unit, PDO::PARAM_INT);
			$query->bindParam(':company_id', $vehicle->Company, PDO::PARAM_INT);

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
	public static function onUpdate(Url $url, $put) {
		$database = Flight::get('database');
		$connection = new PDO("mysql:host=$database->Ip;dbname=$database->Database", $database->Username, $database->Password);
		$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$connection->setAttribute(PDO::ATTR_EMULATE_PREPARES, true);

		try {
			if (empty($url->Id)) {
				throw new Exception("Input id is empty.");
			}

			if (!isset($put['object'])) {
				throw new Exception("Input object is not set.");
			}

			$object = json_decode($put['object']);
			$vehicle = $object->Vehicle[0];

			$sql = "
			UPDATE vehicle 
			SET 
			vehicle_dt_subscribed = :vehicle_dt_subscribed,
			vehicle_plate = :vehicle_plate, 
			vehicle_ma_initial = :vehicle_ma_initial,
			vehicle_ma_limit = :vehicle_ma_limit,
			vehicle_ma_maintenance = :vehicle_ma_maintenance,
			vehicle_speed_max = :vehicle_speed_max,
			e_status_id = :e_status_id,
			vehicle_fuel = :vehicle_fuel,
			model_id = :model_id,
			driver_id = :driver_id,
			unit_id = :unit_id,
			company_id = :company_id

			WHERE
			id = :id;";

			$query = $connection->prepare($sql);

			$query->bindParam(':vehicle_dt_subscribed', $vehicle->DtSubscribed, PDO::PARAM_STR);
			$query->bindParam(':vehicle_plate', $vehicle->Plate, PDO::PARAM_STR);
			$query->bindParam(':vehicle_ma_initial', $vehicle->MaInitial, PDO::PARAM_INT);
			$query->bindParam(':vehicle_ma_limit', $vehicle->MaLimit, PDO::PARAM_INT);
			$query->bindParam(':vehicle_ma_maintenance', $vehicle->MaMaintenance, PDO::PARAM_INT);
			$query->bindParam(':vehicle_speed_max', $vehicle->SpeedMax, PDO::PARAM_INT);
			$query->bindParam(':e_status_id', $vehicle->Status, PDO::PARAM_INT);
			$query->bindParam(':vehicle_fuel', $vehicle->Fuel, PDO::PARAM_INT);
			$query->bindParam(':model_id', $vehicle->Model, PDO::PARAM_INT);
			$query->bindParam(':driver_id', $vehicle->Driver, PDO::PARAM_INT);
			$query->bindParam(':unit_id', $vehicle->Unit, PDO::PARAM_INT);
			$query->bindParam(':company_id', $vehicle->Company, PDO::PARAM_INT);

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
	public static function onDelete(Url $url, $delete) {
		$database = Flight::get('database');

		$connection = new PDO("mysql:host=$database->Ip;dbname=$database->Database", $database->Username, $database->Password);
		$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$connection->setAttribute(PDO::ATTR_EMULATE_PREPARES, true);

		try {

			if (empty($url->Id)) {
				throw new Exception("Input id is empty");
			}

			$sql = "
			DELETE FROM vehicle 
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