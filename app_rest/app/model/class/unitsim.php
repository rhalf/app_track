<?php 

class UnitSim implements IQuery {

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
				$sql = "SELECT * FROM unit_sim WHERE id = :id;";
				$query = $connection->prepare($sql);
				$query->bindParam(':id',$url->Id, PDO::PARAM_INT);
			// } else if (isset($data['name'])) {
			// 	$sql = "SELECT * FROM unit_sim WHERE sim_name_f LIKE :name OR  sim_name_m LIKE :name OR sim_name_l LIKE :name ;";
			// 	$query = $connection->prepare($sql);
			// 	$query->bindParam(':name',$data['name'], PDO::PARAM_STR);
			} else {
				$sql = "SELECT * FROM unit_sim;";
				$query = $connection->prepare($sql);
			}

			$query->execute();

			$result = new Result();
			$result->Item = $query->rowCount();
			$result->Object = array();


			$rows = $query->fetchAll(PDO::FETCH_ASSOC);

			foreach ($rows as $row) {	
				$unitSim = new UnitSim();
				$unitSim->Id = (int) $row['id'];
				$unitSim->Imei = (int) $row['sim_imei'];
				$unitSim->Number = (int) $row['sim_number'];
				$unitSim->Roaming = (bool) $row['sim_roaming'];
				$unitSim->AreaCode = (int) $row['sim_area_code'];
				$unitSim->SimVendor = (int) $row['e_sim_vendor_id'];

				array_push($result->Object, $unitSim);
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

			$unitSim = json_decode($data['Object']);
			if ($unitSim == null) {
				throw new Exception(json_get_error());
			}

			$sql = "
			INSERT INTO unit_sim 
			(sim_imei, sim_number, sim_roaming, sim_area_code, e_sim_vendor_id)
			VALUES
			(:sim_imei, :sim_number, :sim_roaming, :sim_area_code, :e_sim_vendor_id);";


			$query = $connection->prepare($sql);

			$query->bindParam(':sim_imei', $unitSim->Imei, PDO::PARAM_INT);
			$query->bindParam(':sim_number', $unitSim->Number, PDO::PARAM_INT);
			$query->bindParam(':sim_roaming', $unitSim->Roaming, PDO::PARAM_BOOL);
			$query->bindParam(':sim_area_code', $unitSim->AreaCode, PDO::PARAM_INT);
			$query->bindParam(':e_sim_vendor_id', $unitSim->SimVendor, PDO::PARAM_INT);

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

			$object = json_decode($data['Object']);
			$unitSim = $object->UnitSim[0];



			$sql = "

			UPDATE unit_sim 
			SET
			sim_imei = :sim_imei,
			sim_number = :sim_number,
			sim_roaming = :sim_roaming,
			sim_area_code = :sim_area_code,
			e_sim_vendor_id = :e_sim_vendor_id

			WHERE
			id = :id;";


			$query = $connection->prepare($sql);

			$query->bindParam(':sim_imei', $unitSim->Imei, PDO::PARAM_INT);
			$query->bindParam(':sim_number', $unitSim->Number, PDO::PARAM_INT);
			$query->bindParam(':sim_roaming', $unitSim->Roaming, PDO::PARAM_BOOL);
			$query->bindParam(':sim_area_code', $unitSim->AreaCode, PDO::PARAM_INT);
			$query->bindParam(':e_sim_vendor_id', $unitSim->SimVendor, PDO::PARAM_INT);


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
			DELETE FROM unit_sim 
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