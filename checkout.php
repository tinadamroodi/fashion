<?php
session_start();
if(isset($_SESSION['username'])){
if(isset($_POST["action"])){
include 'apps/connection.php';// connection string
$productId = $_POST["productId"];//35,36,40
$colorId = $_POST["colorId"];
$productSize = $_POST["productSize"];
$orderAmount = $_POST["orderAmount"];
$query = $pdo->prepare(
  "INSERT INTO customerorder (clientId,productId,productSize,colorId,orderAmount,saleDate) VALUES (?,?,?,?,?,?)"
);
$query->execute([$_SESSION['id'],$productId,$productSize,$colorId,$orderAmount,date('y-m-d')]);

}
}
else{
  header("Location: cart.php?login=fail");
}
 ?>
