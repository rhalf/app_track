<?php 

class AppSetting implements IQuery {

	public $Id;
	public $Name;
	public $Value;
	public $Desc;
	
	public function __construct() {
	}

	public static function onSelect(Url $url, $data) {
		
		$connection = Flight::dbMain();

		try {

			if (!empty($url->Id)) {
				$sql = "SELECT * FROM app_setting WHERE id = :id;";
				$query = $connection->prepare($sql);
				$query->bindParam(':id',$url->Id, PDO::PARAM_INT);
			} else if (isset($data['name'])) {
				$sql = "SELECT * FROM app_setting WHERE setting_name LIKE :name;";
				$query = $connection->prepare($sql);
				$query->bindParam(':name',$data['name'], PDO::PARAM_STR);
			} else {
				$sql = "SELECT * FROM app_setting;";
				$query = $connection->prepare($sql);
			}

			$query->execute();

			$result = new Result();
			$result->Item = $query->rowCount();
			$result->Object = array();

			$rows = $query->fetchAll(PDO::FETCH_ASSOC);

			foreach ($rows as $row) {	
				$appsetting = new AppSetting();
				$appsetting->Id = (int) $row['id'];
				$appsetting->Name = $row['setting_name'];
				$appsetting->Value = (int) $row['setting_value'];
				$appsetting->Desc = $row['setting_desc'];
				array_push($result->Object, $appsetting);
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

			$appsetting = json_decode($data['Object']);
			if ($appsetting == null) {
				throw new Exception(json_get_error());
			}


			$sql = "
			INSERT INTO app_setting 
			(setting_name, setting_value, setting_desc)
			VALUES
			(:setting_name, :setting_value, :setting_desc);";

			$query = $connection->prepare($sql);

			$query->bindParam(':setting_name', $appsetting->Name, PDO::PARAM_STR);
			$query->bindParam(':setting_value', $appsetting->Value, PDO::PARAM_INT);
			$query->bindParam(':setting_desc', $appsetting->Desc, PDO::PARAM_STR);

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

		try {
			if (empty($url->Id)) {
				throw new Exception("Input id is empty.");
			}

			if (!isset($data['Object'])) {
				throw new Exception("Input object is not set.");
			}

			$appsetting = json_decode($data['Object']);
			if ($appsetting == null) {
				throw new Exception(json_get_error());
			}

			$sql = "
			UPDATE app_setting 
			SET 
			setting_name = :setting_name,
			setting_value = :setting_value, 
			setting_desc = :setting_desc
			WHERE
			id = :id;";

			
			$query = $connection->prepare($sql);

			$query->bindParam(':setting_name', $appsetting->Name, PDO::PARAM_STR);
			$query->bindParam(':setting_value', $appsetting->Value, PDO::PARAM_INT);
			$query->bindParam(':setting_desc', $appsetting->Value, PDO::PARAM_STR);
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
	public static function onDelete(Url $url, $data) {
		
		$connection = Flight::dbMain();
		
		try {
			
			if (empty($url->Id)) {
				throw new Exception("Input id is empty");
			}

			$sql = "
			DELETE FROM app_setting 
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