<?php
session_start();
include 'apps/connection.php';// connection string
//select products info
$query = $pdo->prepare(
  "SELECT * FROM products LIMIT 5"
);
$query->execute();
$products=$query->fetchAll(PDO::FETCH_ASSOC);
//end of getting results from products table

//select brands info
$query = $pdo->prepare(
  "SELECT * FROM brand LIMIT 5"
);
$query->execute();
$brands=$query->fetchAll(PDO::FETCH_ASSOC);
//end of getting results from brand table

//select two newest blog posts
$query = $pdo->prepare(
  "SELECT * FROM blog ORDER BY id DESC LIMIT 2"
);
$query->execute();
$blogs=$query->fetchAll(PDO::FETCH_ASSOC);
//end of getting results from blog table

$query = $pdo->prepare(
  "SELECT * FROM design WHERE subject='promo' ORDER BY id DESC LIMIT 2"
);
$query->execute();
$designs=$query->fetchAll(PDO::FETCH_ASSOC);

$startDate = date('Y-m-d',strtotime('-7 days'));
$endDate = date('Y-m-d');

$query = $pdo->prepare(
  "SELECT * FROM customerorder INNER JOIN products ON customerorder.productId = products.id WHERE saleDate BETWEEN '".$startDate."' AND '".$endDate."' GROUP By productId ORDER BY sum(orderAmount) DESC LIMIT 5"
);
$query->execute();
$weeklyBest=$query->fetchAll(PDO::FETCH_ASSOC);

include('index.phtml');
 ?>
