<?php 

class Company implements IQuery {

	public $Id;
	public $Name;
	public $Desc;
	public $DtCreated;
	public $Status;
	public $Info;
	public $Field;

	public function __construct() {
	}

	public static function onSelect(Url $url, $get) {
		$database = Flight::get('database');
		$connection = new PDO("mysql:host=$database->Ip;dbname=$database->Database", $database->Username, $database->Password);
		$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$connection->setAttribute(PDO::ATTR_EMULATE_PREPARES, true);

		try {
			if (!empty($url->Id)) {
				$sql = "SELECT * FROM company WHERE id = :id;";
				$query = $connection->prepare($sql);
				$query->bindParam(':id',$url->Id, PDO::PARAM_INT);
			} else if (isset($get['name'])) {
				$sql = "SELECT * FROM company WHERE company_name LIKE :name;";
				$query = $connection->prepare($sql);
				$query->bindParam(':name',$get['name'], PDO::PARAM_STR);
			} else {
				$sql = "SELECT * FROM company;";
				$query = $connection->prepare($sql);
			}

			$query->execute();

			$result = new Result();
			$result->Item = $query->rowCount();
			$result->Object['Company'] = array();


			$rows = $query->fetchAll(PDO::FETCH_ASSOC);

			foreach ($rows as $row) {	
				$company = new Company();
				$company->Id = (int) $row['id'];
				$company->Name = $row['company_name'];
				$company->Desc = $row['company_desc'];
				$company->DtCreated = $row['company_dt_created'];
				$company->Status = (int) $row['e_status_id'];
				$company->Info = (int) $row['info_id'];
				$company->Field = (int) $row['e_field_id'];

				array_push($result->Object['Company'], $company);
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
			$company = $object->Company[0];

			$sql = "
			INSERT INTO company 
			(company_name, company_desc, company_dt_created, e_status_id, info_id, e_field_id)
			VALUES
			(:company_name, :company_desc, :company_dt_created, :e_status_id, :info_id, :e_field_id);";


			$query = $connection->prepare($sql);

			$query->bindParam(':company_name', $company->Name, PDO::PARAM_STR);
			$query->bindParam(':company_desc', $company->Desc, PDO::PARAM_STR);
			$query->bindParam(':company_dt_created', $company->DtCreated, PDO::PARAM_STR);
			$query->bindParam(':e_status_id', $company->Status, PDO::PARAM_INT);
			$query->bindParam(':info_id', $company->Info, PDO::PARAM_INT);
			$query->bindParam(':e_field_id', $company->Field, PDO::PARAM_INT);


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
			$company = $object->Company[0];

			$sql = "
			UPDATE company 
			SET 
			company_name = :company_name,
			company_desc = :company_desc, 
			company_dt_created = :company_dt_created,
			e_status_id = :e_status_id, 
			info_id = :info_id, 
			e_field_id = :e_field_id
			WHERE
			id = :id;";

			

			$query = $connection->prepare($sql);


			$query->bindParam(':company_name', $company->Name, PDO::PARAM_STR);
			$query->bindParam(':company_desc', $company->Desc, PDO::PARAM_STR);
			$query->bindParam(':company_dt_created', $company->DtCreated, PDO::PARAM_STR);
			$query->bindParam(':e_status_id', $company->Status, PDO::PARAM_INT);
			$query->bindParam(':info_id', $company->Info, PDO::PARAM_INT);
			$query->bindParam(':e_field_id', $company->Field, PDO::PARAM_INT);
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
			DELETE FROM company 
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