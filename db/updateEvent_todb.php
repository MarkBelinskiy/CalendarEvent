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

$updateEvent = "UPDATE Events SET id_author=?, name=?, description=?, date_start=?, date_end=?, color=? WHERE id_event='{$_POST['id_event']}'";

unset($_POST['id_event']);

$updateEvent = $db->prepare($updateEvent);
$id_author = $_POST['id_author'];
$name = $_POST['name'];
$description = $_POST['description'];
$date_start = $_POST['date_start'];
$date_end = $_POST['date_end'];
$color = $_POST['color'];
$i = 1;
foreach ($_POST as $key => $value) {
	$updateEvent->bindParam($i++, $$key);
}

if ($updateEvent->execute()) {
	echo 'good';
} else {
	print_r($updateEvent->errorInfo());
	echo 'bad';
}
$db = null;
?>