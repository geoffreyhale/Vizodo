<?php
//connect.php

$server = 'touch.geoffreyhale.com';
$username = 'user_touch';
$password = 'D+ubrUw5^';
$database = 'geoffreyhale_touch';

if ( !mysql_connect( $server, $username, $password ) )
{
  exit( 'Error: could not establish database connection' );
}

if ( !mysql_select_db( $database ) )
{
  exit( 'Error: could not select the database' );
}

?>
