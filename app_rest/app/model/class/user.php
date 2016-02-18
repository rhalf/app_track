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

	public function __construct() {
	}

	public static function onSelect($get){
		$database = Flight::get('database');
		$connection = new PDO("mysql:host=$database->Ip;dbname=$database->Database", $database->Username, $database->Password);
		$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$connection->setAttribute(PDO::ATTR_EMULATE_PREPARES, true);

		$array['result'] = array();
		$array['user'] = array();


		try {
			if (isset($get['id'])) {
				$sql = "SELECT * FROM user WHERE id = :id;";
			} else {
				$sql = "SELECT * FROM user;";
			}
			

			$query = $connection->prepare($sql);
			$query->bindParam(':id', $get['id'], PDO::PARAM_INT);

			$query->execute();

			$rows = $query->fetchAll(PDO::FETCH_ASSOC);

			if (!$rows) {
				throw new PDOException( "Object with id " . $get['id'] ." doesn't exist.", '02000');
			}

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

				array_push($array['user'], $user);
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
	public static function onInsert($post){
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

			$user = $object->user[0];

			$sql = "
			INSERT INTO user 
			(user_name, user_password, user_hash, user_dt_created, user_dt_expired, user_dt_login, user_dt_active, e_privilege_id, e_status_id, company_id)
			VALUES
			(:user_name, :user_password, :user_hash, :user_dt_created, :user_dt_expired, :user_dt_login, :user_dt_active, :e_privilege_id, :e_status_id, :company_id);";


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
	public static function onUpdate($put){
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
			company_id = :company_id
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
			$query->bindParam(':e_privilege_id', $user->Privilege , PDO::PARAM_INT);
			$query->bindParam(':e_status_id', $user->Status, PDO::PARAM_INT);
			$query->bindParam(':company_id', $user->Company, PDO::PARAM_INT);

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

	public static function onDelete($delete){
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
			DELETE FROM user 
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