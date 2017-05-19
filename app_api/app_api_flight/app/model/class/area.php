<?php 
/*
	Created by 		:		Rhalf Wendel D Caacbay
	Created on 		:		20170430

	Modified by 	:		#
	Modified on 	:		#

	functions 		:		Defines the class area and supplies the requests such as select, insert, update & delete.
*/
class Area implements IQuery {

	public $id;
	public $name;
	public $desc;
	public $coordinates;
	public $speedMinL;
	public $speedMaxL;
	public $speedMinH;
	public $speedMaxH;
	public $isVisible;
	public $nation;

	public function __construct() {
	}

	public static function selectAll() {
		
		$connection = Flight::dbMain();

		try {

			$sql = "SELECT * FROM area;";
			$query = $connection->prepare($sql);


			$query->execute();

			$rows = $query->fetchAll(PDO::FETCH_ASSOC);

			$result = array();

			foreach ($rows as $row) {	
				$area = new Area();
				$area->id = (int) $row['id'];
				$area->name = $row['area_name'];
				$area->desc = $row['area_desc'];
				$area->coordinates = json_decode($row['area_coordinates']);
				$area->speedMinL =  (int) $row['area_speed_min_l'];
				$area->speedMaxL = (int) $row['area_speed_max_l'];
				$area->speedMinH = (int) $row['area_speed_min_h'];
				$area->speedMaxH = (int) $row['area_speed_max_h'];
				$area->isVisible = (bool) $row['area_is_visible'];
				$area->nation = nation::select($row['e_nation_id']);

				
				array_push($result, $area);
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

			$sql = "SELECT * FROM area WHERE id = :id;";
			$query = $connection->prepare($sql);
			$query->bindParam(':id',$id, PDO::PARAM_INT);

			$query->execute();

			if ($query->rowCount() < 1){
				return null;
			}

			$row = $query->fetch(PDO::FETCH_ASSOC);

			
			$area = new Area();
			$area->id = (int) $row['id'];
			$area->name = $row['area_name'];
			$area->desc = $row['area_desc'];
			$area->coordinates = json_decode($row['area_coordinates']);
			$area->speedMinL =  (int) $row['area_speed_min_l'];
			$area->speedMaxL = (int) $row['area_speed_max_l'];
			$area->speedMinH = (int) $row['area_speed_min_h'];
			$area->speedMaxH = (int) $row['area_speed_max_h'];
			$area->isVisible = (bool) $row['area_is_visible'];
			$area->nation = nation::select($row['e_nation_id']);

			return $area;

		} catch (PDOException $pdoException) {
			throw $pdoException;
		} catch (Exception $exception) {
			throw $exception;
		} finally {
			$connection = null;
		}
	}

	public static function selectBynation($id) {

		$connection = Flight::dbMain();

		try {

			$sql = "SELECT * FROM area WHERE e_nation_id = :e_nation_id;";
			$query = $connection->prepare($sql);
			$query->bindParam(':e_nation_id',$id, PDO::PARAM_INT);


			$query->execute();

			$rows = $query->fetchAll(PDO::FETCH_ASSOC);

			$result = array();

			foreach ($rows as $row) {	
				$area = new Area();
				$area->id = (int) $row['id'];
				$area->name = $row['area_name'];
				$area->desc = $row['area_desc'];
				$area->coordinates = json_decode($row['area_coordinates']);
				$area->speedMinL =  (int) $row['area_speed_min_l'];
				$area->speedMaxL = (int) $row['area_speed_max_l'];
				$area->speedMinH = (int) $row['area_speed_min_h'];
				$area->speedMaxH = (int) $row['area_speed_max_h'];
				$area->isVisible = (bool) $row['area_is_visible'];
				$area->nation = nation::select($row['e_nation_id']);

				
				array_push($result, $area);
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

			$area = json_decode(file_get_contents("php://input"));

			if ($area == null) {
				throw new Exception(json_get_error());
			}

			$sql = "
			INSERT INTO area 
			(
			area_name,
			area_desc,
			area_coordinates,
			area_speed_min_l,
			area_speed_max_l,
			area_speed_min_h,
			area_speed_max_h,
			area_is_visible,
			e_nation_id)
			VALUES
			(
			:area_name, 
			:area_desc, 
			:area_coordinates, 
			:area_speed_min_l, 
			:area_speed_max_l, 
			:area_speed_min_h,
			:area_speed_max_h,
			:area_is_visible,
			:e_nation_id
			);";


			$query = $connection->prepare($sql);

			$query->bindParam(':area_name', $area->name, PDO::PARAM_STR);
			$query->bindParam(':area_desc', $area->desc, PDO::PARAM_STR);
			
			$json = json_encode($area->coordinates);
			$query->bindParam(':area_coordinates', $json, PDO::PARAM_STR);
			
			$query->bindParam(':area_speed_min_l', $area->speedMinL, PDO::PARAM_INT);
			$query->bindParam(':area_speed_max_l', $area->speedMaxL, PDO::PARAM_INT);
			$query->bindParam(':area_speed_min_h', $area->speedMinH, PDO::PARAM_INT);
			$query->bindParam(':area_speed_max_h', $area->speedMaxH, PDO::PARAM_INT);
			$query->bindParam(':area_is_visible', $area->isVisible, PDO::PARAM_BOOL);
			$query->bindParam(':e_nation_id', $area->nation->id, PDO::PARAM_INT);


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

			$area = json_decode(file_get_contents("php://input"));

			if ($area == null) {
				throw new Exception(json_get_error());
			}

			$sql = "
			UPDATE area 
			SET 
			area_name = :area_name,
			area_desc = :area_desc,
			area_coordinates = :area_coordinates,
			area_speed_min_l = :area_speed_min_l,
			area_speed_max_l = :area_speed_max_l,
			area_speed_min_h = :area_speed_min_h,
			area_speed_max_h = :area_speed_max_h,
			area_is_visible = :area_is_visible,
			e_nation_id = :e_nation_id
			WHERE
			id = :id;";

			$query = $connection->prepare($sql);

			$query->bindParam(':area_name', $area->name, PDO::PARAM_STR);
			$query->bindParam(':area_desc', $area->desc, PDO::PARAM_STR);

			$json = json_encode($area->coordinates);
			$query->bindParam(':area_coordinates', $json, PDO::PARAM_STR);

			$query->bindParam(':area_speed_min_l', $area->speedMinL, PDO::PARAM_INT);
			$query->bindParam(':area_speed_max_l', $area->speedMaxL, PDO::PARAM_INT);
			$query->bindParam(':area_speed_min_h', $area->speedMinH, PDO::PARAM_INT);
			$query->bindParam(':area_speed_max_h', $area->speedMaxH, PDO::PARAM_INT);
			$query->bindParam(':area_is_visible', $area->isVisible, PDO::PARAM_BOOL);
			$query->bindParam(':e_nation_id', $area->nation->id, PDO::PARAM_INT);

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
			DELETE FROM area 
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


	public static function selectByUnitData($areas, $unitData){

			$coordinate = $unitData->gps->coordinate;

			$result = null;
			//$result = array();

			foreach ($areas as $index => $area) {
				if(Area::checkPoint($area, $coordinate) == true) {
					//array_push($result, $area);
					$result =  $area->id;
				}
			}

			return $result;
	}


	private static function checkPoint($area, $coordinate) {

            
			 $coordinates = $area->coordinates;
			 $count = sizeof($area->coordinates);

            $result = false;


            for ($index1 = 0, $index2 = $count - 1; $index1 < $count; $index2 = $index1++) {
                if (((($coordinates[$index1]->latitude <= $coordinate->latitude) && ($coordinate->latitude < $coordinates[$index2]->latitude))
                        || (($coordinates[$index2]->latitude <= $coordinate->latitude) && ($coordinate->latitude < $coordinates[$index1]->latitude)))
                        && ($coordinate->longitude < ($coordinates[$index2]->longitude - $coordinates[$index1]->longitude) * ($coordinate->latitude - $coordinates[$index1]->latitude)
                            / ($coordinates[$index2]->latitude - $coordinates[$index1]->latitude) + $coordinates[$index1]->longitude)) {
                    $result = !$result;
                }
            }

            return $result;
    }
}

?>
