<?php //signout.php

session_start();
$_SESSION['signed_in'] = false;
$_SESSION['user_id']    = null;
$_SESSION['user_name']  = null;

include 'connect.php';
include 'header.php';

?>

<h3>You are no longer logged in.</h3>

<?php include 'footer.php'; ?>
