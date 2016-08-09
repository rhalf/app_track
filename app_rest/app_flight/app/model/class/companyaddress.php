<?php 

class CompanyAddress implements IQuery {

	public $Id;
	public $Name;
	public $Full;
	public $Coordinate;
	public $Country;
	public $City;
	public $Area;
	public $Nation;

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
				$address->Id = (int) $row['id'];
				$address->Name = $row['address_name'];
				$address->Full = $row['address_full'];
				$address->Coordinate = new Coordinate((double)$row['address_latitude'],(double)$row['address_longitude']);
				$address->Country = $row['address_country'];
				$address->City = $row['address_city'];
				$address->Area = $row['address_area'];
				$address->Nation = Nation::select($row['e_nation_id']);

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
			$address->Id = (int) $row['id'];
			$address->Name = $row['address_name'];
			$address->Full = $row['address_full'];
			$address->Coordinate = new Coordinate((double)$row['address_latitude'],(double)$row['address_longitude']);
			$address->Country = $row['address_country'];
			$address->City = $row['address_city'];
			$address->Area = $row['address_area'];
			$address->Nation = Nation::select($row['e_nation_id']);
			

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

			$query->bindParam(':address_name', $address->Name, PDO::PARAM_STR);
			$query->bindParam(':address_full', $address->Full, PDO::PARAM_STR);
			$query->bindParam(':address_latitude', $address->Coordinate->Latitude, PDO::PARAM_STR);
			$query->bindParam(':address_longitude', $address->Coordinate->Longitude, PDO::PARAM_STR);
			$query->bindParam(':address_country', $address->Country, PDO::PARAM_STR);
			$query->bindParam(':address_city', $address->City, PDO::PARAM_STR);
			$query->bindParam(':address_area', $address->Area, PDO::PARAM_STR);
			$query->bindParam(':e_nation_id', $address->Nation->Id, PDO::PARAM_INT);


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

			$query->bindParam(':address_name', $address->Name, PDO::PARAM_STR);
			$query->bindParam(':address_full', $address->Full, PDO::PARAM_STR);
			$query->bindParam(':address_latitude', $address->Coordinate->Latitude, PDO::PARAM_STR);
			$query->bindParam(':address_longitude', $address->Coordinate->Longitude, PDO::PARAM_STR);
			$query->bindParam(':address_country', $address->Country, PDO::PARAM_STR);
			$query->bindParam(':address_city', $address->City, PDO::PARAM_STR);
			$query->bindParam(':address_area', $address->Area, PDO::PARAM_STR);
			$query->bindParam(':e_nation_id', $address->Nation->Id, PDO::PARAM_INT);

			$query->bindParam(':id', $id, PDO::PARAM_INT);

			$query->execute();

			$result = new Result();
			$result->Status = Result::UPDATED;
			$result->Id = $id;
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