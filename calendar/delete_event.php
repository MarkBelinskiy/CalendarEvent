<?php 
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