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
		
		//20160308
		case 'driver':
		return Driver::onUpdate($url, $put);
		
		case 'companyinfo':
		return CompanyInfo::onUpdate($url, $put);
		
		case 'unitsim':
		return UnitSim::onUpdate($url, $put);

		case 'usersim':
		return UserSim::onUpdate($url, $put);
		
		case 'userinfo':
		return UserInfo::onUpdate($url, $put);
		
		case 'collection':
		return Collection::onUpdate($url, $put);
		
		case 'vehiclecollection':
		return VehicleCollection::onUpdate($url, $put);
		
		case 'route':
		return Route::onUpdate($url, $put);
		
		case 'poi':
		return Poi::onUpdate($url, $put);

		case 'geofence':
		return Geofence::onUpdate($url, $put);


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