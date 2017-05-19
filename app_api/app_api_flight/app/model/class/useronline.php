<?php 
/*
	Created by 		:		Rhalf Wendel D Caacbay
	Created on 		:		20170430

	Modified by 	:		#
	Modified on 	:		#

	functions 		:		Defines the class userOnline and supplies the requests such as select, insert, update & delete.
*/
class UserOnline implements IQuery {

	public $id;
	public $user;
	public $dt;
	public $ip;

	
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
				$userOnline->id = (int) $row['id'];
				$userOnline->user = User::select($row['user_id']);
				$userOnline->dt = $row['online_dt'];
				$userOnline->ip = $row['online_ip'];

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
			$userOnline->id = (int) $row['id'];
			$userOnline->user = User::select($row['user_id']);
			$userOnline->dt = $row['online_dt'];
			$userOnline->ip = $row['online_ip'];

			return $userOnline;

		} catch (PDOException $pdoException) {
			throw $pdoException;
		} catch (Exception $exception) {
			throw $exception;
		} finally {
			$connection = null;
		}
	}

	public static function selectByTime($time) {

		$connection = Flight::dbMain();
		
		// $dateTime = new DateTime();
		// $dt = $dateTime->sub(new DateInterval('P0DT0H5M0S'))->format('Y-m-d H:i:s');

		try {

			// $sql = "SELECT * FROM user_online WHERE online_dt > :online_dt;";
			$sql = "SELECT * FROM user_online ORDER BY online_dt DESC LIMIT 100;";
			$query = $connection->prepare($sql);
			// $query->bindParam(':online_dt',$dt, PDO::PARAM_STR);
			
			$query->execute();

			$rows = $query->fetchAll(PDO::FETCH_ASSOC);

			$result = array();

			foreach ($rows as $row) {	
				$userOnline = new UserOnline();
				$userOnline->id = (int) $row['id'];
				$userOnline->user = User::select($row['user_id']);
				$userOnline->dt = $row['online_dt'];
				$userOnline->ip = $row['online_ip'];

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


	public static function selectByUser($id) {

		$connection = Flight::dbMain();

		try {
			
			$sql = "SELECT * FROM user_online WHERE user_id = :user_id;";
			$query = $connection->prepare($sql);
			$query->bindParam(':user_id',$id, PDO::PARAM_INT);

			$query->execute();

			if ($query->rowCount() < 1){
				return null;
			}

			$row = $query->fetch(PDO::FETCH_ASSOC);

			$userOnline = new UserOnline();
			$userOnline->id = (int) $row['id'];
			$userOnline->user = User::select($row['user_id']);
			$userOnline->dt = $row['online_dt'];
			$userOnline->ip = $row['online_ip'];

			return $userOnline;

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
		$dateTime = Flight::dateTime();

		try {

			$userOnline = json_decode(file_get_contents("php://input"));

			if ($userOnline == null) {
				throw new Exception(json_get_error());
			}

			$sql = "
			INSERT INTO user_online 
			(user_id, online_dt, online_ip)
			VALUES
			(:user_id, :online_dt, :online_ip);";


			$query = $connection->prepare($sql);


			$query->bindParam(':user_id', $userOnline->user->id, PDO::PARAM_INT);
			$query->bindParam(':online_dt', $dateTime, PDO::PARAM_STR);

			$ip = getRemoteIp();
			$query->bindParam(':online_ip',$ip  , PDO::PARAM_STR);



			$query->execute();
			
			$result = new Result();
			$result->status = Result::INSERTED;
			$result->id = $connection->lastInsertid();
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
		$dateTime = Flight::dateTime();
		

		try {

			$userOnline = json_decode(file_get_contents("php://input"));

			if ($userOnline == null) {
				throw new Exception(json_get_error());
			}


			$sql = "
			UPDATE user_online 

			SET 
			user_id = :user_id,
			online_dt = :online_dt,
			online_ip = :online_ip


			WHERE
			id = :id;";


			$query = $connection->prepare($sql);
			$query->bindParam(':user_id', $userOnline->user->id, PDO::PARAM_INT);
			$query->bindParam(':online_dt', $dateTime, PDO::PARAM_STR);

			$ip = getRemoteIp();
			$query->bindParam(':online_ip',$ip  , PDO::PARAM_STR);
			$query->bindParam(':id',$id  , PDO::PARAM_STR);


			$query->execute();
			

			$result = new Result();
			$result->status = Result::UPDATED;
			$result->id = $id;
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
			
			DELETE FROM user_online

			WHERE
			id = :id";

			$query = $connection->prepare($sql);

			$query->bindParam(':id', $id, PDO::PARAM_INT);

			$query->execute();

			$result = new Result();
			$result->status = Result::DELETED;
			$result->message = 'Done';
			$result->id = $id;

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