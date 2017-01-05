<?php 

class CompanyInfo implements IQuery {

	public $Id;
	public $Logo;
	public $Alert;
	public $Notify;
	public $Theme;
	public $Field;
	public $Company;

	public function __construct() {
	}

	public static function selectAll() {
		
		$connection = Flight::dbMain();

		try {

			$sql = "SELECT * FROM company_info;";
			$query = $connection->prepare($sql);

			
			$query->execute();

			$rows = $query->fetchAll(PDO::FETCH_ASSOC);

			$result = array();


			foreach ($rows as $row) {	
				$companyInfo = new CompanyInfo();
				$companyInfo->Id = (int) $row['id'];
				$companyInfo->Logo = $row['info_logo'];
				$companyInfo->Alert = (int)$row['info_alert'];
				$companyInfo->Notify = (int) $row['info_noti'];
				$companyInfo->Theme = (int)$row['info_theme'];
				$companyInfo->Field = Field::select($row['e_field_id']);
				$companyInfo->Company = Company::select($row['company_id']);

				array_push($result, $companyInfo);
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

			$sql = "SELECT * FROM company_info WHERE id = :id LIMIT 1;";
			$query = $connection->prepare($sql);
			$query->bindParam(':id',$id, PDO::PARAM_INT);

			$query->execute();

			if ($query->rowCount() < 1){
				return null;
			}

			$row = $query->fetch(PDO::FETCH_ASSOC);


			$companyInfo = new CompanyInfo();
			$companyInfo->Id = (int) $row['id'];
			$companyInfo->Logo = $row['info_logo'];
			$companyInfo->Alert = (int)$row['info_alert'];
			$companyInfo->Notify = (int) $row['info_noti'];
			$companyInfo->Theme = (int)$row['info_theme'];
			$companyInfo->Field = Field::select($row['e_field_id']);
			$companyInfo->Company = Company::select($row['company_id']);


			return $companyInfo;

		} catch (PDOException $pdoException) {
			throw $pdoException;
		} catch (Exception $exception) {
			throw $exception;
		} finally {
			$connection = null;
		}
	}
	public static function selectByCompany($id) {
		$connection = Flight::dbMain();

		try {

			$sql = "SELECT * FROM company_info WHERE company_id = :company_id LIMIT 1;";
			$query = $connection->prepare($sql);
			$query->bindParam(':company_id',$id, PDO::PARAM_INT);

			$query->execute();

			if ($query->rowCount() < 1){
				return null;
			}

			$row = $query->fetch(PDO::FETCH_ASSOC);


			$companyInfo = new CompanyInfo();
			$companyInfo->Id = (int) $row['id'];
			$companyInfo->Logo = $row['info_logo'];
			$companyInfo->Alert = (int)$row['info_alert'];
			$companyInfo->Notify = (int) $row['info_noti'];
			$companyInfo->Theme = (int)$row['info_theme'];
			$companyInfo->Field = Field::select($row['e_field_id']);
			$companyInfo->Company = Company::select($row['company_id']);


			return $companyInfo;

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

		try {

			$companyInfo = json_decode(file_get_contents("php://input"));

			if ($companyInfo == null) {
				throw new Exception(json_get_error());
			}


			$sql = "
			INSERT INTO company_info 
			(info_logo, info_alert, info_noti, info_theme, e_field_id, company_id)
			VALUES
			(:info_logo, :info_alert, :info_noti, :info_theme, :e_field_id, :company_id);";


			$query = $connection->prepare($sql);

			$query->bindParam(':info_logo', $companyInfo->Logo, PDO::PARAM_STR);
			$query->bindParam(':info_alert', $companyInfo->Alert, PDO::PARAM_INT);
			$query->bindParam(':info_noti', $companyInfo->Notify, PDO::PARAM_INT);
			$query->bindParam(':info_theme', $companyInfo->Theme, PDO::PARAM_INT);
			$query->bindParam(':e_field_id', $companyInfo->Field->Id, PDO::PARAM_INT);
			$query->bindParam(':company_id', $companyInfo->Company->Id, PDO::PARAM_INT);


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

			$companyInfo = json_decode(file_get_contents("php://input"));

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
			e_field_id = :e_field_id,
			company_id = :company_id

			WHERE
			id = :id;";


			$query = $connection->prepare($sql);

			$query->bindParam(':info_logo', $companyInfo->Logo, PDO::PARAM_STR);
			$query->bindParam(':info_alert', $companyInfo->Alert, PDO::PARAM_INT);
			$query->bindParam(':info_noti', $companyInfo->Notify, PDO::PARAM_INT);
			$query->bindParam(':info_theme', $companyInfo->Theme, PDO::PARAM_INT);
			$query->bindParam(':e_field_id', $companyInfo->Field->Id, PDO::PARAM_INT);
			$query->bindParam(':company_id', $companyInfo->Company->Id, PDO::PARAM_INT);

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
			DELETE FROM company_info 
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