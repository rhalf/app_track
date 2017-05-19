<?php 
/*
	Created by 		:		Rhalf Wendel D Caacbay
	Created on 		:		20170430

	Modified by 	:		#
	Modified on 	:		#

	functions 		:		Defines the class appInfo and supplies the requests such as select, insert, update & delete.
*/
class AppInfo implements IQuery {

	public $id;
	public $name;
	public $value;
	public $desc;

	public function __construct() {
	}

	public static function selectAll() {
		
		$connection = Flight::dbMain();

		try {

			$sql = "SELECT * FROM app_info;";
			$query = $connection->prepare($sql);
			
			$query->execute();

			$rows = $query->fetchAll(PDO::FETCH_ASSOC);

			$result = array();

			foreach ($rows as $row) {	
				$appInfo = new AppInfo();
				$appInfo->id = (int) $row['id'];
				$appInfo->name = $row['info_name'];
				$appInfo->value =(int)  $row['info_value'];
				$appInfo->desc = $row['info_desc'];
				
				array_push($result, $appInfo);
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

			$sql = "SELECT * FROM app_info WHERE id = :id;";
			$query = $connection->prepare($sql);
			$query->bindParam(':id',$id, PDO::PARAM_INT);
			
			$query->execute();

			if ($query->rowCount() < 1){
				return null;
			}

			$row = $query->fetch(PDO::FETCH_ASSOC);

			$appInfo = new AppInfo();
			$appInfo->id = (int) $row['id'];
			$appInfo->name = $row['info_name'];
			$appInfo->value =(int)  $row['info_value'];
			$appInfo->desc = $row['info_desc'];

			return $appInfo;

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

			$appInfo = json_decode(file_get_contents("php://input"));

			if ($appInfo == null) {
				throw new Exception(json_get_error());
			}

			$sql = "
			INSERT INTO app_info 
			(info_name, info_value,info_desc)
			VALUES
			(:info_name, :info_value, :info_desc);";

			$query = $connection->prepare($sql);

			$query->bindParam(':info_name', $appInfo->name, PDO::PARAM_STR);
			$query->bindParam(':info_value', $appInfo->value, PDO::PARAM_INT);
			$query->bindParam(':info_desc', $appInfo->desc, PDO::PARAM_STR);

			$query->execute();
			
			$result = new Result();
			$result->Status = Result::INSERTED;
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

		try {

			$appInfo = json_decode(file_get_contents("php://input"));

			if ($appInfo == null) {
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

			$query->bindParam(':info_name', $appInfo->name, PDO::PARAM_STR);
			$query->bindParam(':info_value', $appInfo->value, PDO::PARAM_INT);
			$query->bindParam(':info_desc', $appInfo->desc, PDO::PARAM_STR);

			$query->bindParam(':id', $id, PDO::PARAM_INT);

			$query->execute();

			$result = new Result();
			$result->Status = Result::UPDATED;
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
			DELETE FROM app_info 
			WHERE
			id = :id";

			$query = $connection->prepare($sql);

			$query->bindParam(':id', $id, PDO::PARAM_INT);

			$query->execute();

			$result = new Result();
			$result->Status = Result::DELETED;
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