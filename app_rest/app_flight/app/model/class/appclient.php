<?php 

class AppClient implements IQuery {

	public $Id;
	public $Platform;
	public $Type;
	public $Key;
	public $Status;
	public $DtCreated;

	

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
				$appClient->Id = (int) $row['id'];
				$appClient->Platform = $row['client_platform'];
				$appClient->Key =  $row['client_key'];
				$appClient->Type = (int)$row['client_type'];
				$appClient->Status = (int)$row['e_status_id'];
				$appClient->DtCreated = $row['client_dt_created'];

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
			$appClient->Id = (int) $row['id'];
			$appClient->Platform = $row['client_platform'];
			$appClient->Key =  $row['client_key'];
			$appClient->Type = (int)$row['client_type'];
			$appClient->Status = (int)$row['e_status_id'];
			$appClient->DtCreated = $row['client_dt_created'];


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

			$query->bindParam(':client_platform', $appClient->Platform, PDO::PARAM_STR);
			$query->bindParam(':client_key', $appClient->Key, PDO::PARAM_STR);
			$query->bindParam(':client_type', $appClient->Type, PDO::PARAM_INT);
			$query->bindParam(':e_status_id', $appClient->Status, PDO::PARAM_INT);
			$query->bindParam(':client_dt_created', $appClient->DtCreated, PDO::PARAM_STR);

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

			$query->bindParam(':client_platform', $appClient->Platform, PDO::PARAM_STR);
			$query->bindParam(':client_key', $appClient->Key, PDO::PARAM_STR);
			$query->bindParam(':client_type', $appClient->Type, PDO::PARAM_INT);
			$query->bindParam(':e_status_id', $appClient->Status, PDO::PARAM_INT);
			$query->bindParam(':client_dt_created', $appClient->DtCreated, PDO::PARAM_STR);


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
			DELETE FROM app_client 
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
}

?>