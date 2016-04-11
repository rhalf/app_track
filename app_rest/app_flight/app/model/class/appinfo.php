<?php 

class AppInfo implements IQuery {

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
				$sql = "SELECT * FROM app_info WHERE id = :id;";
				$query = $connection->prepare($sql);
				$query->bindParam(':id',$url->Id, PDO::PARAM_INT);
			} else if (isset($data['info_name'])) {
				$sql = "SELECT * FROM app_info WHERE info_name LIKE :info_name;";
				$query = $connection->prepare($sql);
				$query->bindParam(':info_name',$data['info_name'], PDO::PARAM_STR);
			} else {
				$sql = "SELECT * FROM app_info;";
				$query = $connection->prepare($sql);
			}
			$query->execute();
			$result = new Result();
			$result->Item = $query->rowCount();
			$result->Object = array();

			$rows = $query->fetchAll(PDO::FETCH_ASSOC);
			foreach ($rows as $row) {	
				$appinfo = new AppInfo();
				$appinfo->Id = (int) $row['id'];
				$appinfo->Name = $row['info_name'];
				$appinfo->Value =(int)  $row['info_value'];
				$appinfo->Desc = $row['info_desc'];
				array_push($result->Object, $appinfo);
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

			$appinfo = json_decode($data['Object']);
			if ($appinfo == null) {
				throw new Exception(json_get_error());
			}


			$sql = "
			INSERT INTO app_info 
			(info_name, info_value,info_desc)
			VALUES
			(:info_name, :info_value, :info_desc);";

			$query = $connection->prepare($sql);

			$query->bindParam(':info_name', $appinfo->Name, PDO::PARAM_STR);
			$query->bindParam(':info_value', $appinfo->Value, PDO::PARAM_INT);
			$query->bindParam(':info_desc', $appinfo->Desc, PDO::PARAM_STR);


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

			$appinfo = json_decode($data['Object']);
			if ($appinfo == null) {
				throw new Exception(json_get_error());
			}

			$sql = "
			UPDATE app_info 
			SET 
			info_name = :info_name,
			info_value = :info_value,
			info_desc = :info_desc 
			WHERE
			id = :id;";

			
			$query = $connection->prepare($sql);

			$query->bindParam(':info_name', $appinfo->Name, PDO::PARAM_STR);
			$query->bindParam(':info_value', $appinfo->Value, PDO::PARAM_INT);
			$query->bindParam(':info_desc', $appinfo->Desc, PDO::PARAM_STR);
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
			DELETE FROM app_info 
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