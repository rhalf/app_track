<?php 
/*
	Created by 		:		Rhalf Wendel D Caacbay
	Created on 		:		20170430

	Modified by 	:		#
	Modified on 	:		#

	functions 		:		Defines the class driver and supplies the requests such as select, insert, update & delete.
*/
class Driver implements IQuery {

	public $id;
	public $driverId;
	public $name;
	public $nameFirst;
	public $nameMiddle;
	public $nameLast;
	public $dtCreated;
	public $rfid;
	public $company;
	public $status;


	public function __construct() {
	}

	public static function selectAll() {

		$connection = Flight::dbMain();
		
		try {

			$sql = "SELECT * FROM driver;";
			$query = $connection->prepare($sql);
			
			$query->execute();

			$rows = $query->fetchAll(PDO::FETCH_ASSOC);

			$result = array();

			foreach ($rows as $row) {	
				$driver = new Driver();
				$driver->id = (int) $row['id'];
				$driver->driverId = $row['driver_id'];
				$driver->name = $row['driver_name'];
				$driver->nameFirst = $row['driver_name_f'];
				$driver->nameMiddle = $row['driver_name_m'];
				$driver->nameLast = $row['driver_name_l'];
				$driver->rfid = $row['driver_rfid'];
				$driver->dtCreated = $row['driver_dt_created'];
				
				$driver->status = Status::select($row['e_status_id']);
				$driver->company = Company::select($row['company_id']);

				array_push($result, $driver);
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

			$sql = "SELECT * FROM driver WHERE id = :id;";
			$query = $connection->prepare($sql);
			$query->bindParam(':id',$id, PDO::PARAM_INT);

			$query->execute();

			if ($query->rowCount() < 1){
				return null;
			}

			$row = $query->fetch(PDO::FETCH_ASSOC);

			$driver = new Driver();
			$driver->id = (int) $row['id'];
			$driver->driverId = $row['driver_id'];
			$driver->name = $row['driver_name'];
			$driver->nameFirst = $row['driver_name_f'];
			$driver->nameMiddle = $row['driver_name_m'];
			$driver->nameLast = $row['driver_name_l'];
			$driver->rfid = $row['driver_rfid'];
			$driver->dtCreated = $row['driver_dt_created'];

			$driver->status = Status::select($row['e_status_id']);
			$driver->company = Company::select($row['company_id']);

			return $driver;

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

			$sql = "SELECT * FROM driver WHERE company_id = :company;";
			$query = $connection->prepare($sql);
			$query->bindParam(':company',$id, PDO::PARAM_INT);

			$query->execute();

			$rows = $query->fetchAll(PDO::FETCH_ASSOC);

			$result = array();

			foreach ($rows as $row) {	
				$driver = new Driver();
				$driver->id = (int) $row['id'];
				$driver->driverId = $row['driver_id'];
				$driver->name = $row['driver_name'];
				$driver->nameFirst = $row['driver_name_f'];
				$driver->nameMiddle = $row['driver_name_m'];
				$driver->nameLast = $row['driver_name_l'];
				$driver->rfid = $row['driver_rfid'];
				$driver->dtCreated = $row['driver_dt_created'];
				$driver->status = Status::select($row['e_status_id']);
				$driver->company = Company::select($row['company_id']);
				array_push($result, $driver);
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

			$driver = json_decode(file_get_contents("php://input"));

			if ($driver == null) {
				throw new Exception(json_get_error());
			}

			$sql = "
			INSERT INTO driver 
			(driver_id, driver_name, driver_name_f, driver_name_m, driver_name_l, driver_rfid, e_status_id, company_id, driver_dt_created)
			VALUES
			(:driver_id, :driver_name, :driver_name_f, :driver_name_m, :driver_name_l, :driver_rfid, :e_status_id, :company_id, :driver_dt_created);";


			$query = $connection->prepare($sql);

			$query->bindParam(':driver_id', $driver->driverId, PDO::PARAM_STR);
			$query->bindParam(':driver_name', $driver->name, PDO::PARAM_STR);
			$query->bindParam(':driver_name_f', $driver->nameFirst, PDO::PARAM_STR);
			$query->bindParam(':driver_name_m', $driver->nameMiddle, PDO::PARAM_STR);
			$query->bindParam(':driver_name_l', $driver->nameLast, PDO::PARAM_STR);
			$query->bindParam(':driver_rfid', $driver->rfid, PDO::PARAM_STR);
			$query->bindParam(':e_status_id', $driver->status->id, PDO::PARAM_INT);
			$query->bindParam(':company_id', $driver->company->id, PDO::PARAM_INT);
			$query->bindParam(':driver_dt_created', $dateTime, PDO::PARAM_STR);

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

			$driver = json_decode(file_get_contents("php://input"));

			if ($driver == null) {
				throw new Exception(json_get_error());
			}

			$sql = "
			UPDATE driver 
			SET
			driver_id = :driver_id,
			driver_name = :driver_name,
			driver_name_f = :driver_name_f,
			driver_name_m = :driver_name_m,
			driver_name_l = :driver_name_l,
			driver_rfid = :driver_rfid,
			e_status_id = :e_status_id,
			company_id = :company_id

			WHERE
			id = :id;";


			$query = $connection->prepare($sql);

			$query->bindParam(':driver_id', $driver->driverId, PDO::PARAM_STR);
			$query->bindParam(':driver_name', $driver->name, PDO::PARAM_STR);
			$query->bindParam(':driver_name_f', $driver->nameFirst, PDO::PARAM_STR);
			$query->bindParam(':driver_name_m', $driver->nameMiddle, PDO::PARAM_STR);
			$query->bindParam(':driver_name_l', $driver->nameLast, PDO::PARAM_STR);
			$query->bindParam(':driver_rfid', $driver->rfid, PDO::PARAM_STR);
			$query->bindParam(':e_status_id', $driver->status->id, PDO::PARAM_INT);
			$query->bindParam(':company_id', $driver->company->id, PDO::PARAM_INT);

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
			DELETE FROM driver 
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