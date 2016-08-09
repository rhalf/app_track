<?php 

class Company implements IQuery {

	public $Id;
	public $Name;
	public $Desc;
	public $DtCreated;
	public $Status;

	public function __construct() {
	}

	public static function selectAll() {
		
		$connection = Flight::dbMain();

		try {

			$sql = "SELECT * FROM company;";
			$query = $connection->prepare($sql);
			
			$query->execute();

			$rows = $query->fetchAll(PDO::FETCH_ASSOC);

			$result = array();

			foreach ($rows as $row) {	
				$company = new Company();
				$company->Id = (int) $row['id'];
				$company->Name = $row['company_name'];
				$company->Desc = $row['company_desc'];
				$company->DtCreated = $row['company_dt_created'];
				$company->Status = Status::select($row['e_status_id']);

				array_push($result, $company);
			}

			return $result;

		} catch (PDOException $pdoException) {
			throw $pdoException;
		} catch (Exception $exception) {
			throw $exception;
		} finally {
			$connection = null;
		}
	}

	public static function select($id) {
		
		$connection = Flight::dbMain();

		try {

			$sql = "SELECT * FROM company WHERE id = :id;";
			$query = $connection->prepare($sql);
			
			$query->bindParam(':id',$id, PDO::PARAM_INT);

			$query->execute();

			if ($query->rowCount() < 1){
				return null;
			}

			$row = $query->fetch(PDO::FETCH_ASSOC);

			$company = new Company();
			$company->Id = (int) $row['id'];
			$company->Name = $row['company_name'];
			$company->Desc = $row['company_desc'];
			$company->DtCreated = $row['company_dt_created'];
			$company->Status = Status::select($row['e_status_id']);

			return $company;

		} catch (PDOException $pdoException) {
			throw $pdoException;
		} catch (Exception $exception) {
			throw $exception;
		} finally {
			$connection = null;
		}
	}


	public static function insert() {

		$connection = Flight::dbMain();
		$dateTime = Flight::dateTime();

		try {

			$company = json_decode(file_get_contents("php://input"));

			if ($company == null) {
				throw new Exception(json_get_error());
			}

			$sql = "
			INSERT INTO company 
			(company_name, company_desc, company_dt_created, e_status_id)
			VALUES
			(:company_name, :company_desc, :company_dt_created, :e_status_id);";


			$query = $connection->prepare($sql);

			$query->bindParam(':company_name', $company->Name, PDO::PARAM_STR);
			$query->bindParam(':company_desc', $company->Desc, PDO::PARAM_STR);
			$query->bindParam(':company_dt_created', $dateTime, PDO::PARAM_STR);
			$query->bindParam(':e_status_id', $company->Status->Id, PDO::PARAM_INT);

			$query->execute();
			
			$result = new Result();
			$result->Status = Result::INSERTED;
			$result->Id = $connection->lastInsertId();
			$result->Message = 'Done';

			return $result;

		} catch (PDOException $pdoException) {
			throw $pdoException;
		} catch (Exception $exception) {
			throw $exception;
		} finally {
			$connection = null;
		}
	}
	public static function update($id) {

		$connection = Flight::dbMain();

		try {

			$company = json_decode(file_get_contents("php://input"));

			if ($company == null) {
				throw new Exception(json_get_error());
			}

			$sql = "
			UPDATE company 
			SET 
			company_name = :company_name,
			company_desc = :company_desc, 
			e_status_id = :e_status_id

			WHERE
			id = :id;";


			$query = $connection->prepare($sql);


			$query->bindParam(':company_name', $company->Name, PDO::PARAM_STR);
			$query->bindParam(':company_desc', $company->Desc, PDO::PARAM_STR);
			$query->bindParam(':e_status_id', $company->Status->Id, PDO::PARAM_INT);
			
			$query->bindParam(':id', $id, PDO::PARAM_INT);

			$query->execute();

			$result = new Result();
			$result->Status = Result::UPDATED;
			$result->Id = $id;
			$result->Message = 'Done.';

			return $result;

		} catch (PDOException $pdoException) {
			throw $pdoException;
		} catch (Exception $exception) {
			throw $exception;
		} finally {
			$connection = null;
		}
	}

	public static function delete($id) {

		$connection = Flight::dbMain();

		try {

			$sql = "
			DELETE FROM company 
			WHERE
			id = :id";

			$query = $connection->prepare($sql);

			$query->bindParam(':id', $id, PDO::PARAM_INT);

			$query->execute();

			$result = new Result();
			$result->Status = Result::DELETED;
			$result->Message = 'Done';
			$result->Id = $id;

			return $result;

		} catch (PDOException $pdoException) {
			throw $pdoException;
		} catch (Exception $exception) {
			throw $exception;
		} finally {
			$connection = null;
		}
	}
}
?>