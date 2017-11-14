<?php session_start();
include 'connect.php';

  // Retrieve data from Query String
$item = $_GET['item'];
  // Escape User Input to help prevent SQL Injection
$item = mysql_real_escape_string($item);
  //build query
$query = "INSERT INTO
          targets(target_text, target_last, target_user,
            target_time_delay_hours, target_time_goal_hours, target_time_fail_hours )
          VALUES('" . $item . "',
            NOW(),
            '" . $_SESSION['user_id'] . "',
            '" . 0 . "',
            '" . 0 . "',
            '" . 0 . "'
            )";
  //Execute query
$qry_result = mysql_query($query) or die(mysql_error());

$display_string = "this is the display_string";
echo $display_string;

?>
