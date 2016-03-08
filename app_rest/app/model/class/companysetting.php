<?php 

class CompanySetting implements IQuery {

	public $Id;
	public $Logo;
	public $Alert;
	public $Notify;
	public $Theme;
	public $Company;

	public function __construct() {
	}

	public static function onSelect(Url $url, $get) {
		$database = Flight::get('database');
		$connection = new PDO("mysql:host=$database->Ip;dbname=$database->Database", $database->Username, $database->Password);
		$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$connection->setAttribute(PDO::ATTR_EMULATE_PREPARES, true);

		try {
			if (!empty($url->Id)) {
				$sql = "SELECT * FROM company_setting WHERE id = :id;";
				$query = $connection->prepare($sql);
				$query->bindParam(':id',$url->Id, PDO::PARAM_INT);
			//} else if (isset($get['name'])) {
				// $sql = "SELECT * FROM company_setting WHERE company_setting_name_f LIKE :name OR  company_setting_name_m LIKE :name OR company_setting_name_l LIKE :name ;";
				// $query = $connection->prepare($sql);
				// $query->bindParam(':name',$get['name'], PDO::PARAM_STR);
			} else {
				$sql = "SELECT * FROM company_setting;";
				$query = $connection->prepare($sql);
			}

			$query->execute();

			$result = new Result();
			$result->Item = $query->rowCount();
			$result->Object['CompanySetting'] = array();


			$rows = $query->fetchAll(PDO::FETCH_ASSOC);

			foreach ($rows as $row) {	
				$companySetting = new CompanySetting();
				$companySetting->Id = (int) $row['id'];
				$companySetting->Logo = $row['setting_logo'];
				$companySetting->Alert = (int)$row['setting_alert'];
				$companySetting->Notify = (int) $row['setting_noti'];
				$companySetting->Theme = $row['setting_theme'];
				$companySetting->Company = $row['company_id'];
				

				array_push($result->Object['CompanySetting'], $companySetting);
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
			$companySetting = $object->CompanySetting[0];

			$sql = "
			INSERT INTO company_setting 
			(setting_id, setting_name_f, setting_name_m, setting_name_l, setting_rfid, e_status_id, id, sim_id, info_id)
			VALUES
			(:setting_id, :setting_name_f, :setting_name_m, :setting_name_l, :setting_rfid, :e_status_id, :id, :sim_id, :info_id);";


			$query = $connection->prepare($sql);

			$query->bindParam(':company_setting_id', $companySetting->DriverId, PDO::PARAM_STR);
			$query->bindParam(':company_setting_name_f', $companySetting->NameFirst, PDO::PARAM_STR);
			$query->bindParam(':company_setting_name_m', $companySetting->NameMiddle, PDO::PARAM_STR);
			$query->bindParam(':company_setting_name_l', $companySetting->NameLast, PDO::PARAM_STR);
			$query->bindParam(':company_setting_rfid', $companySetting->Rfid, PDO::PARAM_INT);
			$query->bindParam(':e_status_id', $companySetting->Status, PDO::PARAM_INT);
			$query->bindParam(':company_id', $companySetting->Company, PDO::PARAM_INT);
			$query->bindParam(':sim_id', $companySetting->Sim, PDO::PARAM_INT);
			$query->bindParam(':info_id', $companySetting->Info, PDO::PARAM_INT);

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
			$companySetting = $object->company_setting[0];

			$sql = "
			UPDATE company_setting 
			SET
			company_setting_id = :company_setting_id,
			company_setting_name_f = :company_setting_name_f,
			company_setting_name_m = :company_setting_name_m,
			company_setting_name_l = :company_setting_name_l,
			company_setting_rfid = :company_setting_rfid,
			e_status_id = :e_status_id,
			company_id = :company_id,
			sim_id = :sim_id,
			info_id = :info_id

			WHERE
			id = :id;";


			$query = $connection->prepare($sql);

			$query->bindParam(':company_setting_id', $companySetting->DriverId, PDO::PARAM_STR);
			$query->bindParam(':company_setting_name_f', $companySetting->NameFirst, PDO::PARAM_STR);
			$query->bindParam(':company_setting_name_m', $companySetting->NameMiddle, PDO::PARAM_STR);
			$query->bindParam(':company_setting_name_l', $companySetting->NameLast, PDO::PARAM_STR);
			$query->bindParam(':company_setting_rfid', $companySetting->Rfid, PDO::PARAM_INT);
			$query->bindParam(':e_status_id', $companySetting->Status, PDO::PARAM_INT);
			$query->bindParam(':company_id', $companySetting->Company, PDO::PARAM_INT);
			$query->bindParam(':sim_id', $companySetting->Sim, PDO::PARAM_INT);
			$query->bindParam(':info_id', $companySetting->Info, PDO::PARAM_INT);

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
			DELETE FROM company_setting 
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