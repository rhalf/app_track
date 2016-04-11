<?php 

class Company implements IQuery {

	public $Id;
	public $Name;
	public $Desc;
	public $DtCreated;
	public $Status;
	public $CompanyInfo;

	public function __construct() {
	}

	public static function onSelect(Url $url, $data) {
		
		$connection = Flight::dbMain();

		try {
			if (!empty($url->Id)) {
				$sql = "SELECT * FROM company WHERE id = :id;";
				$query = $connection->prepare($sql);
				$query->bindParam(':id',$url->Id, PDO::PARAM_INT);
			} else if (isset($data['name'])) {
				$sql = "SELECT * FROM company WHERE company_name LIKE :name;";
				$query = $connection->prepare($sql);
				$query->bindParam(':name',$data['name'], PDO::PARAM_STR);
			} else {
				$sql = "SELECT * FROM company;";
				$query = $connection->prepare($sql);
			}

			$query->execute();

			$result = new Result();
			$result->Item = $query->rowCount();
			$result->Object = array();


			$rows = $query->fetchAll(PDO::FETCH_ASSOC);

			foreach ($rows as $row) {	
				$company = new Company();
				$company->Id = (int) $row['id'];
				$company->Name = $row['company_name'];
				$company->Desc = $row['company_desc'];
				$company->DtCreated = $row['company_dt_created'];
				$company->Status = (int) $row['e_status_id'];
				$company->CompanyInfo = (int) $row['company_info_id'];

				array_push($result->Object, $company);
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
		
		$connection = Flight::dbMain();

		try {

			if (!isset($data['Object'])) {
				throw new Exception("Input object is not set.");
			}

			$company = json_decode($data['Object']);
			if ($company == null) {
				throw new Exception(json_get_error());
			}


			$sql = "
			INSERT INTO company 
			(company_name, company_desc, company_dt_created, e_status_id, company_info_id)
			VALUES
			(:company_name, :company_desc, :company_dt_created, :e_status_id, :company_info_id);";


			$query = $connection->prepare($sql);

			$query->bindParam(':company_name', $company->Name, PDO::PARAM_STR);
			$query->bindParam(':company_desc', $company->Desc, PDO::PARAM_STR);
			$query->bindParam(':company_dt_created', $company->DtCreated, PDO::PARAM_STR);
			$query->bindParam(':e_status_id', $company->Status, PDO::PARAM_INT);
			$query->bindParam(':company_info_id', $company->CompanyInfo, PDO::PARAM_INT);


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

		$connection = Flight::dbMain();

		//$connection->beginTransaction();
		try {
			if (empty($url->Id)) {
				throw new Exception("Input id is empty.");
			}

			if (!isset($data['Object'])) {
				throw new Exception("Input object is not set.");
			}

			$company = json_decode($data['Object']);
			if ($company == null) {
				throw new Exception(json_get_error());
			}

			$sql = "
			UPDATE company 
			SET 
			company_name = :company_name,
			company_desc = :company_desc, 
			company_dt_created = :company_dt_created,
			e_status_id = :e_status_id, 
			company_info_id = :company_info_id
			WHERE
			id = :id;";


			$query = $connection->prepare($sql);


			$query->bindParam(':company_name', $company->Name, PDO::PARAM_STR);
			$query->bindParam(':company_desc', $company->Desc, PDO::PARAM_STR);
			$query->bindParam(':company_dt_created', $company->DtCreated, PDO::PARAM_STR);
			$query->bindParam(':e_status_id', $company->Status, PDO::PARAM_INT);
			$query->bindParam(':company_info_id', $company->CompanyInfo, PDO::PARAM_INT);
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
		
		$connection = Flight::dbMain();

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