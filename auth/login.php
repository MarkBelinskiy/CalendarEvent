<?php 
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