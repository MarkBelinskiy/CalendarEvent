<?php 
//check request fields from front-end
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	if (array_key_exists('email', $_POST)) {
		if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
			echo 'bad';
			die();
		}
	}
	foreach ($_POST as $key => $value) {
		$_POST[$key] = htmlspecialchars(stripslashes(trim($_POST[$key]))); 
		if (empty($_POST[$key])) {
			echo json_encode(array("bad"));
			die();
		}
	}
} else {
	die();
	echo 'bad';
}
require_once '../db/db_connect.php';
$updateUser = "UPDATE Authors SET name='{$_POST['name']}', password=SHA1('{$_POST['password']}') WHERE email='{$_POST['email']}'";
$updateUser = $db->prepare($updateUser);
if ($updateUser->execute()) {
	echo 'good';
} else {
	echo 'bad';
}

$db = null;
?>