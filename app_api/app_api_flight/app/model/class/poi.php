<?php 
/*
	Created by 		:		Rhalf Wendel D Caacbay
	Created on 		:		20170430

	Modified by 	:		#
	Modified on 	:		#

	functions 		:		Defines the class poi and supplies the requests such as select, insert, update & delete.
*/
class Poi implements IQuery {

	public $id;
	public $company;
	public $name;
	public $desc;
	public $coordinate;
	public $isVisible;
	public $image;

	public function __construct() {
	}

	
	public static function selectAll() {

		$connection = Flight::dbMain();

		try {

			$sql = "SELECT * FROM poi;";
			$query = $connection->prepare($sql);

			$query->execute();

			$rows = $query->fetchAll(PDO::FETCH_ASSOC);

			$result = array();


			foreach ($rows as $row) {	
				$poi = new Poi();
				$poi->id = (int) $row['id'];
				$poi->company = Company::select($row['company_id']);
				$poi->name = $row['poi_name'];
				$poi->desc = $row['poi_desc'];
				$poi->coordinate = new Coordinate($row['poi_latitude'],$row['poi_longitude'], null, null);
				$poi->isVisible = (bool) $row['poi_is_visible'];
				$poi->image = $row['poi_image'];
				
				array_push($result, $poi);
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

			$sql = "SELECT * FROM poi WHERE id = :id;";
			$query = $connection->prepare($sql);
			$query->bindParam(':id',$id, PDO::PARAM_INT);

			$query->execute();

			if ($query->rowCount() < 1){
				return null;
			}

			$row = $query->fetch(PDO::FETCH_ASSOC);

			$poi = new Poi();
			$poi->id = (int) $row['id'];
			$poi->company = Company::select($row['company_id']);
			$poi->name = $row['poi_name'];
			$poi->desc = $row['poi_desc'];
			$poi->coordinate = new Coordinate($row['poi_latitude'],$row['poi_longitude']);
			$poi->isVisible = (bool) $row['poi_is_visible'];
			$poi->image = $row['poi_image'];

			return $poi;

		} catch (PDOException $pdoException) {
			throw $pdoException;
		} catch (Exception $exception) {
			throw $exception;
		} finally {
			$connection = null;
		}
	}

	public static function selectByCompany($id) {

		$connection = Flight::dbMain();

		try {

			$sql = "SELECT * FROM poi WHERE company_id = :company_id;";
			$query = $connection->prepare($sql);
			$query->bindParam(':company_id',$id, PDO::PARAM_INT);

			$query->execute();

			$rows = $query->fetchAll(PDO::FETCH_ASSOC);

			$result = array();


			foreach ($rows as $row) {	
				$poi = new Poi();
				$poi->id = (int) $row['id'];
				$poi->company = Company::select($row['company_id']);
				$poi->name = $row['poi_name'];
				$poi->desc = $row['poi_desc'];
				$poi->coordinate = new Coordinate($row['poi_latitude'],$row['poi_longitude'], null, null);
				$poi->isVisible = (bool) $row['poi_is_visible'];
				$poi->image = $row['poi_image'];
				
				array_push($result, $poi);
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

	public static function insert() {

		$connection = Flight::dbMain();

		try {

			$poi = json_decode(file_get_contents("php://input"));

			if ($poi == null) {
				throw new Exception(json_get_error());
			}

			$sql = "
			INSERT INTO poi 
			(company_id, poi_name,poi_desc,poi_latitude,poi_longitude,poi_is_visible,poi_image)
			VALUES
			(:company_id, :poi_name, :poi_desc, :poi_latitude, :poi_longitude, :poi_is_visible, :poi_image);";


			$query = $connection->prepare($sql);

			$query->bindParam(':company_id', $poi->company->id, PDO::PARAM_INT);
			$query->bindParam(':poi_name', $poi->name, PDO::PARAM_STR);
			$query->bindParam(':poi_desc', $poi->desc, PDO::PARAM_STR);
			$query->bindParam(':poi_latitude', $poi->coordinate->latitude, PDO::PARAM_INT);
			$query->bindParam(':poi_longitude', $poi->coordinate->longitude, PDO::PARAM_INT);
			$query->bindParam(':poi_is_visible', $poi->isVisible, PDO::PARAM_BOOL);
			$query->bindParam(':poi_image', $poi->image, PDO::PARAM_STR);


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

		try {

			$poi = json_decode(file_get_contents("php://input"));

			if ($poi == null) {
				throw new Exception(json_get_error());
			}

			$sql = "
			UPDATE poi 
			SET 
			company_id = :company_id,
			poi_name = :poi_name,
			poi_desc = :poi_desc,
			poi_latitude = :poi_latitude,
			poi_longitude = :poi_longitude,
			poi_is_visible = :poi_is_visible,
			poi_image = :poi_image

			WHERE
			id = :id;";

			$query = $connection->prepare($sql);

			$query->bindParam(':company_id', $poi->company->id, PDO::PARAM_INT);
			$query->bindParam(':poi_name', $poi->name, PDO::PARAM_STR);
			$query->bindParam(':poi_desc', $poi->desc, PDO::PARAM_STR);
			$query->bindParam(':poi_latitude', $poi->coordinate->latitude, PDO::PARAM_INT);
			$query->bindParam(':poi_longitude', $poi->coordinate->longitude, PDO::PARAM_INT);
			$query->bindParam(':poi_is_visible', $poi->isVisible, PDO::PARAM_BOOL);
			$query->bindParam(':poi_image', $poi->image, PDO::PARAM_STR);


			$query->bindParam(':id', $id, PDO::PARAM_INT);

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
			DELETE FROM poi 
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