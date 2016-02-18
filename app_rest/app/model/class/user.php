<?php 

require_once('/app/model/interface/iquery.php');

class User implements IQuery {

	public $Id;
	public $Name;
	public $Password;
	public $DtCreated;
	public $DtExpired;
	public $DtLogin;
	public $DtActived;
	public $Privilege;
	public $Status;
	public $Email;
	public $Setting;
	public $Company;

	public function __construct() {
	}

	public static function onSelect($get){

	}
	public static function onInsert($post){

	}
	public static function onUpdate($put){

	}
	public static function onDelete($delete){
		
	}

}

?>