<?php
session_start();
if (isset($_GET['id'])){
include 'apps/connection.php';// connection string
//select products info
$query = $pdo->prepare(
  "SELECT * FROM inventory INNER JOIN products ON inventory.productId = products.id WHERE inventory.productId=?"
);
$query->execute([$_GET['id']]);
$product=$query->fetchAll(PDO::FETCH_ASSOC);

//end of getting results from blog table
$query = $pdo->prepare(
  "SELECT * FROM inventory INNER JOIN products ON inventory.productId = products.id INNER JOIN category ON products.categoryId = category.id WHERE inventory.productId=?"
);
$query->execute([$_GET['id']]);
$category=$query->fetchAll(PDO::FETCH_ASSOC);

$query = $pdo->prepare(
  "SELECT * FROM inventory INNER JOIN color ON inventory.colorId = color.id WHERE inventory.productId=?"
);
$query->execute([$_GET['id']]);
$color=$query->fetchAll(PDO::FETCH_ASSOC);

$query = $pdo->prepare(
  "SELECT * FROM inventory INNER JOIN products ON inventory.productId = products.id INNER JOIN gallery ON products.id = gallery.pId WHERE inventory.productId=?"
);
$query->execute([$_GET['id']]);
$gallery=$query->fetchAll(PDO::FETCH_ASSOC);

$query = $pdo->prepare(
  "SELECT * FROM inventory INNER JOIN products ON inventory.productId = products.id  WHERE products.categoryID = (SELECT categoryID FROM products WHERE products.id=?) AND inventory.productId!=? LIMIT 5"
);
$query->execute([$_GET['id'],$_GET['id']]);
$relatedProducts=$query->fetchAll(PDO::FETCH_ASSOC);

$query = $pdo->prepare(
  "SELECT * FROM inventory WHERE productId=?"
);
$query->execute([$_GET['id']]);
$size=$query->fetchAll(PDO::FETCH_ASSOC);

include'single-product.phtml';
}
else{
  header('Location:shop.php');
}
 ?>
