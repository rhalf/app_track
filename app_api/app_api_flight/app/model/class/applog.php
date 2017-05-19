<?php 
/*
	Created by 		:		Rhalf Wendel D Caacbay
	Created on 		:		20170430

	Modified by 	:		#
	Modified on 	:		#

	functions 		:		Defines the class appLog and supplies the requests such as select, insert, update & delete.
*/
class AppLog implements IQuery {

	public $id;
	public $type;
	public $name;
	public $desc;
	public $dtCreated;

	public function __construct() {
	}
	public static function selectAll() {
		
		$connection = Flight::dbMain();

		try {

			$sql = "SELECT * FROM app_log;";
			$query = $connection->prepare($sql);

			$query->execute();

			$rows = $query->fetchAll(PDO::FETCH_ASSOC);

			$result = array();

			foreach ($rows as $row) {	
				$appLog = new AppLog();
				$appLog->id = (int) $row['id'];
				$appLog->type = (int) $row['log_type'];
				$appLog->name =$row['log_name'];
				$appLog->desc = $row['log_desc'];
				$appLog->dtCreated = $row['log_dt_created'];

				array_push($result, $appLog);
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

			$sql = "SELECT * FROM app_log WHERE id = :id;";
			$query = $connection->prepare($sql);
			$query->bindParam(':id',$id, PDO::PARAM_INT);

			$query->execute();

			if ($query->rowCount() < 1){
				return null;
			}

			$row = $query->fetch(PDO::FETCH_ASSOC);
			
			$appLog = new AppLog();
			$appLog->id = (int) $row['id'];
			$appLog->type = (int) $row['log_type'];
			$appLog->name =$row['log_name'];
			$appLog->desc = $row['log_desc'];
			$appLog->dtCreated = $row['log_dt_created'];


			return $appLog;

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

			$appLog = json_decode(file_get_contents("php://input"));

			if ($appLog == null) {
				throw new Exception(json_get_error());
			}


			$sql = "
			INSERT INTO app_log 
			(log_type, log_name,log_desc, log_dt_created)
			VALUES
			(:log_type, :log_name, :log_desc, :log_dt_created);";

			$query = $connection->prepare($sql);
			$query->bindParam(':log_type', $appLog->type, PDO::PARAM_INT);
			$query->bindParam(':log_name', $appLog->name, PDO::PARAM_STR);
			$query->bindParam(':log_desc', $appLog->desc, PDO::PARAM_STR);
			$query->bindParam(':log_dt_created', $appLog->dtCreated, PDO::PARAM_STR);


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

			$appLog = json_decode(file_get_contents("php://input"));

			if ($appLog == null) {
				throw new Exception(json_get_error());
			}

			$sql = "
			UPDATE app_log 
			SET 
			log_type = :log_type,
			log_name = :log_name,
			log_desc = :log_desc,
			log_dt_created = :log_dt_created

			WHERE
			id = :id;";

			
			$query = $connection->prepare($sql);

			$query->bindParam(':log_type', $appLog->type, PDO::PARAM_INT);
			$query->bindParam(':log_name', $appLog->name, PDO::PARAM_STR);
			$query->bindParam(':log_desc', $appLog->desc, PDO::PARAM_STR);
			$query->bindParam(':log_dt_created', $appLog->dtCreated, PDO::PARAM_STR);
			
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
			DELETE FROM app_log 
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