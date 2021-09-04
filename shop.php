<?php
session_start();
include 'apps/connection.php';// connection string

$query = $pdo->prepare(
  "SELECT DISTINCT(productSize) FROM products INNER JOIN inventory ON products.id = inventory.productId ORDER BY productSize ASC"
);
$query->execute();
$size=$query->fetchAll(PDO::FETCH_ASSOC);

$query = $pdo->prepare(
  "SELECT DISTINCT(colorCode), colorId FROM products INNER JOIN inventory ON products.id = inventory.productId INNER JOIN color ON inventory.colorId = color.id"
);
$query->execute();
$color=$query->fetchAll(PDO::FETCH_ASSOC);
//end of getting results from products table

$query = $pdo->prepare(
  "SELECT MIN(price), MAX(price) FROM products"
);
$query->execute();
$price=$query->fetchAll(PDO::FETCH_ASSOC);

$query = $pdo->prepare(
  "SELECT * FROM category"
);
$query->execute();
$category=$query->fetchAll(PDO::FETCH_ASSOC);



include('shop.phtml');
 ?>
