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

	public static function onSelect(Url $url, $data) {
		$database = Flight::get('database');
		$connection = new PDO("mysql:host=$database->Ip;dbname=$database->Database", $database->Username, $database->Password);
		$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$connection->setAttribute(PDO::ATTR_EMULATE_PREPARES, true);

		try {

			if (!empty($url->Id)) {
				$sql = "SELECT * FROM app_client WHERE id = :id;";
				$query = $connection->prepare($sql);
				$query->bindParam(':id',$url->Id, PDO::PARAM_INT);
			} else if (isset($data['platform'])) {
				$sql = "SELECT * FROM app_client WHERE client_platform LIKE :client_platform;";
				$query = $connection->prepare($sql);
				$query->bindParam(':client_platform',$data['platform'], PDO::PARAM_STR);
			} else {
				$sql = "SELECT * FROM app_client;";
				$query = $connection->prepare($sql);
			}

			$query->execute();

			$result = new Result();
			$result->Item = $query->rowCount();
			$result->Object = array();

			$rows = $query->fetchAll(PDO::FETCH_ASSOC);

			foreach ($rows as $row) {	
				$appClient = new AppClient();
				$appClient->Id = (int) $row['id'];
				$appClient->Platform = $row['client_platform'];
				$appClient->Key =  $row['client_key'];
				$appClient->Type = (int)$row['client_type'];
				$appClient->Status = (int)$row['e_status_id'];
				$appClient->DtCreated = $row['client_dt_created'];

				array_push($result->Object, $appClient);
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
		$connection = new PDO("mysql:host=$database->Ip;dbname=$database->Database",  $database->Username, $database->Password);
		$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$connection->setAttribute(PDO::ATTR_EMULATE_PREPARES, true);

		try {

			if (!isset($data['Object'])) {
				throw new Exception("Input object is not set.");
			}

			$appClient = json_decode($data['Object']);
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
		$connection = new PDO("mysql:host=$database->Ip;dbname=$database->Database",  $database->Username, $database->Password);
		$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$connection->setAttribute(PDO::ATTR_EMULATE_PREPARES, true);

		try {
			if (empty($url->Id)) {
				throw new Exception("Input id is empty.");
			}

			if (!isset($data['Object'])) {
				throw new Exception("Input object is not set.");
			}

			$appClient = json_decode($data['Object']);
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
			DELETE FROM app_client 
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