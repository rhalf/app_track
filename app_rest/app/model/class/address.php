<?php 

class Address implements IQuery {

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

	public static function onSelect(Url $url, $data) {
		$database = Flight::get('database');
		$connection = new PDO("mysql:host=$database->Ip;dbname=$database->Database", $database->Username, $database->Password);
		$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$connection->setAttribute(PDO::ATTR_EMULATE_PREPARES, true);

		try {
			if (!empty($url->Id)) {
				$sql = "SELECT * FROM address WHERE id = :id;";
				$query = $connection->prepare($sql);
				$query->bindParam(':id',$url->Id, PDO::PARAM_INT);
			} else if (isset($data['name'])) {
				$sql = "SELECT * FROM address WHERE address_name LIKE :name;";
				$query = $connection->prepare($sql);
				$query->bindParam(':name',$data['name'], PDO::PARAM_STR);
			} else {
				$sql = "SELECT * FROM address;";
				$query = $connection->prepare($sql);
			}

			$query->execute();

			$result = new Result();
			$result->Item = $query->rowCount();
			$result->Object = array();

			$rows = $query->fetchAll(PDO::FETCH_ASSOC);


			foreach ($rows as $row) {	
				$address = new Address();
				$address->Id = (int) $row['id'];
				$address->Name = $row['address_name'];
				$address->Full = $row['address_full'];
				$address->Coordinate = new Coordinate((double)$row['address_latitude'],(double)$row['address_longitude']);
				$address->Country = $row['address_country'];
				$address->City = $row['address_city'];
				$address->Area = $row['address_area'];
				$address->Nation = (int)$row['e_nation_id'];

				array_push($result->Object, $address);
			}

			$result->Status = Result::SUCCESS;
			$result->Message = 'Done.';

		} catch (PDOException $pdoException) {
			$result = new Result();
			$result->Status = Result::ERROR;
			$result->Message = $pdoException->getMessage();
		} catch (Exception $exception) {
			$result = new Result();
			$result->Status = Result::ERROR;
			$result->Message = $exception->getMessage();
		}

		$connection = null;

		return $result;
	}
	public static function onInsert(Url $url, $data) {
		$database = Flight::get('database');
		$connection = new PDO("mysql:host=$database->Ip;dbname=$database->Database", $database->Username, $database->Password);
		$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$connection->setAttribute(PDO::ATTR_EMULATE_PREPARES, true);

		try {

			if(!isset($data['Object'])) {
				throw new Exception("Input object is null", 1);
			}

			$address = json_decode($data['Object']);
			if ($address == null) {
				throw new Exception(json_get_error());
			}

			$sql = "
			INSERT INTO address 
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
			$query->bindParam(':e_nation_id', $address->Nation, PDO::PARAM_INT);


			$query->execute();
			
			$result = new Result();
			$result->Status = Result::SUCCESS;
			$result->Item = $query->rowCount();
			$result->Message = 'Done.';

		} catch (PDOException $pdoException) {
			$result = new Result();
			$result->Status = Result::ERROR;
			$result->Message = $pdoException->getMessage();
		} catch (Exception $exception) {
			$result = new Result();
			$result->Status = Result::ERROR;
			$result->Message = $exception->getMessage();
		}

		$connection = null;

		return $result;
	}
	public static function onUpdate(Url $url, $data) {
		$database = Flight::get('database');

		$connection = new PDO("mysql:host=$database->Ip;dbname=$database->Database", $database->Username, $database->Password);
		$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$connection->setAttribute(PDO::ATTR_EMULATE_PREPARES, true);

		//$connection->beginTransaction();

		try {
			if (empty($url->Id)) {
				throw new Exception("Input id is empty.", 1);
			}

			if (!isset($data['Object'])) {
				throw new Exception("Input object is not set.");
			}

			$address = json_decode($data['Object']);
			if ($address == null) {
				throw new Exception(json_get_error());
			}

			$sql = "
			UPDATE address 
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
			$query->bindParam(':e_nation_id', $address->Nation, PDO::PARAM_INT);

			$query->bindParam(':id', $url->Id, PDO::PARAM_INT);

			$query->execute();

			$result = new Result();
			$result->Status = Result::SUCCESS;
			$result->Item = $query->rowCount();
			$result->Message = 'Done.';

		} catch (PDOException $pdoException) {
			$result = new Result();
			$result->Status = Result::ERROR;
			$result->Message = $pdoException->getMessage();
		} catch (Exception $exception) {
			$result = new Result();
			$result->Status = Result::ERROR;
			$result->Message = $exception->getMessage();
		}

		$connection = null;
		return $result;
	}
	public static function onDelete(Url $url, $data) {
		$database = Flight::get('database');

		$connection = new PDO("mysql:host=$database->Ip;dbname=$database->Database", $database->Username, $database->Password);
		$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$connection->setAttribute(PDO::ATTR_EMULATE_PREPARES, true);
		
		try {
			
			if (empty($url->Id)) {
				throw new Exception("Input id is empty", 1);
			}

			$sql = "
			DELETE FROM address 
			WHERE
			id = :id";

			$query = $connection->prepare($sql);

			$query->bindParam(':id', $url->Id, PDO::PARAM_INT);

			$query->execute();

			$result = new Result();
			$result->Status = Result::SUCCESS;
			$result->Item = $query->rowCount();
			$result->Message = 'Done.';

		} catch (PDOException $pdoException) {
			$result = new Result();
			$result->Status = Result::ERROR;
			$result->Message = $pdoException->getMessage();
		} catch (Exception $exception) {
			$result = new Result();
			$result->Status = Result::ERROR;
			$result->Message = $exception->getMessage();
		}

		$connection = null;
		return $result;
	}
}

?>