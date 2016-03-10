<?php 

class CompanyInfo implements IQuery {

	public $Id;
	public $Logo;
	public $Alert;
	public $Notify;
	public $Theme;
	public $Field;

	public function __construct() {
	}

	public static function onSelect(Url $url, $data) {
		$database = Flight::get('database');
		$connection = new PDO("mysql:host=$database->Ip;dbname=$database->Database", $database->Username, $database->Password);
		$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$connection->setAttribute(PDO::ATTR_EMULATE_PREPARES, true);


		try {
			if (!empty($url->Id)) {
				$sql = "SELECT * FROM company_info WHERE id = :id;";
				$query = $connection->prepare($sql);
				$query->bindParam(':id',$url->Id, PDO::PARAM_INT);
			//} else if (isset($data['name'])) {
				// $sql = "SELECT * FROM company_info WHERE company_info_name_f LIKE :name OR  company_info_name_m LIKE :name OR company_info_name_l LIKE :name ;";
				// $query = $connection->prepare($sql);
				// $query->bindParam(':name',$data['name'], PDO::PARAM_STR);
			} else {
				$sql = "SELECT * FROM company_info;";
				$query = $connection->prepare($sql);
			}

			$query->execute();

			$result = new Result();
			$result->Item = $query->rowCount();
			$result->Object = array();


			$rows = $query->fetchAll(PDO::FETCH_ASSOC);

			foreach ($rows as $row) {	
				$CompanyInfo = new CompanyInfo();
				$CompanyInfo->Id = (int) $row['id'];
				$CompanyInfo->Logo = $row['info_logo'];
				$CompanyInfo->Alert = (int)$row['info_alert'];
				$CompanyInfo->Notify = (int) $row['info_noti'];
				$CompanyInfo->Theme = $row['info_theme'];
				$CompanyInfo->Field = $row['e_field_id'];
				
				array_push($result->Object, $CompanyInfo);
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

			$companyInfo = json_decode($data['Object']);
			if ($companyInfo == null) {
				throw new Exception(json_get_error());
			}


			$sql = "
			INSERT INTO company_info 
			(info_logo, info_alert, info_noti, info_theme, e_field_id)
			VALUES
			(:info_logo, :info_alert, :info_noti, :info_theme, :e_field_id);";


			$query = $connection->prepare($sql);

			$query->bindParam(':info_logo', $companyInfo->Logo, PDO::PARAM_STR);
			$query->bindParam(':info_alert', $companyInfo->Alert, PDO::PARAM_INT);
			$query->bindParam(':info_noti', $companyInfo->Notify, PDO::PARAM_INT);
			$query->bindParam(':info_theme', $companyInfo->Theme, PDO::PARAM_STR);
			$query->bindParam(':e_field_id', $companyInfo->Field, PDO::PARAM_INT);

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

			$companyInfo = json_decode($data['Object']);
			if ($companyInfo == null) {
				throw new Exception(json_get_error());
			}

			$sql = "
			UPDATE company_info 
			SET
			info_logo = :info_logo,
			info_alert = :info_alert,
			info_noti = :info_noti,
			info_theme = :info_theme,
			e_field_id = :e_field_id

			WHERE
			id = :id;";


			$query = $connection->prepare($sql);

			$query->bindParam(':info_logo', $companyInfo->Logo, PDO::PARAM_STR);
			$query->bindParam(':info_alert', $companyInfo->Alert, PDO::PARAM_INT);
			$query->bindParam(':info_noti', $companyInfo->Notify, PDO::PARAM_INT);
			$query->bindParam(':info_theme', $companyInfo->Theme, PDO::PARAM_STR);
			$query->bindParam(':e_field_id', $companyInfo->Field, PDO::PARAM_INT);

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
			DELETE FROM company_info 
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