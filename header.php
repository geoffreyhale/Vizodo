<?php session_start(); ?>

<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Vizodo | Living Lists</title>
    <meta name="description" content="Gamify Life with Living Lists at Vizodo.com">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" href="css/normalize.css">
    <link rel="stylesheet" href="css/main.css">
    <link rel="stylesheet" href="css/style.css">

    <link rel="icon" type="image/png" href="favicon.png" />

    <!-- Facebook Open Graph -->
    <meta property="og:image" content="images/logo/vizodo-logo-check-box-black-204px.png"/>

    <script src="js/vendor/modernizr-2.6.2.min.js"></script>

    <?php include("functions.php"); ?>

  </head>
  <body>

  <div id="top-bar">
    <a href="http://www.vizodo.com/">Vizodo</a>

    <span id="user-box"><?php
          if($_SESSION['signed_in']) {
              echo 'Hello, ' . $_SESSION['user_name'] . '! | <a href="signout.php">Sign Out</a>';
          } else {
              echo '<a href="signin.php">Sign In</a> | <a href="signup.php">Sign Up</a>';
          }
    ?></span>
  </div>
