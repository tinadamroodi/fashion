<?php
session_start();
if(isset($_SESSION['id'])){
include 'apps/connection.php';

$query = $pdo->prepare(
  "SELECT * FROM client WHERE id=?"
);
$query->execute([$_SESSION['id']]);
$result = $query->fetchAll(PDO::FETCH_ASSOC);

$query = $pdo->prepare(
  "SELECT * FROM customerorder INNER JOIN client ON customerorder.clientId = client.id INNER JOIN products ON products.id=customerorder.productId WHERE client.id=?"
);
$query->execute([$_SESSION['id']]);
$orders = $query->fetchAll(PDO::FETCH_ASSOC);

if($_SERVER['REQUEST_METHOD']==='POST'){
  //update
  $query =$pdo->prepare(
     "UPDATE client SET firstName=? , lastName=?, email=?, password=?, phoneNumber=?, address=? WHERE id = ?"
   );
   $query->execute([$_POST['firstName'],$_POST['lastName'],$_POST['email'],$_POST['password'],$_POST['phoneNumber'],$_POST['address'],$_POST['id']]);
   header ('location: profile.php');
}
}
else{
  header("Location: index.php?login=fail");
}


include 'profile.phtml';
 ?>
