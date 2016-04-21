<?php 

class AppLog implements IQuery {

	public $Id;
	public $Type;
	public $Name;
	public $Desc;
	public $DtCreated;

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
				$appLog->Id = (int) $row['id'];
				$appLog->Type = (int) $row['log_type'];
				$appLog->Name =$row['log_name'];
				$appLog->Desc = $row['log_desc'];
				$appLog->DtCreated = $row['log_dt_created'];

				array_push($result, $appLog);
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

			$sql = "SELECT * FROM app_log WHERE id = :id;";
			$query = $connection->prepare($sql);
			$query->bindParam(':id',$id, PDO::PARAM_INT);

			$query->execute();

			if ($query->rowCount() < 1){
				Flight::notFound("id not found");
			}

			$row = $query->fetch(PDO::FETCH_ASSOC);
			
			$appLog = new AppLog();
			$appLog->Id = (int) $row['id'];
			$appLog->Type = (int) $row['log_type'];
			$appLog->Name =$row['log_name'];
			$appLog->Desc = $row['log_desc'];
			$appLog->DtCreated = $row['log_dt_created'];


			Flight::ok($appLog);

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
			$query->bindParam(':log_type', $appLog->Type, PDO::PARAM_INT);
			$query->bindParam(':log_name', $appLog->Name, PDO::PARAM_STR);
			$query->bindParam(':log_desc', $appLog->Desc, PDO::PARAM_STR);
			$query->bindParam(':log_dt_created', $appLog->DtCreated, PDO::PARAM_STR);


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

			$query->bindParam(':log_type', $appLog->Type, PDO::PARAM_INT);
			$query->bindParam(':log_name', $appLog->Name, PDO::PARAM_STR);
			$query->bindParam(':log_desc', $appLog->Desc, PDO::PARAM_STR);
			$query->bindParam(':log_dt_created', $appLog->DtCreated, PDO::PARAM_STR);
			
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
			DELETE FROM app_log 
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