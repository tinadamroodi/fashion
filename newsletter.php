<?php

if(isset($_POST['subscribe'])){
include 'apps/connection.php';
$query = $pdo->prepare
(
  'INSERT INTO newsletter (email) VALUES (?)'
);
$query->execute([$_POST['subscribe']]);
$redirect = $_SERVER['HTTP_REFERER'];

header('Location:'.$redirect);
}

 ?>
