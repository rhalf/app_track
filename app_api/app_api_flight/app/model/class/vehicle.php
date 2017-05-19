<?php 
/*
	Created by 		:		Rhalf Wendel D Caacbay
	Created on 		:		20170430

	Modified by 	:		#
	Modified on 	:		#

	functions 		:		Defines the class vehicle and supplies the requests such as select, insert, update & delete.
*/
class Vehicle implements IQuery {

	public $id;
	public $dtCreated;
	public $dtExpired;
	public $name;
	public $plate;
	public $maInitial;
	public $maLimit;
	public $maMaintenance;
	public $speedMax;
	public $status;
	public $fuelMax;
	public $driver;
	public $unit;
	public $company;
	public $type;


	
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
				$vehicle->id = (int) $row['id'];
				$vehicle->dtCreated = $row['vehicle_dt_created'];
				$vehicle->dtExpired = $row['vehicle_dt_expired'];
				$vehicle->plate = $row['vehicle_plate'];
				$vehicle->name = $row['vehicle_name'];
				$vehicle->model = $row['vehicle_model'];

				$vehicle->maInitial = (int)$row['vehicle_ma_initial'];
				$vehicle->maLimit = (int)$row['vehicle_ma_limit'];
				$vehicle->maMaintenance = (int)$row['vehicle_ma_maintenance'];
				$vehicle->speedMax = (int)$row['vehicle_speed_max'];
				$vehicle->fuelMax = (int)$row['vehicle_fuel_max'];
				// $vehicle->driver =  $row['driver_id'] == null ? null : (int)$row['driver_id'];
				// $vehicle->unit = $row['unit_id'] == null ? null : (int)$row['unit_id'];
				// $vehicle->company = (int) $row['company_id'];
				// $vehicle->type = (int) $row['e_type_id'];
				// $vehicle->status = (int)$row['e_status_id'];

				$vehicle->driver =  Driver::select($row['driver_id']);
				$vehicle->unit = Unit::select($row['unit_id']);
				$vehicle->company = Company::select($row['company_id']);
				$vehicle->type =Type::select($row['e_type_id']);
				$vehicle->status = Status::select($row['e_status_id']);

				array_push($result, $vehicle);
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

			$sql = "SELECT * FROM vehicle WHERE id = :id;";
			$query = $connection->prepare($sql);
			$query->bindParam(':id',$id, PDO::PARAM_INT);

			$query->execute();

			if ($query->rowCount() < 1){
				return null;
			}

			$row = $query->fetch(PDO::FETCH_ASSOC);

			$vehicle = new Vehicle();
			$vehicle->id = (int) $row['id'];
			$vehicle->dtCreated = $row['vehicle_dt_created'];
			$vehicle->dtExpired = $row['vehicle_dt_expired'];
			$vehicle->plate = $row['vehicle_plate'];
			$vehicle->name = $row['vehicle_name'];
			$vehicle->model = $row['vehicle_model'];

			$vehicle->maInitial = (int)$row['vehicle_ma_initial'];
			$vehicle->maLimit = (int)$row['vehicle_ma_limit'];
			$vehicle->maMaintenance = (int)$row['vehicle_ma_maintenance'];
			$vehicle->speedMax = (int)$row['vehicle_speed_max'];
			$vehicle->fuelMax = (int)$row['vehicle_fuel_max'];
			// $vehicle->status = (int)$row['e_status_id'];
			// $vehicle->driver =  $row['driver_id'] == null ? null : (int)$row['driver_id'];
			// $vehicle->unit = $row['unit_id'] == null ? null : (int)$row['unit_id'];
			// $vehicle->company = (int) $row['company_id'];
			// $vehicle->type = (int) $row['e_type_id'];
			$vehicle->status = (int)$row['e_status_id'];
			$vehicle->driver =  Driver::select($row['driver_id']);
			$vehicle->unit = Unit::select($row['unit_id']);
			$vehicle->company = Company::select($row['company_id']);
			$vehicle->type = Type::select($row['e_type_id']);
			$vehicle->status = Status::select($row['e_status_id']);


			return $vehicle;

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

			$sql = "SELECT * FROM vehicle WHERE company_id = :company;";
			$query = $connection->prepare($sql);
			$query->bindParam(':company',$id, PDO::PARAM_INT);

			$query->execute();

			$rows = $query->fetchAll(PDO::FETCH_ASSOC);

			$result = array();

			foreach ($rows as $row) {	
				$vehicle = new Vehicle();
				$vehicle->id = (int) $row['id'];
				$vehicle->dtCreated = $row['vehicle_dt_created'];
				$vehicle->dtExpired = $row['vehicle_dt_expired'];
				$vehicle->plate = $row['vehicle_plate'];
				$vehicle->name = $row['vehicle_name'];
				$vehicle->model = $row['vehicle_model'];

				$vehicle->maInitial = (int)$row['vehicle_ma_initial'];
				$vehicle->maLimit = (int)$row['vehicle_ma_limit'];
				$vehicle->maMaintenance = (int)$row['vehicle_ma_maintenance'];
				$vehicle->speedMax = (int)$row['vehicle_speed_max'];
				$vehicle->fuelMax = (int)$row['vehicle_fuel_max'];
				// $vehicle->status = (int)$row['e_status_id'];
				// $vehicle->driver =  $row['driver_id'] == null ? null : (int)$row['driver_id'];
				// $vehicle->unit = $row['unit_id'] == null ? null : (int)$row['unit_id'];
				// $vehicle->company = (int) $row['company_id'];
				// $vehicle->type = (int) $row['e_type_id'];
				$vehicle->status = (int)$row['e_status_id'];
				$vehicle->driver =  Driver::select($row['driver_id']);
				$vehicle->unit = Unit::select($row['unit_id']);
				$vehicle->company = Company::select($row['company_id']);
				$vehicle->type =Type::select($row['e_type_id']);
				$vehicle->status = Status::select($row['e_status_id']);

				array_push($result, $vehicle);
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
			vehicle_dt_expired, 
			vehicle_plate, 
			vehicle_ma_initial, 
			vehicle_ma_limit, 
			vehicle_ma_maintenance, 
			vehicle_speed_max, 
			e_status_id, 
			vehicle_name, 
			vehicle_model,
			vehicle_fuel_max, 
			driver_id,
			unit_id, 
			company_id,
			e_type_id
			)
			
