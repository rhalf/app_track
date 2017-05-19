<?php 
/*
	Created by 		:		Rhalf Wendel D Caacbay
	Created on 		:		20170430

	Modified by 	:		#
	Modified on 	:		#

	functions 		:		Defines the class address and supplies the requests such as select, insert, update & delete.
*/
class Address implements IQuery {

	public $id;
	public $name;
	public $full;
	public $coordinate;
	public $country;
	public $city;
	public $area;
	public $nation;

	public function __construct() {
	}


	public static function selectAll() {

		$connection = Flight::dbMain();

		try {
			$sql = "SELECT * FROM company_address;";
			$query = $connection->prepare($sql);
			
			$query->execute();

			$rows = $query->fetchAll(PDO::FETCH_ASSOC);

			$result = array();

			foreach ($rows as $row) {	
				$address = new Address();
				$address->id = (int) $row['id'];
				$address->name = $row['address_name'];
				$address->full = $row['address_full'];
				$address->coordinate = new Coordinate(
					(double)$row['address_latitude'],
					(double)$row['address_longitude'],
					0,
					0
				);
				$address->country = $row['address_country'];
				$address->city = $row['address_city'];
				$address->area = $row['address_area'];
				$address->nation = Nation::select($row['e_nation_id']);

				array_push($result, $address);
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
			$sql = "SELECT * FROM company_address WHERE id = :id;";
			$query = $connection->prepare($sql);
			$query->bindParam(':id',$id, PDO::PARAM_INT);
			
			$query->execute();

			if ($query->rowCount() < 1){
				return null;
			}

			$row = $query->fetch(PDO::FETCH_ASSOC);

			$address = new Address();
			$address->id = (int) $row['id'];
			$address->name = $row['address_name'];
			$address->full = $row['address_full'];
					$address->coordinate = new Coordinate(
					(double)$row['address_latitude'],
					(double)$row['address_longitude'],
					0,
					0
				);
			$address->country = $row['address_country'];
			$address->city = $row['address_city'];
			$address->area = $row['address_area'];
			$address->nation = Nation::select($row['e_nation_id']);
			

			return $address;

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

			$address = json_decode(file_get_contents("php://input"));

			if ($address == null) {
				throw new Exception(json_get_error());
			}


			$sql = "
			INSERT INTO company_address 
			(address_name, address_full, address_latitude, address_longitude, address_country, address_city, address_area, e_nation_id)
			VALUES
			(:address_name, :address_full, :address_latitude, :address_longitude, :address_country, :address_city, :address_area, :e_nation_id);";


			$query = $connection->prepare($sql);

			$query->bindParam(':address_name', $address->name, PDO::PARAM_STR);
			$query->bindParam(':address_full', $address->full, PDO::PARAM_STR);
			$query->bindParam(':address_latitude', $address->coordinate->Latitude, PDO::PARAM_STR);
			$query->bindParam(':address_longitude', $address->coordinate->Longitude, PDO::PARAM_STR);
			$query->bindParam(':address_country', $address->country, PDO::PARAM_STR);
			$query->bindParam(':address_city', $address->city, PDO::PARAM_STR);
			$query->bindParam(':address_area', $address->area, PDO::PARAM_STR);
			$query->bindParam(':e_nation_id', $address->nation->id, PDO::PARAM_INT);


			$query->execute();

			$result = new Result();
			$result->status = Result::INSERTED;
			$result->id = $connection->lastInsertId();
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

			$address = json_decode(file_get_contents("php://input"));

			if ($address == null) {
				throw new Exception(json_get_error());
			}

			$sql = "
			UPDATE company_address 
			SET 
			address_name = :address_name,
			address_full = :address_full, 
			address_latitude = :address_latitude, 
			address_longitude = :address_longitude, 
			address_country = :address_country, 
			address_city = :address_city,
			address_area = :address_area,
			e_nation_id = :e_nation_id

			WHERE
			id = :id;";

			$query = $connection->prepare($sql);

			$query->bindParam(':address_name', $address->name, PDO::PARAM_STR);
			$query->bindParam(':address_full', $address->full, PDO::PARAM_STR);
			$query->bindParam(':address_latitude', $address->coordinate->Latitude, PDO::PARAM_STR);
			$query->bindParam(':address_longitude', $address->coordinate->Longitude, PDO::PARAM_STR);
			$query->bindParam(':address_country', $address->country, PDO::PARAM_STR);
			$query->bindParam(':address_city', $address->city, PDO::PARAM_STR);
			$query->bindParam(':address_area', $address->area, PDO::PARAM_STR);
			$query->bindParam(':e_nation_id', $address->nation->id, PDO::PARAM_INT);

			$query->bindParam(':id', $id, PDO::PARAM_INT);

			$query->execute();

			$result = new Result();
			$result->status = Result::UPDATED;
			$result->id = $id;
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
	public static function delete($id) {

		$connection = Flight::dbMain();

		try {

			$sql = "
			DELETE FROM company_address 
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