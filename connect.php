<?php
//connect.php

$server = 'touch.geoffreyhale.com'; //example
$username = 'user_touch'; //example
$password = 'D+ubrUw5^'; //example
$database = 'geoffreyhale_touch'; //example

if ( !mysql_connect( $server, $username, $password ) )
{
  exit( 'Error: could not establish database connection' );
}

if ( !mysql_select_db( $database ) )
{
  exit( 'Error: could not select the database' );
}

?>
