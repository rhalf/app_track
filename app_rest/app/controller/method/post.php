<?php
function method_post(Url $url, $post) {
	switch ($url->Class) {

		case 'company':
		return Company::onInsert($url, $post);
		break;

		case 'user':
		return User::onInsert($url, $post);
		break;

		case 'model':
		return Model::onInsert($url, $post);
		break;

		case 'address':
		return Address::onInsert($url, $post);
		break;


		//Enumerations
		case 'nation':
		return Nation::onInsert($url, $post);
		break;
		
		case 'privilege':
		return Privilege::onInsert($url, $post);
		break;
		
		default:
		Flight::notFound("Class $class not found.");
		break;
	}
}


