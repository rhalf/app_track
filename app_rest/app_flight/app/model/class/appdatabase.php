<?php 

class AppDatabase implements IQuery {

	public $Id;
	public $Name;
	public $Status;
	public $Type;
	

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
				$appDatabase->Id = (int) $row['id'];
				$appDatabase->Name = $row['db_name'];
				$appDatabase->Type = (int) $row['db_type'];
				$appDatabase->Status = (int) $row['e_status_id'];
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
			$appDatabase->Id = (int) $row['id'];
			$appDatabase->Name = $row['db_name'];
			$appDatabase->Type = $row['db_type'];
			$appDatabase->Status = (int) $row['e_status_id'];

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

			$query->bindParam(':db_name', $appDatabase->Name, PDO::PARAM_STR);
			$query->bindParam(':db_type', $appDatabase->Type, PDO::PARAM_INT);
			$query->bindParam(':e_status_id', $appDatabase->Status, PDO::PARAM_INT);


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

			$query->bindParam(':db_name', $appDatabase->Name, PDO::PARAM_STR);
			$query->bindParam(':db_type', $appDatabase->Type, PDO::PARAM_INT);
			$query->bindParam(':e_status_id', $appDatabase->Status, PDO::PARAM_INT);
			
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
			DELETE FROM app_database 
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