<?php 

class VehicleCollection implements IQuery {

	public $Id;
	public $Vehicle;
	public $Collection;


	public function __construct() {
	}

	public static function selectAll() {

		$connection = Flight::dbMain();

		try {

			$sql = "SELECT * FROM vehicle_collection;";
			$query = $connection->prepare($sql);
			$query->execute();

			$rows = $query->fetchAll(PDO::FETCH_ASSOC);

			$result = array();

			foreach ($rows as $row) {	
				$vehicleCollection = new VehicleCollection();
				$vehicleCollection->Id = (int) $row['id'];
				$vehicleCollection->Vehicle =  Vehicle::select($row['vehicle_id']);
				$vehicleCollection->Collection =  Collection::select($row['collection_id']);

				array_push($result, $vehicleCollection);
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

			$sql = "SELECT * FROM vehicle_collection WHERE id = :id;";
			$query = $connection->prepare($sql);
			$query->bindParam(':id',$id, PDO::PARAM_INT);

			$query->execute();

			if ($query->rowCount() < 1){
				return null;
			}

			$row = $query->fetch(PDO::FETCH_ASSOC);

			$vehicleCollection = new VehicleCollection();
			$vehicleCollection->Id = (int) $row['id'];
			$vehicleCollection->Vehicle =  Vehicle::select($row['vehicle_id']);
			$vehicleCollection->Collection =  Collection::select($row['collection_id']);

			return $vehicleCollection;

		} catch (PDOException $pdoException) {
			throw $pdoException;
		} catch (Exception $exception) {
			throw $exception;
		} finally {
			$connection = null;
		}
	}


	public static function selectByCollection($id) {

		$connection = Flight::dbMain();

		try {

			$sql = "SELECT * FROM vehicle_collection WHERE collection_id = :collection_id;";
			$query = $connection->prepare($sql);
			$query->bindParam(':collection_id',$id, PDO::PARAM_INT);

			$query->execute();

			$rows = $query->fetchAll(PDO::FETCH_ASSOC);

			$result = array();

			foreach ($rows as $row) {	
				$vehicleCollection = new VehicleCollection();
				$vehicleCollection->Id = (int) $row['id'];
				$vehicleCollection->Vehicle =  Vehicle::select($row['vehicle_id']);
				$vehicleCollection->Collection =  Collection::select($row['collection_id']);
				array_push($result, $vehicleCollection);
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

			$vehicleCollection = json_decode(file_get_contents("php://input"));

			if ($vehicleCollection == null) {
				throw new Exception(json_get_error());
			}

			$sql = "
			INSERT INTO vehicle_collection 
			(vehicle_id,  collection_id)
			VALUES
			(:vehicle_id, :collection_id);";

			$query = $connection->prepare($sql);

			$query->bindParam(':vehicle_id', $vehicleCollection->Vehicle->Id, PDO::PARAM_STR);
			$query->bindParam(':collection_id', $vehicleCollection->Collection->Id, PDO::PARAM_INT);


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

			$vehicleCollection = json_decode(file_get_contents("php://input"));

			if ($vehicleCollection == null) {
				throw new Exception(json_get_error());
			}

			
			$sql = "
			UPDATE vehicle_collection 
			SET 
			vehicle_id = :vehicle_id,
			collection_id = :collection_id
			
			WHERE
			id = :id;";
			

			$query = $connection->prepare($sql);

			$query->bindParam(':vehicle_id', $vehicleCollection->Vehicle->Id, PDO::PARAM_STR);
			$query->bindParam(':collection_id', $vehicleCollection->Collection->Id, PDO::PARAM_INT);

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
			DELETE FROM vehicle_collection 
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

	public static function deleteByCollection($id) {

		$connection = Flight::dbMain();

		try {

			$sql = "
			DELETE FROM vehicle_collection 
			WHERE
			collection_id = :collection_id";

			$query = $connection->prepare($sql);

			$query->bindParam(':collection_id', $id, PDO::PARAM_INT);

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