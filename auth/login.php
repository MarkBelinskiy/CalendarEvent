<?php 
//check request fields from front-end
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	if (array_key_exists('email', $_POST)) {
		if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
			echo json_encode(array("bad"));
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
	echo json_encode(array("bad"));
}

require_once '../db/db_connect.php';

$check_reg = "SELECT * from Authors WHERE email='{$_POST['email']}' AND password=sha1('{$_POST['pass']}')";
$check_reg = $db->prepare($check_reg);
$check_reg->execute();

$result = $check_reg->fetch(PDO::FETCH_ASSOC);
$db = null;


if ($result) {
	array_unshift($result, "good");
	echo json_encode($result);
} else {
	echo json_encode(array("bad"));
}
?>