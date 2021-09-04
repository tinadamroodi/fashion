<?php
session_start();
if (isset($_GET['post'])){
include 'apps/connection.php';// connection string
//select products info
$query = $pdo->prepare(
  "SELECT * FROM blog WHERE id=?"
);
$query->execute([$_GET['post']]);
$post=$query->fetchAll(PDO::FETCH_ASSOC);


include('single-post.phtml');
}
else{
  header('Location:blog.php');
}
 ?>
