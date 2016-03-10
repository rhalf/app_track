<?php 

class Poi implements IQuery {

	public $Id;
	public $Company;
	public $Name;
	public $Desc;
	public $Latitude;
	public $Logitude;
	public $IsVisible;
	public $IsGlobal;
	public $Image;

	public function __construct() {
	}

	public static function onSelect(Url $url, $data) {
		$database = Flight::get('database');
		$connection = new PDO("mysql:host=$database->Ip;dbname=$database->Database", $database->Username, $database->Password);
		$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$connection->setAttribute(PDO::ATTR_EMULATE_PREPARES, true);

		try {

			if (!empty($url->Id)) {
				$sql = "SELECT * FROM poi WHERE id = :id;";
				$query = $connection->prepare($sql);
				$query->bindParam(':id',$url->Id, PDO::PARAM_INT);
			} else if (isset($data['name'])) {
				$sql = "SELECT * FROM poi WHERE poi_name LIKE :name;";
				$query = $connection->prepare($sql);
				$query->bindParam(':name',$data['name'], PDO::PARAM_STR);
			} else {
				$sql = "SELECT * FROM poi;";
				$query = $connection->prepare($sql);
			}

			$query->execute();

			$result = new Result();
			$result->Item = $query->rowCount();
			$result->Object = array();

			$rows = $query->fetchAll(PDO::FETCH_ASSOC);

			foreach ($rows as $row) {	
				$poi = new Poi();
				$poi->Id = (int) $row['id'];
				$poi->Company = (int) $row['company_id'];
				$poi->Name = $row['poi_name'];
				$poi->Desc = $row['poi_desc'];
				$poi->Latitude = (double) $row['poi_latitude'];
				$poi->Logitude = (double) $row['poi_longitude'];
				$poi->IsVisible = (bool) $row['poi_is_visible'];
				$poi->IsGlobal = (bool) $row['poi_is_global'];
				$poi->Image = $row['poi_image'];
				
				array_push($result->Object, $poi);
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

			if (!isset($data['Object'])) {
				throw new Exception("Input object is not set.");
			}

			$poi = json_decode($data['Object']);
			if ($poi == null) {
				throw new Exception(json_get_error());
			}

			$sql = "
			INSERT INTO poi 
			(company_id, poi_name,poi_desc,poi_latitude,poi_longitude,poi_is_visible,poi_is_global,poi_image)
			VALUES
			(:company_id, :poi_name, :poi_desc, :poi_latitude, :poi_longitude, :poi_is_visible, :poi_is_global, :poi_image);";


			$query = $connection->prepare($sql);

			$query->bindParam(':company_id', $poi->Company, PDO::PARAM_INT);
			$query->bindParam(':poi_name', $poi->Name, PDO::PARAM_STR);
			$query->bindParam(':poi_desc', $poi->Desc, PDO::PARAM_STR);
			$query->bindParam(':poi_latitude', $poi->Latitude, PDO::PARAM_INT);
			$query->bindParam(':poi_longitude', $poi->Logitude, PDO::PARAM_INT);
			$query->bindParam(':poi_is_visible', $poi->IsVisible, PDO::PARAM_BOOL);
			$query->bindParam(':poi_is_global', $poi->IsGlobal, PDO::PARAM_BOOL);
			$query->bindParam(':poi_image', $poi->Image, PDO::PARAM_STR);


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

		try {
			if (empty($url->Id)) {
				throw new Exception("Input id is empty.");
			}

			if (!isset($data['Object'])) {
				throw new Exception("Input object is not set.");
			}

			$poi = json_decode($data['Object']);
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
			poi_is_global = :poi_is_global,
			poi_image = :poi_image

			WHERE
			id = :id;";

			$query = $connection->prepare($sql);

			$query->bindParam(':company_id', $poi->Company, PDO::PARAM_INT);
			$query->bindParam(':poi_name', $poi->Name, PDO::PARAM_STR);
			$query->bindParam(':poi_desc', $poi->Desc, PDO::PARAM_STR);
			$query->bindParam(':poi_latitude', $poi->Latitude, PDO::PARAM_INT);
			$query->bindParam(':poi_longitude', $poi->Logitude, PDO::PARAM_INT);
			$query->bindParam(':poi_is_visible', $poi->IsVisible, PDO::PARAM_BOOL);
			$query->bindParam(':poi_is_global', $poi->IsGlobal, PDO::PARAM_BOOL);
			$query->bindParam(':poi_image', $poi->Image, PDO::PARAM_STR);

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
				throw new Exception("Input id is empty");
			}

			$sql = "
			DELETE FROM poi 
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