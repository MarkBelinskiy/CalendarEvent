<?php 
//check request fields from front-end
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
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
$updateUser = "UPDATE Events SET date_start='{$_POST['start']}', date_end='{$_POST['end']}' WHERE id_event='{$_POST['id']}'";
$updateUser = $db->prepare($updateUser);
if ($updateUser->execute()) {
	echo 'good';
} else {
	echo 'bad';
}

$db = null;
?>