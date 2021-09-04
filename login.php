<?php
session_start();
  if((isset($_POST['email'])) and (isset($_POST['psw']))){
    include 'apps/connection.php';
    $stmnt = $pdo->prepare
    (
      'SELECT * FROM client WHERE email=? AND password=?'
    );
   $stmnt->execute([$_POST['email'], $_POST['psw']]);
  $users = $stmnt->fetchAll(PDO::FETCH_ASSOC);

      foreach($users as $user){
      $_SESSION['username'] = $user['firstName'];
      $_SESSION['id'] = $user['id'];
      }
      $redirect = $_SERVER['HTTP_REFERER'];
      $redirect = strtok($redirect,"?");

     header('Location:'.$redirect);

  }


?>
