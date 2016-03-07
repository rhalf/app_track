<?php
function method_put(Url $url, $put) {
	switch ($url->Class) {

		case 'company':
		return Company::onUpdate($url, $put);

		case 'user':
		return User::onUpdate($url, $put);

		case 'vehicle':
		return Vehicle::onUpdate($url, $put);
		
		case 'model':
		return Model::onUpdate($url, $put);

		case 'address':
		return Address::onUpdate($url, $put);

		case 'unit':
		return Unit::onUpdate($url, $put);
		

		//Enumerations
		case 'nation':
		return Nation::onUpdate($url, $put);
		
		case 'privilege':
		return Privilege::onUpdate($url, $put);

		case 'field':
		return Field::onUpdate($url, $put);

		case 'status':
		return Status::onUpdate($url, $put);

		case 'unittype':
		return UnitType::onUpdate($url, $put);	

		case 'simvendor':
		return SimVendor::onUpdate($url, $put);


		default:
		Flight::notFound("Class not found.");
		
	}
}
?>