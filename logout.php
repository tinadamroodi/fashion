<?php
    session_start();
    session_destroy();
     $redirect = $_SERVER['HTTP_REFERER'];
     header('Location:'.$redirect);
?>
