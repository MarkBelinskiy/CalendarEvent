<?php 
$user = 'root';
$pass = '';
try {
    $db = new PDO('mysql:host=localhost;dbname=aulink_bd', $user, $pass);
} catch (PDOException $e) {
    print "Error!: " . $e->getMessage() . "<br/>";
    die();
}

 ?>