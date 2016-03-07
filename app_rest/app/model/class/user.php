<?php 

require_once('/app/model/interface/iquery.php');

class User implements IQuery {

	public $Id;
	public $Name;
	public $Password;
	public $Hash;
	public $DtCreated;
	public $DtExpired;
	public $DtLogin;
	public $DtActive;
	public $Privilege;
	public $Status;
	public $Company;
	public $Info;

	
	public function __construct() {
	}

	public static function onSelect(Url $url, $get) {
		$database = Flight::get('database');
		$connection = new PDO("mysql:host=$database->Ip;dbname=$database->Database", $database->Username, $database->Password);
		$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$connection->setAttribute(PDO::ATTR_EMULATE_PREPARES, true);

		try {

			if (!empty($url->Id)) {
				$sql = "SELECT * FROM user WHERE id = :id;";
				$query = $connection->prepare($sql);
				$query->bindParam(':id',$url->Id, PDO::PARAM_INT);
			} else if (isset($get['name'])) {
				$sql = "SELECT * FROM user WHERE user_name LIKE :name;";
				$query = $connection->prepare($sql);
				$query->bindParam(':name',$get['name'], PDO::PARAM_STR);
			} else {
				$sql = "SELECT * FROM user;";
				$query = $connection->prepare($sql);
			}

			$query->execute();

			$result = new Result();
			$result->Item = $query->rowCount();
			$result->Object['user'] = array();

			$rows = $query->fetchAll(PDO::FETCH_ASSOC);

			foreach ($rows as $row) {	
				$user = new User();
				$user->Id = (int) $row['id'];
				$user->Name = $row['user_name'];
				$user->Password = $row['user_password'];
				$user->Hash = $row['user_hash'];
				$user->DtCreated = $row['user_dt_created'];
				$user->DtExpired = $row['user_dt_expired'];
				$user->DtLogin = $row['user_dt_login'];
				$user->DtActive = $row['user_dt_active'];
				$user->Privilege = (int) $row['e_privilege_id'];
				$user->Status = (int) $row['e_status_id'];
				$user->Company = (int) $row['company_id'];
				$user->Info = (int) $row['info_id'];

				array_push($result->Object['user'], $user);
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
			$user = $object->user[0];

			$sql = "
			INSERT INTO user 
			(user_name, user_password, user_hash, user_dt_created, user_dt_expired, user_dt_login, user_dt_active, e_privilege_id, e_status_id, company_id, info_id)
			VALUES
			(:user_name, :user_password, :user_hash, :user_dt_created, :user_dt_expired, :user_dt_login, :user_dt_active, :e_privilege_id, :e_status_id, :company_id, :info_id);";


			$query = $connection->prepare($sql);

			$query->bindParam(':user_name', $user->Name, PDO::PARAM_STR);
			$query->bindParam(':user_password', $user->Password, PDO::PARAM_STR);
			$query->bindParam(':user_hash', $user->Hash, PDO::PARAM_STR);
			$query->bindParam(':user_dt_created', $user->DtCreated, PDO::PARAM_STR);
			$query->bindParam(':user_dt_expired', $user->DtExpired, PDO::PARAM_STR);
			$query->bindParam(':user_dt_login', $user->DtLogin, PDO::PARAM_STR);
			$query->bindParam(':user_dt_active', $user->DtActive, PDO::PARAM_STR);
			$query->bindParam(':e_privilege_id', $user->Privilege, PDO::PARAM_INT);
			$query->bindParam(':e_status_id', $user->Status, PDO::PARAM_INT);
			$query->bindParam(':company_id', $user->Company, PDO::PARAM_INT);
			$query->bindParam(':info_id', $user->Info, PDO::PARAM_INT);

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

		try {
			if (empty($url->Id)) {
				throw new Exception("Input id is empty.");
			}

			if (!isset($put['object'])) {
				throw new Exception("Input object is not set.");
			}

			$object = json_decode($put['object']);
			$user = $object->user[0];

			$sql = "
			UPDATE user 
			SET 
			user_name = :user_name,
			user_password = :user_password, 
			user_hash = :user_hash,
			user_dt_created = :user_dt_created,
			user_dt_expired = :user_dt_expired,
			user_dt_login = :user_dt_login,
			user_dt_active = :user_dt_active,
			e_privilege_id = :e_privilege_id,
			e_status_id = :e_status_id,
			company_id = :company_id,
			info_id = :info_id
			WHERE
			id = :id;";

			
			$query = $connection->prepare($sql);

			$query->bindParam(':user_name', $user->Name, PDO::PARAM_STR);
			$query->bindParam(':user_password', $user->Password, PDO::PARAM_STR);
			$query->bindParam(':user_hash', $user->Hash, PDO::PARAM_STR);
			$query->bindParam(':user_dt_created', $user->DtCreated, PDO::PARAM_STR);
			$query->bindParam(':user_dt_expired', $user->DtExpired, PDO::PARAM_STR);
			$query->bindParam(':user_dt_login', $user->DtLogin, PDO::PARAM_STR);
			$query->bindParam(':user_dt_active', $user->DtActive, PDO::PARAM_STR);
			$query->bindParam(':e_privilege_id', $user->Privilege, PDO::PARAM_INT);
			$query->bindParam(':e_status_id', $user->Status, PDO::PARAM_INT);
			$query->bindParam(':company_id', $user->Company, PDO::PARAM_INT);
			$query->bindParam(':info_id', $user->Info, PDO::PARAM_INT);

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
			DELETE FROM user 
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