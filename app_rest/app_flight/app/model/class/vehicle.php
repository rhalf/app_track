<?php 

class Vehicle implements IQuery {

	public $Id;
	public $DtCreated;
	public $DtSubscribed;
	public $Name;
	public $Plate;
	public $MaInitial;
	public $MaLimit;
	public $MaMaintenance;
	public $SpeedMax;
	public $Status;
	public $FuelMax;
	public $Driver;
	public $Unit;
	public $Company;
	public $TrackeeType;


	
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
				$vehicle->DtCreated = $row['vehicle_dt_created'];
				$vehicle->DtSubscribed = $row['vehicle_dt_subscribed'];
				$vehicle->Plate = $row['vehicle_plate'];
				$vehicle->Name = $row['vehicle_name'];
				$vehicle->Model = $row['vehicle_model'];

				$vehicle->MaInitial = (int)$row['vehicle_ma_initial'];
				$vehicle->MaLimit = (int)$row['vehicle_ma_limit'];
				$vehicle->MaMaintenance = (int)$row['vehicle_ma_maintenance'];
				$vehicle->SpeedMax = (int)$row['vehicle_speed_max'];
				$vehicle->Status = (int)$row['e_status_value'];
				$vehicle->FuelMax = (int)$row['vehicle_fuel_max'];
				$vehicle->Driver =  $row['driver_id'] == null ? null : (int)$row['driver_id'];
				$vehicle->Unit = $row['unit_id'] == null ? null : (int)$row['unit_id'];
				$vehicle->Company = (int) $row['company_id'];
				$vehicle->TrackeeType = (int) $row['e_trackee_type_id'];


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
			$vehicle->DtCreated = $row['vehicle_dt_created'];
			$vehicle->DtSubscribed = $row['vehicle_dt_subscribed'];
			$vehicle->Plate = $row['vehicle_plate'];
			$vehicle->Name = $row['vehicle_name'];
			$vehicle->Model = $row['vehicle_model'];

			$vehicle->MaInitial = (int)$row['vehicle_ma_initial'];
			$vehicle->MaLimit = (int)$row['vehicle_ma_limit'];
			$vehicle->MaMaintenance = (int)$row['vehicle_ma_maintenance'];
			$vehicle->SpeedMax = (int)$row['vehicle_speed_max'];
			$vehicle->Status = (int)$row['e_status_value'];
			$vehicle->FuelMax = (int)$row['vehicle_fuel_max'];
			$vehicle->Driver =  $row['driver_id'] == null ? null : (int)$row['driver_id'];
			$vehicle->Unit = $row['unit_id'] == null ? null : (int)$row['unit_id'];
			$vehicle->Company = (int) $row['company_id'];
			$vehicle->TrackeeType = (int) $row['e_trackee_type_id'];

