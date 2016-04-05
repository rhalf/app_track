<?php 

class AppLog implements IQuery {

	public $Id;
	public $Type;
	public $Name;
	public $Desc;
	public $DtCreated;

	public function __construct() {
	}
	public static function onSelect(Url $url, $data) {
		$database = Flight::get('database');
		$connection = new PDO("mysql:host=$database->Ip;dbname=$database->Database", $database->Username, $database->Password);
		$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$connection->setAttribute(PDO::ATTR_EMULATE_PREPARES, true);

		try {

			if (!empty($url->Id)) {
				$sql = "SELECT * FROM app_log WHERE id = :id;";
				$query = $connection->prepare($sql);
				$query->bindParam(':id',$url->Id, PDO::PARAM_INT);
			} else if (isset($data['name'])) {
				$sql = "SELECT * FROM app_log WHERE log_name LIKE :log_name;";
				$query = $connection->prepare($sql);
				$query->bindParam(':log_name',$data['name'], PDO::PARAM_STR);
			} else {
				$sql = "SELECT * FROM app_log;";
				$query = $connection->prepare($sql);
			}
			$query->execute();
			$result = new Result();
			$result->Item = $query->rowCount();
			$result->Object = array();

			$rows = $query->fetchAll(PDO::FETCH_ASSOC);
			foreach ($rows as $row) {	
				$applog = new AppLog();
				$applog->Id = (int) $row['id'];
				$applog->Type = (int) $row['log_type'];
				$applog->Name =$row['log_name'];
				$applog->Desc = $row['log_desc'];
				$applog->DtCreated = $row['log_dt_created'];
				array_push($result->Object, $applog);
			}

			$result->Status = Result::SUCCESS;
			$result->Message = 'Done.';

		} catch (PDOException $pdoException) {
			$result = new Result();
			$result->Status = Result::ERROR;
			$result->Message = $pdoException->getMessage();
		} catch (Exception $exception) {
			$result = new Result();
			$result->Status = Result::ERROR;
			$result->Message = $exception->getMessage();
		}

		$connection = null;

		return $result;
	}
	public static function onInsert(Url $url, $data) {
		$database = Flight::get('database');
		$connection = new PDO("mysql:host=$database->Ip;dbname=$database->Database", $database->Username, $database->Password);
		$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$connection->setAttribute(PDO::ATTR_EMULATE_PREPARES, true);

		try {

			if (!isset($data['Object'])) {
				throw new Exception("Input object is not set.");
			}

			$applog = json_decode($data['Object']);
			if ($applog == null) {
				throw new Exception(json_get_error());
			}


			$sql = "
			INSERT INTO app_log 
			(log_type, log_name,log_desc, log_dt_created)
			VALUES
			(:log_type, :log_name, :log_desc, :log_dt_created);";

			$query = $connection->prepare($sql);
			$query->bindParam(':log_type', $applog->Type, PDO::PARAM_INT);
			$query->bindParam(':log_name', $applog->Name, PDO::PARAM_STR);
			$query->bindParam(':log_desc', $applog->Desc, PDO::PARAM_STR);
			$query->bindParam(':log_dt_created', $applog->DtCreated, PDO::PARAM_STR);



			$query->execute();

			$result = new Result();
			$result->Status = Result::SUCCESS;
			$result->Item = $query->rowCount();
			$result->Message = 'Done.';

		} catch (PDOException $pdoException) {
			$result = new Result();
			$result->Status = Result::ERROR;
			$result->Message = $pdoException->getMessage();
		} catch (Exception $exception) {
			$result = new Result();
			$result->Status = Result::ERROR;
			$result->Message = $exception->getMessage();
		}

		$connection = null;

		return $result;
	}
	public static function onUpdate(Url $url, $data) {
		$database = Flight::get('database');
		$connection = new PDO("mysql:host=$database->Ip;dbname=$database->Database", $database->Username, $database->Password);
		$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$connection->setAttribute(PDO::ATTR_EMULATE_PREPARES, true);

		try {
			if (empty($url->Id)) {
				throw new Exception("Input id is empty.");
			}

			if (!isset($data['Object'])) {
				throw new Exception("Input object is not set.");
			}

			$applog = json_decode($data['Object']);
			if ($applog == null) {
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

			$query->bindParam(':log_type', $applog->Type, PDO::PARAM_INT);
			$query->bindParam(':log_name', $applog->Name, PDO::PARAM_STR);
			$query->bindParam(':log_desc', $applog->Desc, PDO::PARAM_STR);
				$query->bindParam(':log_dt_created', $applog->DtCreated, PDO::PARAM_STR);
			$query->bindParam(':id', $url->Id, PDO::PARAM_INT);
		

			$query->execute();

			$result = new Result();
			$result->Status = Result::SUCCESS;
			$result->Item = $query->rowCount();
			$result->Message = 'Done.';

		} catch (PDOException $pdoException) {
			$result = new Result();
			$result->Status = Result::ERROR;
			$result->Message = $pdoException->getMessage();
		} catch (Exception $exception) {
			$result = new Result();
			$result->Status = Result::ERROR;
			$result->Message = $exception->getMessage();
		}

		$connection = null;
		return $result;
	}
	public static function onDelete(Url $url, $data) {
		$database = Flight::get('database');
		$connection = new PDO("mysql:host=$database->Ip;dbname=$database->Database", $database->Username, $database->Password);
		$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$connection->setAttribute(PDO::ATTR_EMULATE_PREPARES, true);

		try {
			
			if (empty($url->Id)) {
				throw new Exception("Input id is empty");
			}

			$sql = "
			DELETE FROM app_log 
			WHERE
			id = :id";

			$query = $connection->prepare($sql);

			$query->bindParam(':id', $url->Id, PDO::PARAM_INT);

			$query->execute();

			$result = new Result();
			$result->Status = Result::SUCCESS;
			$result->Item = $query->rowCount();
			$result->Message = 'Done.';

		} catch (PDOException $pdoException) {
			$result = new Result();
			$result->Status = Result::ERROR;
			$result->Message = $pdoException->getMessage();
		} catch (Exception $exception) {
			$result = new Result();
			$result->Status = Result::ERROR;
			$result->Message = $exception->getMessage();
		}

		$connection = null;
		return $result;
	}
}

?>