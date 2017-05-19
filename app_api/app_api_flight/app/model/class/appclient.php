<?php 
/*
	Created by 		:		Rhalf Wendel D Caacbay
	Created on 		:		20170430

	Modified by 	:		#
	Modified on 	:		#

	functions 		:		Defines the class appClient and supplies the requests such as select, insert, update & delete.
*/
class AppClient implements IQuery {

	public $id;
	public $platform;
	public $type;
	public $key;
	public $status;
	public $dtCreated;

	

	public function __construct() {
	}

	public static function selectAll() {
		
		$connection = Flight::dbMain();

		try {
			$sql = "SELECT * FROM app_client;";
			$query = $connection->prepare($sql);
			
			$query->execute();

			$rows = $query->fetchAll(PDO::FETCH_ASSOC);

			$result = array();

			foreach ($rows as $row) {	
				$appClient = new AppClient();
				$appClient->id = (int) $row['id'];
				$appClient->platform = $row['client_platform'];
				$appClient->key =  $row['client_key'];
				$appClient->type = (int)$row['client_type'];
				$appClient->status = (int)$row['e_status_id'];
				$appClient->dtCreated = $row['client_dt_created'];

				array_push($result, $appClient);
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
			$sql = "SELECT * FROM app_client WHERE id = :id;";
			$query = $connection->prepare($sql);
			$query->bindParam(':id',$id, PDO::PARAM_INT);
			
			$query->execute();

			if ($query->rowCount() < 1){
				return null;
			}

			$row = $query->fetch(PDO::FETCH_ASSOC);

			$appClient = new AppClient();
			$appClient->id = (int) $row['id'];
			$appClient->platform = $row['client_platform'];
			$appClient->key =  $row['client_key'];
			$appClient->type = (int)$row['client_type'];
			$appClient->status = (int)$row['e_status_id'];
			$appClient->dtCreated = $row['client_dt_created'];


			return $appClient;

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

			$appClient = json_decode(file_get_contents("php://input"));

			if ($appClient == null) {
				throw new Exception(json_get_error());
			}

			$sql = "
			INSERT INTO app_client 
			(client_platform, client_key, client_type, e_status_id, client_dt_created)
			VALUES
			(:client_platform, :client_key, :client_type, :e_status_id, :client_dt_created);";

			$query = $connection->prepare($sql);

			$query->bindParam(':client_platform', $appClient->platform, PDO::PARAM_STR);
			$query->bindParam(':client_key', $appClient->key, PDO::PARAM_STR);
			$query->bindParam(':client_type', $appClient->type, PDO::PARAM_INT);
			$query->bindParam(':e_status_id', $appClient->status, PDO::PARAM_INT);
			$query->bindParam(':client_dt_created', $appClient->dtCreated, PDO::PARAM_STR);

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

			$appClient = json_decode(file_get_contents("php://input"));

			if ($appClient == null) {
				throw new Exception(json_get_error());
			}

			$sql = "
			UPDATE app_client 
			SET 
			client_platform = :client_platform,
			client_key = :client_key,
			client_type = :client_type,
			e_status_id = :e_status_id,
			client_dt_created = :client_dt_created
			WHERE
			id = :id;";

			
			$query = $connection->prepare($sql);

			$query->bindParam(':client_platform', $appClient->platform, PDO::PARAM_STR);
			$query->bindParam(':client_key', $appClient->key, PDO::PARAM_STR);
			$query->bindParam(':client_type', $appClient->type, PDO::PARAM_INT);
			$query->bindParam(':e_status_id', $appClient->status, PDO::PARAM_INT);
			$query->bindParam(':client_dt_created', $appClient->dtCreated, PDO::PARAM_STR);


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
			DELETE FROM app_client 
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