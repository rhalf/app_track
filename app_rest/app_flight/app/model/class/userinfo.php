<?php 

class UserInfo implements IQuery {

	public $Id;
	public $DtCreated;
	public $Email;
	public $Website;
	public $Telephone;
	public $UserSim;
	public $Address;


	
	public function __construct() {
	}

	public static function onSelect(Url $url, $data) {
		
		$connection = Flight::dbMain();

		try {

			if (!empty($url->Id)) {
				$sql = "SELECT * FROM user_info WHERE id = :id;";
				$query = $connection->prepare($sql);
				$query->bindParam(':id',$url->Id, PDO::PARAM_INT);
			// } else if (isset($data['name'])) {
			// 	$sql = "SELECT * FROM user_info WHERE field_name LIKE :name;";
			// 	$query = $connection->prepare($sql);
			// 	$query->bindParam(':name',$data['name'], PDO::PARAM_STR);
			} else {
				$sql = "SELECT * FROM user_info;";
				$query = $connection->prepare($sql);
			}

			$query->execute();

			$result = new Result();
			$result->Item = $query->rowCount();
			$result->Object = array();

			$rows = $query->fetchAll(PDO::FETCH_ASSOC);

			foreach ($rows as $row) {	
				$userInfo = new UserInfo();
				$userInfo->Id = (int) $row['id'];
				$userInfo->DtCreated = $row['info_dt_created'];
				$userInfo->Email = $row['info_email'];
				$userInfo->Website = $row['info_website'];
				$userInfo->Telephone = $row['info_telephone'];
				$userInfo->UserSim = (int)$row['sim_id'];
				$userInfo->Address = (int)$row['address_id'];

				array_push($result->Object, $userInfo);
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

			$userInfo = json_decode($data['Object']);
			if ($userInfo == null) {
				throw new Exception(json_get_error());
			}

			$sql = "
			INSERT INTO user_info 
			(info_dt_created, info_email, info_website, info_telephone, sim_id, address_id)
			VALUES
			(:info_dt_created, :info_email, :info_website, :info_telephone, :sim_id, :address_id);";


			$query = $connection->prepare($sql);

			$query->bindParam(':info_dt_created', $userInfo->DtCreated, PDO::PARAM_STR);
			$query->bindParam(':info_email', $userInfo->Email, PDO::PARAM_STR);
			$query->bindParam(':info_website', $userInfo->Website, PDO::PARAM_STR);
			$query->bindParam(':info_telephone', $userInfo->Telephone, PDO::PARAM_STR);
			$query->bindParam(':sim_id', $userInfo->UserSim, PDO::PARAM_INT);
			$query->bindParam(':address_id', $userInfo->Address, PDO::PARAM_INT);


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

			$userInfo = json_decode($data['Object']);
			if ($userInfo == null) {
				throw new Exception(json_get_error());
			}
			
			$sql = "
			UPDATE user_info 
			SET 
			info_dt_created = :info_dt_created,
			info_email = :info_email,
			info_website = :info_website,
			info_telephone = :info_telephone,
			sim_id = :sim_id,
			address_id = :address_id

			WHERE
			id = :id;";

			$query = $connection->prepare($sql);

			$query->bindParam(':info_dt_created', $userInfo->DtCreated, PDO::PARAM_STR);
			$query->bindParam(':info_email', $userInfo->Email, PDO::PARAM_STR);
			$query->bindParam(':info_website', $userInfo->Website, PDO::PARAM_STR);
			$query->bindParam(':info_telephone', $userInfo->Telephone, PDO::PARAM_STR);
			$query->bindParam(':sim_id', $userInfo->UserSim, PDO::PARAM_INT);
			$query->bindParam(':address_id', $userInfo->Address, PDO::PARAM_INT);


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
			DELETE FROM user_info 
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