<?php
$thanks=false;
$form_validate=true;
if($_SERVER['REQUEST_METHOD']==='POST'){

  if(!(empty($_POST['fname'])) and !(empty($_POST['lname'])) and !(empty($_POST['email'])) and !(empty($_POST['subject']))){
    if(!(ctype_alpha($_POST['fname'])))
    {
      $fnameError = "Your name should only contain alphabet";
      $form_validate = false;
    }
    if(!(ctype_alpha($_POST['lname'])))
    {
      $lnameError = "Your last name should only contain alphabet";
      $form_validate = false;
    }
    if(!(filter_var($_POST['email'],FILTER_VALIDATE_EMAIL))){
      $emailError = "Please enter a valid email address";
      $form_validate = false;
    }
    if($form_validate==true){
      include 'apps/connection.php';
      $query = $pdo->prepare
      (
        'INSERT INTO contact (firstName,lastName,email,subject) VALUES (?,?,?,?)'
      );
      $query->execute([$_POST['fname'], $_POST['lname'], $_POST['email'], $_POST['subject']]);
      $thanks=true;
    }
  }
  else{
    if((empty($_POST['fname'])))
    {
      $fnameError = "You are not allowed to leave this field empty.";
      $form_validate = false;
    }
    if((empty($_POST['lname'])))
    {
      $lnameError = "You are not allowed to leave this field empty.";
      $form_validate = false;
    }
    if((empty($_POST['email'])))
    {
      $emailError = "You are not allowed to leave this field empty.";
      $form_validate = false;
    }
    if((empty($_POST['subject'])))
    {
      $subjectError = "You are not allowed to leave this field empty.";
      $form_validate = false;
    }
  }
}
include('contact.phtml');
 ?>
