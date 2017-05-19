<?php 
/*
	Created by 		:		Rhalf Wendel D Caacbay
	Created on 		:		20170430

	Modified by 	:		#
	Modified on 	:		#

	functions 		:		Defines the class userInfo and supplies the requests such as select, insert, update & delete.
*/
class UserInfo implements IQuery {

	public $id;
	public $email;
	public $telephone;
	public $user;


	
	public function __construct() {
	}

	public static function selectAll() {

		$connection = Flight::dbMain();

		try {

			$sql = "SELECT * FROM user_info;";
			$query = $connection->prepare($sql);

			$query->execute();

			$rows = $query->fetchAll(PDO::FETCH_ASSOC);

			$result = array();

			foreach ($rows as $row) {	
				$userInfo = new UserInfo();
				$userInfo->id = (int) $row['id'];
				$userInfo->email = $row['info_email'];
				$userInfo->telephone = $row['info_telephone'];
				$userInfo->user = User::select($row['user_id']);

				array_push($result, $userInfo);
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
			
			$sql = "SELECT * FROM user_info WHERE id = :id;";
			$query = $connection->prepare($sql);
			$query->bindParam(':id',$id, PDO::PARAM_INT);

			$query->execute();

			if ($query->rowCount() < 1){
				return null;
			}

			$row = $query->fetch(PDO::FETCH_ASSOC);


			$userInfo = new UserInfo();
			$userInfo->id = (int) $row['id'];
			$userInfo->email = $row['info_email'];
			$userInfo->telephone = $row['info_telephone'];
			$userInfo->user = User::select($row['user_id']);
			
			
			return $userInfo;

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
			
			$sql = "SELECT * FROM user_info WHERE user_id = :user_id;";
			$query = $connection->prepare($sql);
			$query->bindParam(':user_id',$id, PDO::PARAM_INT);

			$query->execute();

			if ($query->rowCount() < 1){
				return null;
			}

			$row = $query->fetch(PDO::FETCH_ASSOC);


			$userInfo = new UserInfo();
			$userInfo->id = (int) $row['id'];
			$userInfo->email = $row['info_email'];
			$userInfo->telephone = $row['info_telephone'];
			$userInfo->user = User::select($row['user_id']);
			
			
			return $userInfo;

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

			$userInfo = json_decode(file_get_contents("php://input"));

			if ($userInfo == null) {
				throw new Exception(json_get_error());
			}

			$sql = "
			INSERT INTO user_info 
			(info_email, info_telephone, user_id)
			VALUES
			(:info_email, :info_telephone, :user_id);";

			$query = $connection->prepare($sql);

			$query->bindParam(':info_email', $userInfo->email, PDO::PARAM_STR);
			$query->bindParam(':info_telephone', $userInfo->telephone, PDO::PARAM_STR);
			$query->bindParam(':user_id', $userInfo->user->id, PDO::PARAM_INT);

			$query->execute();

			$result = new Result();
			$result->status = Result::INSERTED;
			$result->id = (int)$connection->lastInsertid();
			$result->message = 'Done';

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

			$userInfo = json_decode(file_get_contents("php://input"));

			if ($userInfo == null) {
				throw new Exception(json_get_error());
			}

			$sql = "
			UPDATE user_info 
			SET 
			info_email = :info_email,
			info_telephone = :info_telephone,
			user_id = :user_id

			WHERE
			id = :id;";

			$query = $connection->prepare($sql);

			$query->bindParam(':info_email', $userInfo->email, PDO::PARAM_STR);
			$query->bindParam(':info_telephone', $userInfo->telephone, PDO::PARAM_STR);
			$query->bindParam(':user_id', $userInfo->user->id, PDO::PARAM_INT);


			$query->bindParam(':id', $id, PDO::PARAM_INT);

			$query->execute();

			$result = new Result();
			$result->status = Result::UPDATED;
			$result->id = (int)$id;
			$result->message = 'Done.';

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
			DELETE FROM user_info 
			WHERE
			id = :id";

			$query = $connection->prepare($sql);

			$query->bindParam(':id', $id, PDO::PARAM_INT);

			$query->execute();

			$result = new Result();
			$result->status = Result::DELETED;
			$result->message = 'Done';
			$result->id = (int)$id;

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