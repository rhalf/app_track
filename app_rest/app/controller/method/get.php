<?php
function method_get(Url $url, $get) {
	switch ($url->Class) {

		case 'company':
		return Company::onSelect($url, $get);
		break;

		case 'user':
		return User::onSelect($url, $get);
		break;

		case 'vehicle':
		return Vehicle::onSelect($url, $get);
		break;

		case 'model':
		return Model::onSelect($url, $get);
		break;

		case 'address':
		return Address::onSelect($url, $get);
		break;



		//Enumerations
		case 'nation':
		return Nation::onSelect($url, $get);
		break;

		case 'privilege':
		return Privilege::onSelect($url, $get);
		break;

		default:
		Flight::notFound("Class $class not found.");
		break;
	}

	return $data;
}
?>