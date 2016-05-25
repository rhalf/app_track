<?php 

class User implements IQuery {

	public $Id;
	public $Name;
	public $Password;
	public $Hash;
	public $DtCreated;
	public $DtExpired;
	public $Privilege;
	public $Status;
	public $Company;

	
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
				$user->DtCreated = $row['user_dt_created'];
				$user->DtExpired = $row['user_dt_expired'];
				$user->Privilege = (int) $row['e_privilege_value'];
				$user->Status = (int) $row['e_status_value'];
				$user->Company = (int) $row['company_id'];

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
			$user->DtCreated = $row['user_dt_created'];
			$user->DtExpired = $row['user_dt_expired'];
			$user->Privilege = (int) $row['e_privilege_value'];
			$user->Status = (int) $row['e_status_value'];
			$user->Company = (int) $row['company_id'];

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
			(user_name, user_dt_created, user_dt_expired, e_privilege_value, e_status_value, company_id)
			VALUES
			(:user_name, :user_dt_created, :user_dt_expired, :e_privilege_value, :e_status_value, :company_id);";


			$query = $connection->prepare($sql);

			$query->bindParam(':user_name', $user->Name, PDO::PARAM_STR);
			$query->bindParam(':user_dt_created', $user->DtCreated, PDO::PARAM_STR);
			$query->bindParam(':user_dt_expired', $user->DtExpired, PDO::PARAM_STR);
			$query->bindParam(':e_privilege_value', $user->Privilege, PDO::PARAM_INT);
			$query->bindParam(':e_status_value', $user->Status, PDO::PARAM_INT);
			$query->bindParam(':company_id', $user->Company, PDO::PARAM_INT);

			$query->execute();
			
			$result = new Result();
			$result->Status = Result::INSERTED;
			$result->Id = (int)$connection->lastInsertId();
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
			user_dt_created = :user_dt_created,
			user_dt_expired = :user_dt_expired,
			e_privilege_value = :e_privilege_value,
			e_status_value = :e_status_value,
			company_id = :company_id
			WHERE
			id = :id;";


			$query = $connection->prepare($sql);

			$query->bindParam(':user_name', $user->Name, PDO::PARAM_STR);
			$query->bindParam(':user_dt_created', $user->DtCreated, PDO::PARAM_STR);
			$query->bindParam(':user_dt_expired', $user->DtExpired, PDO::PARAM_STR);
			$query->bindParam(':e_privilege_value', $user->Privilege, PDO::PARAM_INT);
			$query->bindParam(':e_status_value', $user->Status, PDO::PARAM_INT);
			$query->bindParam(':company_id', $user->Company, PDO::PARAM_INT);

			$query->bindParam(':id', $id, PDO::PARAM_INT);

			$query->execute();

			$result = new Result();
			$result->Status = Result::UPDATED;
			$result->Id = (int)$id;
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
	
	public static function updateCredential($id) {

		$connection = Flight::dbMain();

		try {

			$user = json_decode(file_get_contents("php://input"));

			if ($user == null) {
				throw new Exception(json_get_error());
			}


			$sql = "
			UPDATE user 
			SET 

			user_password = :user_password

			WHERE
			id = :id;";


			$query = $connection->prepare($sql);

			$password = hash('sha256', $user->Password);
			$query->bindParam(':user_password', $password, PDO::PARAM_STR);

			$query->bindParam(':id', $id, PDO::PARAM_INT);

			$query->execute();

			$result = new Result();
			$result->Status = Result::UPDATED;
			$result->Id = (int)$id;
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
			$result->Id = (int)$id;

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