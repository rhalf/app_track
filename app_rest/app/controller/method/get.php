<?php
function method_get(Url $url, $get) {
	switch ($url->Class) {

		case 'company':
		return Company::onSelect($url, $get);

		case 'user':
		return User::onSelect($url, $get);

		case 'vehicle':
		return Vehicle::onSelect($url, $get);

		case 'model':
		return Model::onSelect($url, $get);

		case 'address':
		return Address::onSelect($url, $get);

		case 'unit':
		return Unit::onSelect($url, $get);

		//20160308
		case 'driver':
		return Driver::onSelect($url, $get);
		
		case 'companyinfo':
		return CompanyInfo::onSelect($url, $get);
		
		case 'unitsim':
		return UnitSim::onSelect($url, $get);

		case 'usersim':
		return UserSim::onSelect($url, $get);
		
		case 'userinfo':
		return UserInfo::onSelect($url, $get);
		
		case 'collection':
		return Collection::onSelect($url, $get);
	
		case 'vehiclecollection':
		return VehicleCollection::onSelect($url, $get);
		
		case 'route':
		return Route::onSelect($url, $get);
		
		case 'poi':
		return Poi::onSelect($url, $get);

		case 'geofence':
		return Geofence::onSelect($url, $get);

		//Enumerations
		case 'nation':
		return Nation::onSelect($url, $get);

		case 'privilege':
		return Privilege::onSelect($url, $get);

		case 'field':
		return Field::onSelect($url, $get);

		case 'status':
		return Status::onSelect($url, $get);

		case 'unittype':
		return UnitType::onSelect($url, $get);	

		case 'simvendor':
		return SimVendor::onSelect($url, $get);


		default:
		Flight::notFound("Class not found.");
		
	}
}
?>