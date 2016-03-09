<?php 

class VehicleCollection implements IQuery {

	public $Id;
	public $Vehicle;
	public $User;
	public $Collection;


	public function __construct() {
	}

	public static function onSelect(Url $url, $get) {
		$database = Flight::get('database');
		$connection = new PDO("mysql:host=$database->Ip;dbname=$database->Database", $database->Username, $database->Password);
		$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$connection->setAttribute(PDO::ATTR_EMULATE_PREPARES, true);

		try {
			if (!empty($url->Id)) {
				$sql = "SELECT * FROM vehicle_collection WHERE id = :id;";
				$query = $connection->prepare($sql);
				$query->bindParam(':id',$url->Id, PDO::PARAM_INT);
			} else if (isset($get['vehicle'])) {
				$sql = "SELECT * FROM vehicle_collection WHERE vehicle_id = :vehicle_id;";
				$query = $connection->prepare($sql);
				$query->bindParam(':vehicle_id',$get['vehicle'], PDO::PARAM_INT);
			} else if (isset($get['user'])) {
				$sql = "SELECT * FROM vehicle_collection WHERE user_id = :user_id;";
				$query = $connection->prepare($sql);
				$query->bindParam(':user_id',$get['user'], PDO::PARAM_INT);
			} else if (isset($get['collection'])) {
				$sql = "SELECT * FROM vehicle_collection WHERE collection_id = :collection_id;";
				$query = $connection->prepare($sql);
				$query->bindParam(':collection_id',$get['collection'], PDO::PARAM_INT);
			} else {
				$sql = "SELECT * FROM vehicle_collection;";
				$query = $connection->prepare($sql);
			}

			$query->execute();

			$result = new Result();
			$result->Item = $query->rowCount();
			$result->Object['VehicleCollection'] = array();


			$rows = $query->fetchAll(PDO::FETCH_ASSOC);

			foreach ($rows as $row) {	
				$vehicleCollection = new VehicleCollection();
				$vehicleCollection->Id = (int) $row['id'];
				$vehicleCollection->Vehicle =  (int) $row['vehicle_id'];
				$vehicleCollection->User =  (int) $row['user_id'];
				$vehicleCollection->Collection =  (int) $row['collection_id'];

				array_push($result->Object['VehicleCollection'], $vehicleCollection);
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

	public static function onInsert(Url $url, $post) {
		$database = Flight::get('database');
		$connection = new PDO("mysql:host=$database->Ip;dbname=$database->Database", $database->Username, $database->Password);
		$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$connection->setAttribute(PDO::ATTR_EMULATE_PREPARES, true);

		try {

			if (!isset($post['object'])) {
				throw new Exception("Input object is not set.");
			}

			$object = json_decode($post['object']);
			$vehicleCollection = $object->VehicleCollection[0];

			$sql = "
			INSERT INTO vehicle_collection 
			(vehicle_id, user_id, collection_id)
			VALUES
			(:vehicle_id, :user_id, :collection_id);";

			$query = $connection->prepare($sql);

			$query->bindParam(':vehicle_id', $vehicleCollection->Vehicle, PDO::PARAM_STR);
			$query->bindParam(':user_id', $vehicleCollection->User, PDO::PARAM_STR);
			$query->bindParam(':collection_id', $vehicleCollection->Collection, PDO::PARAM_STR);


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
	public static function onUpdate(Url $url, $put) {
		$database = Flight::get('database');
		$connection = new PDO("mysql:host=$database->Ip;dbname=$database->Database", $database->Username, $database->Password);
		$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$connection->setAttribute(PDO::ATTR_EMULATE_PREPARES, true);

		//$connection->beginTransaction();

		try {
			if (empty($url->Id)) {
				throw new Exception("Input id is empty.");
			}

			if (!isset($put['object'])) {
				throw new Exception("Input object is not set.");
			}

			$object = json_decode($put['object']);
			$vehicleCollection = $object->VehicleCollection[0];

			$sql = "
			UPDATE vehicle_collection 
			SET 
			vehicle_id = :vehicle_id,
			user_id = :user_id, 
			collection_id = :collection_id
			
			WHERE
			id = :id;";
			

			$query = $connection->prepare($sql);

			$query->bindParam(':vehicle_id', $vehicleCollection->Vehicle, PDO::PARAM_STR);
			$query->bindParam(':user_id', $vehicleCollection->User, PDO::PARAM_STR);
			$query->bindParam(':collection_id', $vehicleCollection->Collection, PDO::PARAM_STR);

			$query->bindParam(':id', $url->Id, PDO::PARAM_INT);

			$query->execute();

			//$connection->commit();

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
	public static function onDelete(Url $url, $delete) {
		$database = Flight::get('database');
		$connection = new PDO("mysql:host=$database->Ip;dbname=$database->Database", $database->Username, $database->Password);
		$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$connection->setAttribute(PDO::ATTR_EMULATE_PREPARES, true);

		try {
			
			if (empty($url->Id)) {
				throw new Exception("Input id is empty");
			}

			$sql = "
			DELETE FROM vehicle_collection 
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