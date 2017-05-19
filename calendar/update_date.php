<?php 
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