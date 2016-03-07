<?php
function method_post(Url $url, $post) {
	switch ($url->Class) {

		case 'company':
		return Company::onInsert($url, $post);

		case 'user':
		return User::onInsert($url, $post);

		case 'vehicle':
		return Vehicle::onInsert($url, $post);

		case 'model':
		return Model::onInsert($url, $post);

		case 'address':
		return Address::onInsert($url, $post);

		case 'unit':
		return Unit::onInsert($url, $post);


		//Enumerations
		case 'nation':
		return Nation::onInsert($url, $post);

		case 'privilege':
		return Privilege::onInsert($url, $post);

		case 'field':
		return Field::onInsert($url, $post);

		case 'status':
		return Status::onInsert($url, $post);

		case 'unittype':
		return UnitType::onInsert($url, $post);	

		case 'simvendor':
		return SimVendor::onInsert($url, $post);
	

		default:
		Flight::notFound("Class not found.");
		
	}
}
?>
