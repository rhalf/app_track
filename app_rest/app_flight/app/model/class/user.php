<?php 

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

	public static function selectAll() {

		$connection = Flight::dbMain();

		try {
			$sql = "SELECT * FROM user;";
			$query = $connection->prepare($sql);
			
			$query->execute();

			$rows = $query->fetchAll(PDO::FETCH_ASSOC);

			$result = array();

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
				$user->Info = (int) $row['user_info_id'];

				array_push($result, $user);
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
			$sql = "SELECT * FROM user WHERE id = :id;";
			$query = $connection->prepare($sql);
			$query->bindParam(':id',$id, PDO::PARAM_INT);

			$query->execute();

			if ($query->rowCount() < 1){
				Flight::notFound("id not found");
			}

			$row = $query->fetch(PDO::FETCH_ASSOC);

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
			$user->Info = (int) $row['user_info_id'];

			Flight::ok($user);

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

			$user = json_decode(file_get_contents("php://input"));

			if ($user == null) {
				throw new Exception(json_get_error());
			}

			$sql = "
			INSERT INTO user 
			(user_name, user_password, user_hash, user_dt_created, user_dt_expired, user_dt_login, user_dt_active, e_privilege_id, e_status_id, company_id, user_info_id)
			VALUES
			(:user_name, :user_password, :user_hash, :user_dt_created, :user_dt_expired, :user_dt_login, :user_dt_active, :e_privilege_id, :e_status_id, :company_id, :user_info_id);";


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
			$query->bindParam(':user_info_id', $user->Info, PDO::PARAM_INT);

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

			$user = json_decode(file_get_contents("php://input"));

			if ($user == null) {
				throw new Exception(json_get_error());
			}


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
			user_info_id = :user_info_id
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
			$query->bindParam(':user_info_id', $user->Info, PDO::PARAM_INT);

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
			DELETE FROM user 
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