<?php
function method_delete($class, $delete) {

	switch ($class) {
		case 'company':
		$data = Company::onDelete($delete);
		break;
		case 'user':
		$data = User::onDelete($delete);
		break;

		case 'nation':
		$data = Nation::onDelete($delete);
		break;
		case 'privilege':
		$data = Privilege::onDelete($delete);
		break;
		default:
		Flight::notFound("Class $class not found.");
		break;
	}

	return $data;
}
?>