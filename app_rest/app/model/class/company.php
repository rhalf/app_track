<?php 

require_once('/app/model/interface/iquery.php');


class Company implements IQuery {

	public $Id;
	public $Name;
	public $Desc;
	public $DtCreated;
	public $Status;
	public $Info;
	public $Field;
	public $Setting;

	public function __construct() {
	}

	public static function onSelect($get) {
		$database = Flight::get('database');
		$connection = new PDO("mysql:host=$database->Ip;dbname=$database->Database", $database->Username, $database->Password);
		$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$connection->setAttribute(PDO::ATTR_EMULATE_PREPARES, true);

		$array['result'] = array();
		$array['company'] = array();


		try {
			if (isset($get['id'])) {
				$sql = "SELECT * FROM company WHERE id  in  (:id);";
			} else {
				$sql = "SELECT * FROM company;";
			}
			

			$query = $connection->prepare($sql);
			$query->bindParam(':id', $get['id'], PDO::PARAM_INT);

			$query->execute();

			$rows = $query->fetchAll(PDO::FETCH_ASSOC);

			if (!$rows) {
				throw new PDOException( "Object with id " . $get['id'] ." doesn't exist.", '02000');
			}

			foreach ($rows as $row) {	
				$company = new Company();
				$company->Id = (int) $row['id'];
				$company->Name = $row['company_name'];
				$company->Desc = $row['company_desc'];
				$company->DtCreated = $row['company_dt_created'];
				$company->Status = (int) $row['e_status_id'];
				$company->Info = (int) $row['info_id'];
				$company->Field = (int) $row['e_field_id'];

				array_push($array['company'], $company);
			}

			$result = new Result(0, RESULT::PDO, "Success");
			$array['result'] = $result;

		} catch (PDOException $pdoException) {
			$result = new Result($pdoException->getCode(), RESULT::PDO, $pdoException->getMessage());
			$array['result'] = $result;
		} catch (Exception $exception) {
			$result = new Result(1, RESULT::SYSTEM, $exception->getMessage());
			$array['result'] = $result;
		}


		$connection = null;

		return $array;
	}
	public static function onInsert($post) {
		$database = Flight::get('database');
		$connection = new PDO("mysql:host=$database->Ip;dbname=$database->Database", $database->Username, $database->Password);
		$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$connection->setAttribute(PDO::ATTR_EMULATE_PREPARES, true);

		try {

			$array['result'] = array();

			if(!isset($post['object'])) {
				throw new Exception("Input object is null", 1);
			}

			$json = $post['object'];

			$object = json_decode($json);

			$company = $object->company[0];

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

			$result = new Result(0, RESULT::PDO, "Success");
			$array['result'] = $result;

		} catch (PDOException $pdoException) {
			$result = new Result($pdoException->getCode(), RESULT::PDO, $pdoException->getMessage());
			$array['result'] = $result;
		} catch (Exception $exception) {
			$result = new Result(1, RESULT::SYSTEM, $exception->getMessage());
			$array['result'] = $result;
		}

		$connection = null;

		return $array;
	}
	public static function onUpdate($put) {
		$database = Flight::get('database');

		$connection = new PDO("mysql:host=$database->Ip;dbname=$database->Database", $database->Username, $database->Password);
		$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$connection->setAttribute(PDO::ATTR_EMULATE_PREPARES, true);

		//$connection->beginTransaction();

		$array['result'] = array();

		try {
			if (!isset($put['id']) || !isset($put['object'])) {
				throw new Exception("Input object and id are null.", 1);
			}

			$id = $put['id'];
			$object = json_decode($put['object']);

			$company = $object->company[0];


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
			$query->bindParam(':id', $id, PDO::PARAM_INT);


			$query->execute();

			//$connection->commit();

			$result = new Result(0, RESULT::PDO, "Success");
			$array['result'] = $result;

		} catch (PDOException $pdoException) {
			//$connection->rollback();
			$result = new Result($pdoException->getCode(), RESULT::PDO, $pdoException->getMessage());
			$array['result'] = $result;
		} catch (Exception $exception) {
			//$connection->rollback();
			$result = new Result(1, RESULT::SYSTEM, $exception->getMessage());
			$array['result'] = $result;
		}

		$connection = null;

		return $array;
	}
	public static function onDelete($delete) {
		$database = Flight::get('database');

		$connection = new PDO("mysql:host=$database->Ip;dbname=$database->Database", $database->Username, $database->Password);
		$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$connection->setAttribute(PDO::ATTR_EMULATE_PREPARES, true);

		$array['result'] = array();

		
		try {
			if (!isset($delete['id'])) {
				throw new Exception("Input id is null", 1);
			}

			$id = $delete['id'];
			
			$sql = "
			DELETE FROM company 
			WHERE
			id = :id";

			$query = $connection->prepare($sql);

			$query->bindParam(':id', $id, PDO::PARAM_INT);

			$query->execute();

			$result = new Result(0, RESULT::PDO, "Success");
			$array['result'] = $result;

		} catch (PDOException $pdoException) {
			$result = new Result($pdoException->getCode(), RESULT::PDO, $pdoException->getMessage());
			$array['result'] = $result;
		} catch (Exception $exception) {
			$result = new Result(1, RESULT::SYSTEM, $exception->getMessage());
			$array['result'] = $result;
		}

		$connection = null;

		return $array;
	}
}

?>