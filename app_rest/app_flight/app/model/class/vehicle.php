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
	public $FuelMax;
	public $Model;
	public $Driver;
	public $Unit;
	public $Company;

	
	public function __construct() {
	}


	public static function selectAll() {

		$connection = Flight::dbMain();

		try {

			$sql = "SELECT * FROM vehicle;";
			$query = $connection->prepare($sql);

			$query->execute();

			$rows = $query->fetchAll(PDO::FETCH_ASSOC);

			$result = array();

			foreach ($rows as $row) {	
				$vehicle = new Vehicle();
				$vehicle->Id = (int) $row['id'];
				$vehicle->DtSubscribed = $row['vehicle_dt_subscribed'];
				$vehicle->Plate = $row['vehicle_plate'];
				$vehicle->MaInitial = (int)$row['vehicle_ma_initial'];
				$vehicle->MaLimit = (int)$row['vehicle_ma_limit'];
				$vehicle->MaMaintenance = (int)$row['vehicle_ma_maintenance'];
				$vehicle->SpeedMax = (int)$row['vehicle_speed_max'];
				$vehicle->Status = (int)$row['e_status_id'];
				$vehicle->Fuel = (int)$row['vehicle_fuel'];
				$vehicle->FuelMax = (int)$row['vehicle_fuel_max'];
				$vehicle->Model = (int) $row['vehicle_model_id'];
				$vehicle->Driver = (int) $row['driver_id'];
				$vehicle->Unit = (int) $row['unit_id'];
				$vehicle->Company = (int) $row['company_id'];


				array_push($result, $vehicle);
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

			$sql = "SELECT * FROM vehicle WHERE id = :id;";
			$query = $connection->prepare($sql);
			$query->bindParam(':id',$id, PDO::PARAM_INT);

			$query->execute();

			if ($query->rowCount() < 1){
				Flight::notFound("id not found");
			}

			$row = $query->fetch(PDO::FETCH_ASSOC);

			$vehicle = new Vehicle();
			$vehicle->Id = (int) $row['id'];
			$vehicle->DtSubscribed = $row['vehicle_dt_subscribed'];
			$vehicle->Plate = $row['vehicle_plate'];
			$vehicle->MaInitial = (int)$row['vehicle_ma_initial'];
			$vehicle->MaLimit = (int)$row['vehicle_ma_limit'];
			$vehicle->MaMaintenance = (int)$row['vehicle_ma_maintenance'];
			$vehicle->SpeedMax = (int)$row['vehicle_speed_max'];
			$vehicle->Status = (int)$row['e_status_id'];
			$vehicle->Fuel = (int)$row['vehicle_fuel'];
			$vehicle->FuelMax = (int)$row['vehicle_fuel_max'];
			$vehicle->Model = (int) $row['vehicle_model_id'];
			$vehicle->Driver = (int) $row['driver_id'];
			$vehicle->Unit = (int) $row['unit_id'];
			$vehicle->Company = (int) $row['company_id'];


			Flight::ok($vehicle);

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

			$vehicle = json_decode(file_get_contents("php://input"));

			if ($vehicle == null) {
				throw new Exception(json_get_error());
			}

			
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
			vehicle_fuel_max, 
			vehicle_model_id, 
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
			:vehicle_fuel_max, 
			:vehicle_model_id, 
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
			$query->bindParam(':vehicle_fuel_max', $vehicle->FuelMax, PDO::PARAM_INT);
			$query->bindParam(':vehicle_model_id', $vehicle->Model, PDO::PARAM_INT);
			$query->bindParam(':driver_id', $vehicle->Driver, PDO::PARAM_INT);
			$query->bindParam(':unit_id', $vehicle->Unit, PDO::PARAM_INT);
			$query->bindParam(':company_id', $vehicle->Company, PDO::PARAM_INT);

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

			$vehicle = json_decode(file_get_contents("php://input"));

			if ($vehicle == null) {
				throw new Exception(json_get_error());
			}

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
			vehicle_fuel_max = :vehicle_fuel_max,
			vehicle_model_id = :vehicle_model_id,
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
			$query->bindParam(':vehicle_fuel_max', $vehicle->FuelMax, PDO::PARAM_INT);
			$query->bindParam(':vehicle_model_id', $vehicle->Model, PDO::PARAM_INT);
			$query->bindParam(':driver_id', $vehicle->Driver, PDO::PARAM_INT);
			$query->bindParam(':unit_id', $vehicle->Unit, PDO::PARAM_INT);
			$query->bindParam(':company_id', $vehicle->Company, PDO::PARAM_INT);

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
			DELETE FROM vehicle 
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