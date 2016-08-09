<?php 

class UserOnline implements IQuery {

	public $Id;
	public $User;
	public $Dt;

	
	public function __construct() {
	}

	public static function selectAll() {

		$connection = Flight::dbMain();

		try {

			$sql = "SELECT * FROM user_online;";
			$query = $connection->prepare($sql);
			
			$query->execute();

			$rows = $query->fetchAll(PDO::FETCH_ASSOC);

			$result = array();

			foreach ($rows as $row) {	
				$userOnline = new UserOnline();
				$userOnline->Id = (int) $row['id'];
				$userOnline->User = User::select($row['user_id']);
				$userOnline->Dt = $row['online_dt'];

				array_push($result, $userOnline);
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
			
			$sql = "SELECT * FROM user_online WHERE id = :id;";
			$query = $connection->prepare($sql);
			$query->bindParam(':id',$id, PDO::PARAM_INT);

			$query->execute();

			if ($query->rowCount() < 1){
				return null;
			}

			$row = $query->fetch(PDO::FETCH_ASSOC);

			$userOnline = new UserOnline();
			$userOnline->Id = (int) $row['id'];
			$userOnline->User = User::select($row['user_id']);
			$userOnline->Dt = $row['online_dt'];

			return $userOnline;

		} catch (PDOException $pdoException) {
			throw $pdoException;
		} catch (Exception $exception) {
			throw $exception;
		} finally {
			$connection = null;
		}
	}

	public static function selectByUser($id) {

		$connection = Flight::dbMain();

		try {
			
			$sql = "SELECT * FROM user_online WHERE user_id = :user_id;";
			$query = $connection->prepare($sql);
			$query->bindParam(':user_id',$id, PDO::PARAM_INT);

			$query->execute();

			if ($query->rowCount() < 1){
				Flight::notFound("user_id not found");
			}

			$row = $query->fetch(PDO::FETCH_ASSOC);

			$userOnline = new UserOnline();
			$userOnline->Id = (int) $row['id'];
			$userOnline->User = User::select($row['user_id']);
			$userOnline->Dt = $row['online_dt'];

			return $result;

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

			$userOnline = json_decode(file_get_contents("php://input"));

			if ($userOnline == null) {
				throw new Exception(json_get_error());
			}

			$sql = "
			INSERT INTO user_online 
			(user_id, online_dt)
			VALUES
			(:user_id, :online_dt);";


			$query = $connection->prepare($sql);

			$query->bindParam(':user_id', $userOnline->User->Id, PDO::PARAM_INT);
			$query->bindParam(':online_dt', $userOnline->Dt, PDO::PARAM_STR);

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

			$userOnline = json_decode(file_get_contents("php://input"));

			if ($userOnline == null) {
				throw new Exception(json_get_error());
			}


			$sql = "
			UPDATE user_online 

			SET 
			user_id = :user_id,
			online_dt = :online_dt

			WHERE
			id = :id;";


			$query = $connection->prepare($sql);

			$query->bindParam(':user_id', $userOnline->User->Id, PDO::PARAM_INT);
			$query->bindParam(':online_dt', $userOnline->Dt, PDO::PARAM_STR);

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
			
			DELETE FROM user_online

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