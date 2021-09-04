<?php

include 'apps/connection.php';// connection string
//select products info
$query = $pdo->prepare(
  "SELECT * FROM blog"
);
$query->execute();
$post=$query->fetchAll(PDO::FETCH_ASSOC);


include('blog.phtml');

 ?>
