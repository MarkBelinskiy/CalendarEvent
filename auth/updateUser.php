<?php 
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