<?php
function method_post($class, $post) {

	$data = null;
	switch ($class) {
		case 'company':
		$data = Company::onInsert($post);
		break;
		case 'user':
		$data = User::onInsert($post);
		break;
		case 'model':
		$data = Model::onInsert($post);
		break;
		case 'address':
		$data = Address::onInsert($post);
		break;


		case 'nation':
		$data = Nation::onInsert($post);
		break;
		case 'privilege':
		$data = Privilege::onInsert($post);
		break;
		default:
		Flight::notFound("Class $class not found.");
		break;
	}

	return $data;
}