			Flight::ok($vehicle);

		} catch (PDOException $pdoException) {
			Flight::error($pdoException);
		} catch (Exception $exception) {
			Flight::error($exception);
		} finally {
			$connection = null;
		}
	}

	public static function selectByCompany($id) {
		
		$connection = Flight::dbMain();

		try {

			$sql = "SELECT * FROM vehicle WHERE company_id = :company;";
			$query = $connection->prepare($sql);
			$query->bindParam(':company',$id, PDO::PARAM_INT);

			$query->execute();

			$rows = $query->fetchAll(PDO::FETCH_ASSOC);

			$result = array();

			foreach ($rows as $row) {	
				$vehicle = new Vehicle();
				$vehicle->Id = (int) $row['id'];
				$vehicle->DtCreated = $row['vehicle_dt_created'];
				$vehicle->DtSubscribed = $row['vehicle_dt_subscribed'];
				$vehicle->Plate = $row['vehicle_plate'];
				$vehicle->Name = $row['vehicle_name'];
				$vehicle->Model = $row['vehicle_model'];

				$vehicle->MaInitial = (int)$row['vehicle_ma_initial'];
				$vehicle->MaLimit = (int)$row['vehicle_ma_limit'];
				$vehicle->MaMaintenance = (int)$row['vehicle_ma_maintenance'];
				$vehicle->SpeedMax = (int)$row['vehicle_speed_max'];
				$vehicle->Status = (int)$row['e_status_value'];
				$vehicle->FuelMax = (int)$row['vehicle_fuel_max'];
				$vehicle->Driver =  $row['driver_id'] == null ? null : (int)$row['driver_id'];
				$vehicle->Unit = $row['unit_id'] == null ? null : (int)$row['unit_id'];
				$vehicle->Company = (int) $row['company_id'];
				$vehicle->TrackeeType = (int) $row['e_trackee_type_id'];


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


	public static function insert() {

		$connection = Flight::dbMain();
		$dateTime = Flight::dateTime();

		try {

			$vehicle = json_decode(file_get_contents("php://input"));

			if ($vehicle == null) {
				throw new Exception(json_get_error());
			}

			
			$sql = "
			INSERT INTO vehicle 
			(
			vehicle_dt_created,
			vehicle_dt_subscribed, 
			vehicle_plate, 
			vehicle_ma_initial, 
			vehicle_ma_limit, 
			vehicle_ma_maintenance, 
			vehicle_speed_max, 
			e_status_value, 
			vehicle_name, 
			vehicle_model,
			vehicle_fuel_max, 
			driver_id,
			unit_id, 
			company_id,
			e_trackee_type_id
			)
			
			VALUES
			(
			:vehicle_dt_created,
			:vehicle_dt_subscribed, 
			:vehicle_plate, 
			:vehicle_ma_initial, 
			:vehicle_ma_limit, 
			:vehicle_ma_maintenance, 
			:vehicle_speed_max, 
			:e_status_value, 
			:vehicle_name, 
			:vehicle_model,
			:vehicle_fuel_max, 
			:driver_id,
			:unit_id, 
			:company_id,
			:e_trackee_type_id
			);";


			$query = $connection->prepare($sql);

			$query->bindParam(':vehicle_dt_created', $dateTime, PDO::PARAM_STR);
			$query->bindParam(':vehicle_dt_subscribed', $vehicle->DtSubscribed, PDO::PARAM_STR);

			$query->bindParam(':vehicle_plate', $vehicle->Plate, PDO::PARAM_STR);
			$query->bindParam(':vehicle_ma_initial', $vehicle->MaInitial, PDO::PARAM_INT);
			$query->bindParam(':vehicle_ma_limit', $vehicle->MaLimit, PDO::PARAM_INT);
			$query->bindParam(':vehicle_ma_maintenance', $vehicle->MaMaintenance, PDO::PARAM_INT);
			$query->bindParam(':vehicle_speed_max', $vehicle->SpeedMax, PDO::PARAM_INT);
			$query->bindParam(':e_status_value', $vehicle->Status, PDO::PARAM_INT);
			$query->bindParam(':vehicle_name', $vehicle->Name, PDO::PARAM_STR);
			$query->bindParam(':vehicle_model', $vehicle->Model, PDO::PARAM_STR);

			$query->bindParam(':vehicle_fuel_max', $vehicle->FuelMax, PDO::PARAM_INT);
			$query->bindParam(':driver_id', $vehicle->Driver, PDO::PARAM_INT);
			$query->bindParam(':unit_id', $vehicle->Unit, PDO::PARAM_INT);
			$query->bindParam(':company_id', $vehicle->Company, PDO::PARAM_INT);
			$query->bindParam(':e_trackee_type_id', $vehicle->TrackeeType, PDO::PARAM_INT);


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
			e_status_value = :e_status_value,
			vehicle_name = :vehicle_name,
			vehicle_model = :vehicle_model,

			vehicle_fuel_max = :vehicle_fuel_max,
			driver_id = :driver_id,
			unit_id = :unit_id,
			company_id = :company_id,
			e_trackee_type_id = :e_trackee_type_id

			WHERE
			id = :id;";

			$query = $connection->prepare($sql);


			$query->bindParam(':vehicle_dt_subscribed', $vehicle->DtSubscribed, PDO::PARAM_STR);

			$query->bindParam(':vehicle_plate', $vehicle->Plate, PDO::PARAM_STR);
			$query->bindParam(':vehicle_ma_initial', $vehicle->MaInitial, PDO::PARAM_INT);
			$query->bindParam(':vehicle_ma_limit', $vehicle->MaLimit, PDO::PARAM_INT);
			$query->bindParam(':vehicle_ma_maintenance', $vehicle->MaMaintenance, PDO::PARAM_INT);
			$query->bindParam(':vehicle_speed_max', $vehicle->SpeedMax, PDO::PARAM_INT);
			$query->bindParam(':e_status_value', $vehicle->Status, PDO::PARAM_INT);
			$query->bindParam(':vehicle_name', $vehicle->Name, PDO::PARAM_STR);
			$query->bindParam(':vehicle_model', $vehicle->Model, PDO::PARAM_STR);

			$query->bindParam(':vehicle_fuel_max', $vehicle->FuelMax, PDO::PARAM_INT);
			$query->bindParam(':driver_id', $vehicle->Driver, PDO::PARAM_INT);
			$query->bindParam(':unit_id', $vehicle->Unit, PDO::PARAM_INT);
			$query->bindParam(':company_id', $vehicle->Company, PDO::PARAM_INT);
			$query->bindParam(':e_trackee_type_id', $vehicle->TrackeeType, PDO::PARAM_INT);



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