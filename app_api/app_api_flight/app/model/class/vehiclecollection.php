<?php 
/*
	Created by 		:		Rhalf Wendel D Caacbay
	Created on 		:		20170430

	Modified by 	:		#
	Modified on 	:		#

	functions 		:		Defines the class vehicleCollection and supplies the requests such as select, insert, update & delete.
*/
class VehicleCollection implements IQuery {

	public $id;
	public $vehicleId;
	public $collectionId;


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
				$vehicleCollection->id = (int) $row['id'];
				$vehicleCollection->vehicleId =  (int)$row['vehicle_id'];
				$vehicleCollection->collectionId =  (int)$row['collection_id'];

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
			$vehicleCollection->id = (int) $row['id'];
			$vehicleCollection->vehicleId = (int)$row['vehicle_id'];
			$vehicleCollection->collectionId = (int)$row['collection_id'];

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
				$vehicleCollection->id = (int) $row['id'];
				$vehicleCollection->vehicleId =  (int)$row['vehicle_id'];
				$vehicleCollection->collectionId =  (int)$row['collection_id'];
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

			$query->bindParam(':vehicle_id', $vehicleCollection->vehicleId, PDO::PARAM_STR);
			$query->bindParam(':collection_id', $vehicleCollection->collectionId, PDO::PARAM_INT);


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

			$query->bindParam(':vehicle_id', $vehicleCollection->vehicleId, PDO::PARAM_STR);
			$query->bindParam(':collection_id', $vehicleCollection->collectionId, PDO::PARAM_INT);


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
			DELETE FROM vehicle_collection 
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

	public static function deleteBycollection($id) {

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