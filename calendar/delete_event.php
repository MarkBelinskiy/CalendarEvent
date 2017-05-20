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
$delete_event = "DELETE FROM Events WHERE id_event = '{$_POST['id']}'";
$delete_event = $db->prepare($delete_event);
if ($delete_event->execute()) {
	echo 'good';
} else {
	echo 'bad';
}

$db = null;
?>