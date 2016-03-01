<?php 

require_once('/app/model/interface/iquery.php');
require_once('/app/model/class/coordinate.php');

class Address implements IQuery {

	public $Id;
	public $Name;
	public $Full;
	public $Coordinate;
	public $Country;
	public $City;
	public $Area;

	public function __construct() {
	}

	public static function onSelect($get) {
		$database = Flight::get('database');
		$connection = new PDO("mysql:host=$database->Ip;dbname=$database->Database", $database->Username, $database->Password);
		$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$connection->setAttribute(PDO::ATTR_EMULATE_PREPARES, true);

		$array['result'] = array();
		$array['address'] = array();


		try {
			if (isset($get['id'])) {
				$sql = "SELECT * FROM address WHERE id = :id;";
			} else {
				$sql = "SELECT * FROM address;";
			}
			

			$query = $connection->prepare($sql);
			$query->bindParam(':id', $get['id'], PDO::PARAM_INT);

			$query->execute();

			$rows = $query->fetchAll(PDO::FETCH_ASSOC);

			if (!$rows) {
				throw new PDOException( "Object with id " . $get['id'] ." doesn't exist.", '02000');
			}

			foreach ($rows as $row) {	
				$address = new Address();
				$address->Id = (int) $row['id'];
				$address->Name = $row['address_name'];
				$address->Full = $row['address_full'];
				$address->Coordinate = new Coordinate((double)$row['address_latitude'],(double)$row['address_longitude'],(double)$row['address_altitude']);
				$address->Country = $row['address_country'];
				$address->City = $row['address_city'];
				$address->Area = $row['address_area'];

				array_push($array['address'], $address);
			}

			$result = new Result(0, RESULT::PDO, "Success");
			$array['result'] = $result;

		} catch (PDOException $pdoException) {
			$result = new Result($pdoException->getCode(), RESULT::PDO, $pdoException->getMessage());
			$array['result'] = $result;
		} catch (Exception $exception) {
			$result = new Result(1, RESULT::SYSTEM, $exception->getMessage());
			$array['result'] = $result;
		}


		$connection = null;

		return $array;
	}
	public static function onInsert($post) {
		$database = Flight::get('database');
		$connection = new PDO("mysql:host=$database->Ip;dbname=$database->Database", $database->Username, $database->Password);
		$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$connection->setAttribute(PDO::ATTR_EMULATE_PREPARES, true);

		try {

			$array['result'] = array();

			if(!isset($post['object'])) {
				throw new Exception("Input object is null", 1);
			}

			$json = $post['object'];

			$object = json_decode($json);

			$address = $object->address[0];

			$sql = "
			INSERT INTO address 
			(address_name, address_full, address_latitude, address_longitude, address_country, address_city, address_area)
			VALUES
			(:address_name, :address_full, :address_latitude, :address_longitude, :address_country, :address_city, :address_area);";


			$query = $connection->prepare($sql);

			$query->bindParam(':address_name', $address->Name, PDO::PARAM_STR);
			$query->bindParam(':address_full', $address->Full, PDO::PARAM_STR);
			$query->bindParam(':address_latitude', $address->Coordinate->Latitude, PDO::PARAM_STR);
			$query->bindParam(':address_longitude', $address->Coordinate->Longitude, PDO::PARAM_STR);
			$query->bindParam(':address_country', $address->Country, PDO::PARAM_STR);
			$query->bindParam(':address_city', $address->City, PDO::PARAM_STR);
			$query->bindParam(':address_area', $address->Area, PDO::PARAM_STR);


			$query->execute();

			$result = new Result(0, RESULT::PDO, "Success");
			$array['result'] = $result;

		} catch (PDOException $pdoException) {
			$result = new Result($pdoException->getCode(), RESULT::PDO, $pdoException->getMessage());
			$array['result'] = $result;
		} catch (Exception $exception) {
			$result = new Result(1, RESULT::SYSTEM, $exception->getMessage());
			$array['result'] = $result;
		}

		$connection = null;

		return $array;
	}
	public static function onUpdate($put) {
		$database = Flight::get('database');

		$connection = new PDO("mysql:host=$database->Ip;dbname=$database->Database", $database->Username, $database->Password);
		$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$connection->setAttribute(PDO::ATTR_EMULATE_PREPARES, true);

		//$connection->beginTransaction();

		$array['result'] = array();

		try {
			if (!isset($put['id']) || !isset($put['object'])) {
				throw new Exception("Input object and id are null.", 1);
			}

			$id = $put['id'];
			$object = json_decode($put['object']);

			$address = $object->address[0];


			$sql = "
			UPDATE address 
			SET 
			address_name = :address_name,
			address_desc = :address_desc, 
			address_dt_created = :address_dt_created,
			e_status_id = :e_status_id, 
			info_id = :info_id, 
			e_field_id = :e_field_id, 
			setting_id = :setting_id
			WHERE
			id = :id;";

			

			$query = $connection->prepare($sql);

			$query->bindParam(':address_name', $address->Name, PDO::PARAM_STR);
			$query->bindParam(':address_desc', $address->Desc, PDO::PARAM_STR);
			$query->bindParam(':address_dt_created', $address->DtCreated, PDO::PARAM_STR);
			$query->bindParam(':e_status_id', $address->Status, PDO::PARAM_INT);
			$query->bindParam(':info_id', $address->Info, PDO::PARAM_INT);
			$query->bindParam(':e_field_id', $address->Field, PDO::PARAM_INT);
			$query->bindParam(':setting_id', $address->Setting, PDO::PARAM_INT);
			$query->bindParam(':id', $id, PDO::PARAM_INT);


			$query->execute();

			//$connection->commit();

			$result = new Result(0, RESULT::PDO, "Success");
			$array['result'] = $result;

		} catch (PDOException $pdoException) {
			//$connection->rollback();
			$result = new Result($pdoException->getCode(), RESULT::PDO, $pdoException->getMessage());
			$array['result'] = $result;
		} catch (Exception $exception) {
			//$connection->rollback();
			$result = new Result(1, RESULT::SYSTEM, $exception->getMessage());
			$array['result'] = $result;
		}

		$connection = null;

		return $array;
	}
	public static function onDelete($delete) {
		$database = Flight::get('database');

		$connection = new PDO("mysql:host=$database->Ip;dbname=$database->Database", $database->Username, $database->Password);
		$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$connection->setAttribute(PDO::ATTR_EMULATE_PREPARES, true);

		$array['result'] = array();

		
		try {
			if (!isset($delete['id'])) {
				throw new Exception("Input id is null", 1);
			}

			$id = $delete['id'];
			
			$sql = "
			DELETE FROM address 
			WHERE
			id = :id";

			$query = $connection->prepare($sql);

			$query->bindParam(':id', $id, PDO::PARAM_INT);

			$query->execute();

			$result = new Result(0, RESULT::PDO, "Success");
			$array['result'] = $result;

		} catch (PDOException $pdoException) {
			$result = new Result($pdoException->getCode(), RESULT::PDO, $pdoException->getMessage());
			$array['result'] = $result;
		} catch (Exception $exception) {
			$result = new Result(1, RESULT::SYSTEM, $exception->getMessage());
			$array['result'] = $result;
		}

		$connection = null;

		return $array;
	}
}

?>