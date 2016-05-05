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

	public static function selectAll() {
		
		$connection = Flight::dbMain();

		try {

			$sql = "SELECT * FROM company_info;";
			$query = $connection->prepare($sql);

			
			$query->execute();

			$rows = $query->fetchAll(PDO::FETCH_ASSOC);

			$result = array();


			foreach ($rows as $row) {	
				$CompanyInfo = new CompanyInfo();
				$CompanyInfo->Id = (int) $row['id'];
				$CompanyInfo->Logo = $row['info_logo'];
				$CompanyInfo->Alert = (int)$row['info_alert'];
				$CompanyInfo->Notify = (int) $row['info_noti'];
				$CompanyInfo->Theme = $row['info_theme'];
				$CompanyInfo->Field = $row['e_field_id'];
				
				array_push($result, $CompanyInfo);
			}

			Flight::ok($result);

		} catch (PDOException $pdoException) {
			Flight::error($pdoException);
		} catch (Exception $exception) {
			Flight::error($exception);
		} finally {
			$connection = null;
		}
	}

	public static function select($id) {
		
		$connection = Flight::dbMain();

		try {

			$sql = "SELECT * FROM company_info WHERE id = :id;";
			$query = $connection->prepare($sql);
			$query->bindParam(':id',$id, PDO::PARAM_INT);

			$query->execute();

			if ($query->rowCount() < 1){
				Flight::notFound("id not found");
			}

			$row = $query->fetch(PDO::FETCH_ASSOC);


			$companyInfo = new CompanyInfo();
			$companyInfo->Id = (int) $row['id'];
			$companyInfo->Logo = $row['info_logo'];
			$companyInfo->Alert = (int)$row['info_alert'];
			$companyInfo->Notify = (int) $row['info_noti'];
			$companyInfo->Theme = $row['info_theme'];
			$companyInfo->Field = $row['e_field_id'];


			Flight::ok($companyInfo);

		} catch (PDOException $pdoException) {
			Flight::error($pdoException);
		} catch (Exception $exception) {
			Flight::error($exception);
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
			$result->Status = Result::INSERTED;
			$result->Id = $connection->lastInsertId();
			$result->Message = 'Done';

			Flight::ok($result);

		} catch (PDOException $pdoException) {
			Flight::error($pdoException);
		} catch (Exception $exception) {
			Flight::error($exception);
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
			e_field_id = :e_field_id

			WHERE
			id = :id;";


			$query = $connection->prepare($sql);

			$query->bindParam(':info_logo', $companyInfo->Logo, PDO::PARAM_STR);
			$query->bindParam(':info_alert', $companyInfo->Alert, PDO::PARAM_INT);
			$query->bindParam(':info_noti', $companyInfo->Notify, PDO::PARAM_INT);
			$query->bindParam(':info_theme', $companyInfo->Theme, PDO::PARAM_STR);
			$query->bindParam(':e_field_id', $companyInfo->Field, PDO::PARAM_INT);

			$query->bindParam(':id', $id, PDO::PARAM_INT);

			$query->execute();

			$result = new Result();
			$result->Status = Result::UPDATED;
			$result->Id = $id;
			$result->Message = 'Done.';

			Flight::ok($result);

		} catch (PDOException $pdoException) {
			Flight::error($pdoException);
		} catch (Exception $exception) {
			Flight::error($exception);
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

			Flight::ok($result);

		} catch (PDOException $pdoException) {
			Flight::error($pdoException);
		} catch (Exception $exception) {
			Flight::error($exception);
		} finally {
			$connection = null;
		}
	}
}
?>