<?php
$url=basename($_SERVER['PHP_SELF'],'.php');
include 'apps/connection.php';// connection string
//select products info
$query = $pdo->prepare(
  "SELECT * FROM category"
);
$query->execute();
$categories=$query->fetchAll(PDO::FETCH_ASSOC);

include'header.phtml';

 ?>
