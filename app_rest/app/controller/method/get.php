<?php
function method_get(Url $url, $data) {
	switch ($url->Class) {

		case 'company':
		return Company::onSelect($url, $data);

		case 'user':
		return User::onSelect($url, $data);

		case 'vehicle':
		return Vehicle::onSelect($url, $data);

		case 'model':
		return Model::onSelect($url, $data);

		case 'address':
		return Address::onSelect($url, $data);

		case 'unit':
		return Unit::onSelect($url, $data);

		//20160308
		case 'driver':
		return Driver::onSelect($url, $data);
		
		case 'companyinfo':
		return CompanyInfo::onSelect($url, $data);
		
		case 'unitsim':
		return UnitSim::onSelect($url, $data);

		case 'usersim':
		return UserSim::onSelect($url, $data);
		
		case 'userinfo':
		return UserInfo::onSelect($url, $data);
		
		case 'collection':
		return Collection::onSelect($url, $data);

		case 'vehiclecollection':
		return VehicleCollection::onSelect($url, $data);
		
		case 'route':
		return Route::onSelect($url, $data);
		
		case 'poi':
		return Poi::onSelect($url, $data);

		case 'geofence':
		return Geofence::onSelect($url, $data);

		//App 
		case 'appdatabase':
		return AppDatabase::onSelect($url, $data);

		case 'appnote':
		return AppNote::onSelect($url, $data);

		case 'appsetting':
		return AppSetting::onSelect($url, $data);

		case 'appclient':
		return AppClient::onSelect($url, $data);

		case 'appinfo':
		return AppInfo::onSelect($url, $data);

		case 'applog':
		return AppLog::onSelect($url, $data);



		//Enumerations
		case 'nation':
		return Nation::onSelect($url, $data);

		case 'privilege':
		return Privilege::onSelect($url, $data);

		case 'field':
		return Field::onSelect($url, $data);

		case 'status':
		return Status::onSelect($url, $data);

		case 'unittype':
		return UnitType::onSelect($url, $data);	

		case 'simvendor':
		return SimVendor::onSelect($url, $data);

		
		default:
		Flight::notFound("Class not found.");
		
	}
}
?>