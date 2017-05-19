<?php
require_once '../db/db_connect.php';

$add_event = $db->prepare("INSERT INTO `Events` (id_author, name, description, date_start, date_end, color) VALUES (?,?,?,?,?,?)");

$id_author = $_POST['id_author'];
$name = $_POST['name'];
$description = $_POST['description'];
$date_start = $_POST['date_start'];
$date_end = $_POST['date_end'];
$color = $_POST['color'];
$i = 1;
foreach ($_POST as $key => $value) {
	$add_event->bindParam($i++, $$key);
}

if ($add_event->execute()) {
	echo 'good';
} else {
	print_r($add_event->errorInfo());
	echo 'bad';
}
$db = null;
?>