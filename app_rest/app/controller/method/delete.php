<?php
function method_delete(Url $url, $delete) {
	switch ($url->Class) {

		case 'company':
		return Company::onDelete($url, $delete);

		case 'user':
		return User::onDelete($url, $delete);
	
		case 'vehicle':
		return Vehicle::onDelete($url, $delete);

		case 'model':
		return Model::onDelete($url, $delete);
	
		case 'address':
		return Address::onDelete($url, $delete);
	
		case 'unit':
		return Unit::onDelete($url, $delete);
	

		//Enumerations
		case 'nation':
		return Nation::onDelete($url, $delete);
	
		case 'privilege':
		return Privilege::onDelete($url, $delete);

		case 'field':
		return Field::onDelete($url, $delete);

		case 'status':
		return Status::onDelete($url, $delete);

		case 'unittype':
		return UnitType::onDelete($url, $delete);	

		case 'simvendor':
		return SimVendor::onDelete($url, $delete);
	

		default:
		Flight::notFound("Class not found.");
		
	}
}
?>