			VALUES
			(
			:vehicle_dt_created,
			:vehicle_dt_expired, 
			:vehicle_plate, 
			:vehicle_ma_initial, 
			:vehicle_ma_limit, 
			:vehicle_ma_maintenance, 
			:vehicle_speed_max, 
			:e_status_id, 
			:vehicle_name, 
			:vehicle_model,
			:vehicle_fuel_max, 
			:driver_id,
			:unit_id, 
			:company_id,
			:e_type_id
			);";


			$query = $connection->prepare($sql);

			$query->bindParam(':vehicle_dt_created', $dateTime, PDO::PARAM_STR);
			$query->bindParam(':vehicle_dt_expired', $vehicle->dtExpired, PDO::PARAM_STR);

			$query->bindParam(':vehicle_plate', $vehicle->plate, PDO::PARAM_STR);
			$query->bindParam(':vehicle_ma_initial', $vehicle->maInitial, PDO::PARAM_INT);
			$query->bindParam(':vehicle_ma_limit', $vehicle->maLimit, PDO::PARAM_INT);
			$query->bindParam(':vehicle_ma_maintenance', $vehicle->maMaintenance, PDO::PARAM_INT);
			$query->bindParam(':vehicle_speed_max', $vehicle->speedMax, PDO::PARAM_INT);
			$query->bindParam(':e_status_id', $vehicle->status->id, PDO::PARAM_INT);
			$query->bindParam(':vehicle_name', $vehicle->name, PDO::PARAM_STR);
			$query->bindParam(':vehicle_model', $vehicle->model, PDO::PARAM_STR);

			$query->bindParam(':vehicle_fuel_max', $vehicle->fuelMax, PDO::PARAM_INT);
			$query->bindParam(':driver_id', $vehicle->driver->id, PDO::PARAM_INT);
			$query->bindParam(':unit_id', $vehicle->unit->id, PDO::PARAM_INT);
			$query->bindParam(':company_id', $vehicle->company->id, PDO::PARAM_INT);
			$query->bindParam(':e_type_id', $vehicle->type->id, PDO::PARAM_INT);


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

			$vehicle = json_decode(file_get_contents("php://input"));

			if ($vehicle == null) {
				throw new Exception(json_get_error());
			}

			$sql = "
			UPDATE vehicle 
			SET 
			vehicle_dt_expired = :vehicle_dt_expired,
			vehicle_plate = :vehicle_plate, 
			vehicle_ma_initial = :vehicle_ma_initial,
			vehicle_ma_limit = :vehicle_ma_limit,
			vehicle_ma_maintenance = :vehicle_ma_maintenance,
			vehicle_speed_max = :vehicle_speed_max,
			e_status_id = :e_status_id,
			vehicle_name = :vehicle_name,
			vehicle_model = :vehicle_model,

			vehicle_fuel_max = :vehicle_fuel_max,
			driver_id = :driver_id,
			unit_id = :unit_id,
			company_id = :company_id,
			e_type_id = :e_type_id

			WHERE
			id = :id;";

			$query = $connection->prepare($sql);


			$query->bindParam(':vehicle_dt_expired', $vehicle->dtExpired, PDO::PARAM_STR);

			$query->bindParam(':vehicle_plate', $vehicle->plate, PDO::PARAM_STR);
			$query->bindParam(':vehicle_ma_initial', $vehicle->maInitial, PDO::PARAM_INT);
			$query->bindParam(':vehicle_ma_limit', $vehicle->maLimit, PDO::PARAM_INT);
			$query->bindParam(':vehicle_ma_maintenance', $vehicle->maMaintenance, PDO::PARAM_INT);
			$query->bindParam(':vehicle_speed_max', $vehicle->speedMax, PDO::PARAM_INT);
			$query->bindParam(':e_status_id', $vehicle->status->id, PDO::PARAM_INT);
			$query->bindParam(':vehicle_name', $vehicle->name, PDO::PARAM_STR);
			$query->bindParam(':vehicle_model', $vehicle->model, PDO::PARAM_STR);

			$query->bindParam(':vehicle_fuel_max', $vehicle->fuelMax, PDO::PARAM_INT);
			$query->bindParam(':driver_id', $vehicle->driver->id, PDO::PARAM_INT);
			$query->bindParam(':unit_id', $vehicle->unit->id, PDO::PARAM_INT);
			$query->bindParam(':company_id', $vehicle->company->id, PDO::PARAM_INT);
			$query->bindParam(':e_type_id', $vehicle->type->id, PDO::PARAM_INT);



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
			DELETE FROM vehicle 
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
}

?>