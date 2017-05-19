<?php 
/*
	Created by 		:		Rhalf Wendel D Caacbay
	Created on 		:		20170430

	Modified by 	:		#
	Modified on 	:		#

	functions 		:		Defines the class appDatabase and supplies the requests such as select, insert, update & delete.
*/
class AppDatabase implements IQuery {

	public $id;
	public $name;
	public $status;
	public $type;
	

	public function __construct() {
	}

	public static function selectAll() {
		
		$connection = Flight::dbMain();

		try {
			$sql = "SELECT * FROM app_database;";
			$query = $connection->prepare($sql);
			
			$query->execute();

			$rows = $query->fetchAll(PDO::FETCH_ASSOC);

			$result = array();

			foreach ($rows as $row) {	
				$appDatabase = new AppDatabase();
				$appDatabase->id = (int) $row['id'];
				$appDatabase->name = $row['db_name'];
				$appDatabase->type = (int) $row['db_type'];
				$appDatabase->status = (int) $row['e_status_id'];
				array_push($result, $appDatabase);
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
			$sql = "SELECT * FROM app_database WHERE id = :id;";
			$query = $connection->prepare($sql);
			$query->bindParam(':id',$id, PDO::PARAM_INT);
			
			$query->execute();

			if ($query->rowCount() < 1){
				return null;
			}

			$row = $query->fetch(PDO::FETCH_ASSOC);

			$appDatabase = new AppDatabase();
			$appDatabase->id = (int) $row['id'];
			$appDatabase->name = $row['db_name'];
			$appDatabase->type = $row['db_type'];
			$appDatabase->status = (int) $row['e_status_id'];

			return $appDatabase;

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

			$appDatabase = json_decode(file_get_contents("php://input"));

			if ($appDatabase == null) {
				throw new Exception(json_get_error());
			}


			$sql = "
			INSERT INTO app_database 
			(db_name, db_type, e_status_id)
			VALUES
			(:db_name, :db_type, :e_status_id);";

			$query = $connection->prepare($sql);

			$query->bindParam(':db_name', $appDatabase->name, PDO::PARAM_STR);
			$query->bindParam(':db_type', $appDatabase->type, PDO::PARAM_INT);
			$query->bindParam(':e_status_id', $appDatabase->status, PDO::PARAM_INT);


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

			$appDatabase = json_decode(file_get_contents("php://input"));

			if ($appDatabase == null) {
				throw new Exception(json_get_error());
			}

			$sql = "
			UPDATE app_database 
			SET 
			db_name = :db_name,
			db_type = :db_type,
			e_status_id = :e_status_id
			WHERE
			id = :id;";

			
			$query = $connection->prepare($sql);

			$query->bindParam(':db_name', $appDatabase->name, PDO::PARAM_STR);
			$query->bindParam(':db_type', $appDatabase->type, PDO::PARAM_INT);
			$query->bindParam(':e_status_id', $appDatabase->status, PDO::PARAM_INT);
			
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
			DELETE FROM app_database 
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