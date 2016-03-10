<?php 

class UserSim implements IQuery {

	public $Id;
	public $Imei;
	public $Number;
	public $Roaming;
	public $AreaCode;
	public $SimVendor;


	public function __construct() {
	}

	public static function onSelect(Url $url, $data) {
		$database = Flight::get('database');
		$connection = new PDO("mysql:host=$database->Ip;dbname=$database->Database", $database->Username, $database->Password);
		$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$connection->setAttribute(PDO::ATTR_EMULATE_PREPARES, true);

		try {
			if (!empty($url->Id)) {
				$sql = "SELECT * FROM user_sim WHERE id = :id;";
				$query = $connection->prepare($sql);
				$query->bindParam(':id',$url->Id, PDO::PARAM_INT);
			// } else if (isset($data['name'])) {
			// 	$sql = "SELECT * FROM user_sim WHERE sim_name_f LIKE :name OR  sim_name_m LIKE :name OR sim_name_l LIKE :name ;";
			// 	$query = $connection->prepare($sql);
			// 	$query->bindParam(':name',$data['name'], PDO::PARAM_STR);
			} else {
				$sql = "SELECT * FROM user_sim;";
				$query = $connection->prepare($sql);
			}

			$query->execute();

			$result = new Result();
			$result->Item = $query->rowCount();
			$result->Object = array();


			$rows = $query->fetchAll(PDO::FETCH_ASSOC);

			foreach ($rows as $row) {	
				$userSim = new UserSim();
				$userSim->Id = (int) $row['id'];
				$userSim->Imei = (int) $row['sim_imei'];
				$userSim->Number = (int) $row['sim_number'];
				$userSim->Roaming = (bool) $row['sim_roaming'];
				$userSim->AreaCode = (int) $row['sim_area_code'];
				$userSim->SimVendor = (int) $row['e_sim_vendor_id'];

				array_push($result->Object, $userSim);
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

			$userSim = json_decode($data['Object']);
			if ($userSim == null) {
				throw new Exception(json_get_error());
			}

			$sql = "
			INSERT INTO user_sim 
			(sim_imei, sim_number, sim_roaming, sim_area_code, e_sim_vendor_id)
			VALUES
			(:sim_imei, :sim_number, :sim_roaming, :sim_area_code, :e_sim_vendor_id);";


			$query = $connection->prepare($sql);

			$query->bindParam(':sim_imei', $userSim->Imei, PDO::PARAM_INT);
			$query->bindParam(':sim_number', $userSim->Number, PDO::PARAM_INT);
			$query->bindParam(':sim_roaming', $userSim->Roaming, PDO::PARAM_BOOL);
			$query->bindParam(':sim_area_code', $userSim->AreaCode, PDO::PARAM_INT);
			$query->bindParam(':e_sim_vendor_id', $userSim->SimVendor, PDO::PARAM_INT);

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

		//$connection->beginTransaction();
		try {
			if (empty($url->Id)) {
				throw new Exception("Input id is empty.");
			}

			if (!isset($data['Object'])) {
				throw new Exception("Input object is not set.");
			}

			$userSim = json_decode($data['Object']);
			if ($userSim == null) {
				throw new Exception(json_get_error());
			}

			$sql = "

			UPDATE user_sim 
			SET
			sim_imei = :sim_imei,
			sim_number = :sim_number,
			sim_roaming = :sim_roaming,
			sim_area_code = :sim_area_code,
			e_sim_vendor_id = :e_sim_vendor_id

			WHERE
			id = :id;";


			$query = $connection->prepare($sql);

			$query->bindParam(':sim_imei', $userSim->Imei, PDO::PARAM_INT);
			$query->bindParam(':sim_number', $userSim->Number, PDO::PARAM_INT);
			$query->bindParam(':sim_roaming', $userSim->Roaming, PDO::PARAM_BOOL);
			$query->bindParam(':sim_area_code', $userSim->AreaCode, PDO::PARAM_INT);
			$query->bindParam(':e_sim_vendor_id', $userSim->SimVendor, PDO::PARAM_INT);


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
			DELETE FROM user_sim 
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