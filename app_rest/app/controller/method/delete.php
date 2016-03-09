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

		//20160308
		case 'driver':
		return Driver::onDelete($url, $delete);
		
		case 'companyinfo':
		return CompanyInfo::onDelete($url, $delete);
		
		case 'unitsim':
		return UnitSim::onDelete($url, $delete);

		case 'usersim':
		return UserSim::onDelete($url, $delete);
		
		case 'userinfo':
		return UserInfo::onDelete($url, $delete);
		
		case 'collection':
		return Collection::onDelete($url, $delete);

		case 'vehiclecollection':
		return VehicleCollection::onDelete($url, $delete);
		
		case 'route':
		return Route::onDelete($url, $delete);
		
		case 'poi':
		return Poi::onDelete($url, $delete);

		case 'geofence':
		return Geofence::onDelete($url, $delete);


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