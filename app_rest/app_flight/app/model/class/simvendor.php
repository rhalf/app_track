<?php 

class SimVendor implements IQuery {

	public $Id;
	public $Name;
	public $Desc;
	public $Nation;
	
	
	public function __construct() {
	}

	public static function onSelect(Url $url, $data) {
		
		$connection = Flight::dbMain();

		try {

			if (!empty($url->Id)) {
				$sql = "SELECT * FROM  e_sim_vendor WHERE id = :id;";
				$query = $connection->prepare($sql);
				$query->bindParam(':id',$url->Id, PDO::PARAM_INT);
			} else if (isset($data['imei'])) {
				$sql = "SELECT * FROM  e_sim_vendor WHERE sim_vendor_name LIKE :name;";
				$query = $connection->prepare($sql);
				$query->bindParam(':name',$data['name'], PDO::PARAM_STR);
			} else {
				$sql = "SELECT * FROM e_sim_vendor;";
				$query = $connection->prepare($sql);
			}

			$query->execute();

			$result = new Result();
			$result->Item = $query->rowCount();
			$result->Object = array();

			$rows = $query->fetchAll(PDO::FETCH_ASSOC);

			foreach ($rows as $row) {	
				$simVendor = new SimVendor();
				$simVendor->Id = (int) $row['id'];
				$simVendor->Name = $row['sim_vendor_name'];
				$simVendor->Desc = $row['sim_vendor_desc'];
				$simVendor->Nation = (int) $row['e_nation_id'];
				

				array_push($result->Object, $simVendor);
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
		
		$connection = Flight::dbMain();

		try {

			if (!isset($data['Object'])) {
				throw new Exception("Input object is not set.");
			}

			$simVendor = json_decode($data['Object']);
			if ($simVendor == null) {
				throw new Exception(json_get_error());
			}
			
			$sql = "
			INSERT INTO e_sim_vendor 
			(sim_vendor_name, sim_vendor_desc, e_nation_id)
			VALUES
			(:sim_vendor_name, :sim_vendor_desc, :e_nation_id);";

			$query = $connection->prepare($sql);

			$query->bindParam(':sim_vendor_name', $simVendor->Name, PDO::PARAM_STR);
			$query->bindParam(':sim_vendor_desc', $simVendor->Desc, PDO::PARAM_STR);
			$query->bindParam(':e_nation_id', $simVendor->Nation, PDO::PARAM_INT);
			
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
		
		$connection = Flight::dbMain();

		try {
			if (empty($url->Id)) {
				throw new Exception("Input id is empty.");
			}

			if (!isset($data['Object'])) {
				throw new Exception("Input object is not set.");
			}

			$simVendor = json_decode($data['Object']);
			if ($simVendor == null) {
				throw new Exception(json_get_error());
			}
			
			$sql = "
			UPDATE e_sim_vendor 
			SET 
			sim_vendor_name = :sim_vendor_name,
			sim_vendor_desc = :sim_vendor_desc, 
			e_nation_id = :e_nation_id
			WHERE
			id = :id;";

			$query = $connection->prepare($sql);

			$query->bindParam(':sim_vendor_name', $simVendor->Name, PDO::PARAM_STR);
			$query->bindParam(':sim_vendor_desc', $simVendor->Desc, PDO::PARAM_STR);
			$query->bindParam(':e_nation_id', $simVendor->Nation, PDO::PARAM_INT);
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
		
		$connection = Flight::dbMain();

		try {
			
			if (empty($url->Id)) {
				throw new Exception("Input id is empty");
			}

			$sql = "
			DELETE FROM  e_sim_vendor 
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