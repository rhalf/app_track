<?php 

require_once('/app/model/interface/iquery.php');

class Nation implements IQuery {

	public $Id;
	public $NameShort;
	public $NameLong;
	public $Iso2;
	public $Iso3;
	public $Number;
	public $Uno;
	public $DialCode;
	public $Account;
	public $Language;
	public $Ethnic;
	public $Currency;


	public function __construct() {
	}

	public static function onSelect(Url $url, $get) {
		$database = Flight::get('database');
		$connection = new PDO("mysql:host=$database->Ip;dbname=$database->Database", $database->Username, $database->Password);
		$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$connection->setAttribute(PDO::ATTR_EMULATE_PREPARES, true);

		try {

			if (!empty($url->Id)) {
				$sql = "SELECT * FROM e_nation WHERE id = :id;";
				$query = $connection->prepare($sql);
				$query->bindParam(':id',$url->Id, PDO::PARAM_INT);
			} else if (isset($get['name'])) {
				$sql = "SELECT * FROM e_nation WHERE nation_name LIKE :name;";
				$query = $connection->prepare($sql);
				$query->bindParam(':name',$get['name'], PDO::PARAM_STR);
			} else {
				$sql = "SELECT * FROM e_nation;";
				$query = $connection->prepare($sql);
			}

			$query->execute();

			$result = new Result();
			$result->Item = $query->rowCount();
			$result->Object['nation'] = array();

			$rows = $query->fetchAll(PDO::FETCH_ASSOC);

			foreach ($rows as $row) {	
				$nation = new Nation();
				$nation->Id = (int) $row['id'];
				$nation->NameShort = $row['nation_short'];
				$nation->NameLong = $row['nation_long'];
				$nation->Iso2 = $row['nation_iso2'];
				$nation->Iso3 = $row['nation_iso3'];
				$nation->Number = (int) $row['nation_number'];
				$nation->Uno = (bool) $row['nation_uno'];
				$nation->DialCode = $row['nation_dial_code'];
				$nation->Account = $row['nation_account'];
				$nation->Language = $row['nation_language'];
				$nation->Ethnic = $row['nation_ethnic'];
				$nation->Currency = $row['nation_currency'];

				array_push($result->Object['nation'], $nation);
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
	public static function onInsert(Url $url, $post) {
		$database = Flight::get('database');

		$connection = new PDO("mysql:host=$database->Ip;dbname=$database->Database", $database->Username, $database->Password);
		$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$connection->setAttribute(PDO::ATTR_EMULATE_PREPARES, true);

		try {

			if (!isset($post['object'])) {
				throw new Exception("Input object is not set.");
			}

			$object = json_decode($post['object']);
			$nation = $object->nation[0];

			$sql = "
			INSERT INTO e_nation 
			(nation_iso2, nation_iso3, nation_short, nation_long, nation_number, nation_uno, nation_dial_code, nation_account, nation_language, nation_ethnic, nation_currency)
			VALUES
			(:nation_iso2, :nation_iso3, :nation_short, :nation_long, :nation_number, :nation_uno, :nation_dial_code, :nation_account, :nation_language, :nation_ethnic, :nation_currency);";


			$query = $connection->prepare($sql);

			$query->bindParam(':nation_iso2', $nation->Iso2, PDO::PARAM_STR);
			$query->bindParam(':nation_iso3', $nation->Iso3, PDO::PARAM_STR);
			$query->bindParam(':nation_short', $nation->NameShort, PDO::PARAM_STR);
			$query->bindParam(':nation_long', $nation->NameLong, PDO::PARAM_STR);
			$query->bindParam(':nation_number', $nation->Number, PDO::PARAM_INT);
			$query->bindParam(':nation_uno', $nation->Uno, PDO::PARAM_BOOL);
			$query->bindParam(':nation_dial_code', $nation->DialCode, PDO::PARAM_STR);
			$query->bindParam(':nation_account', $nation->Account, PDO::PARAM_STR);
			$query->bindParam(':nation_language', $nation->Language, PDO::PARAM_STR);
			$query->bindParam(':nation_ethnic', $nation->Ethnic, PDO::PARAM_STR);
			$query->bindParam(':nation_currency', $nation->Currency, PDO::PARAM_STR);


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
	public static function onUpdate(Url $url, $put) {
		$database = Flight::get('database');
		$connection = new PDO("mysql:host=$database->Ip;dbname=$database->Database", $database->Username, $database->Password);
		$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$connection->setAttribute(PDO::ATTR_EMULATE_PREPARES, true);

		try {
			if (empty($url->Id)) {
				throw new Exception("Input id is empty.");
			}

			if (!isset($put['object'])) {
				throw new Exception("Input object is not set.");
			}

			$object = json_decode($put['object']);
			$nation = $object->nation[0];

			$sql = "
			UPDATE e_nation 
			SET 
			nation_iso2 = :nation_iso2,
			nation_iso3 = :nation_iso3, 
			nation_short = :nation_short,
			nation_long = :nation_long,
			nation_number = :nation_number, 
			nation_uno = :nation_uno, 
			nation_dial_code = :nation_dial_code, 
			nation_account = :nation_account,
			nation_language = :nation_language, 
			nation_ethnic = :nation_ethnic, 
			nation_currency = :nation_currency
			WHERE
			id = :id;";

			$query = $connection->prepare($sql);

			$query->bindParam(':nation_iso2', $nation->Iso2, PDO::PARAM_STR);
			$query->bindParam(':nation_iso3', $nation->Iso3, PDO::PARAM_STR);
			$query->bindParam(':nation_short', $nation->NameShort, PDO::PARAM_STR);
			$query->bindParam(':nation_long', $nation->NameLong, PDO::PARAM_STR);
			$query->bindParam(':nation_number', $nation->Number, PDO::PARAM_INT);
			$query->bindParam(':nation_uno', $nation->Uno, PDO::PARAM_BOOL);
			$query->bindParam(':nation_dial_code', $nation->DialCode, PDO::PARAM_STR);
			$query->bindParam(':nation_account', $nation->Account, PDO::PARAM_STR);
			$query->bindParam(':nation_language', $nation->Language, PDO::PARAM_STR);
			$query->bindParam(':nation_ethnic', $nation->Ethnic, PDO::PARAM_STR);
			$query->bindParam(':nation_currency', $nation->Currency, PDO::PARAM_STR);
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
	public static function onDelete(Url $url, $delete) {
		$database = Flight::get('database');
		
		$connection = new PDO("mysql:host=$database->Ip;dbname=$database->Database", $database->Username, $database->Password);
		$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$connection->setAttribute(PDO::ATTR_EMULATE_PREPARES, true);

		try {
			
			if (empty($url->Id)) {
				throw new Exception("Input id is empty");
			}

			$sql = "
			DELETE FROM e_nation 
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