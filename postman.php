<?php
//postman.php

/**
* If the form has been posted, process the data!
*/
if ( $_SERVER['REQUEST_METHOD'] == 'POST' )
{


    if ( $_POST['new_item_name'] )
    {
      $sql = "INSERT INTO
            targets(target_text, target_last, target_user,
              target_time_delay_hours, target_time_goal_hours, target_time_fail_hours )
          VALUES('" . mysql_real_escape_string( $_POST['new_item_name'] ) . "',
            NOW(),
            '" . $_SESSION['user_id'] . "',
            '" . $_POST['item_time_delay'] . "',
            '" . $_POST['item_time_goal'] . "',
            '" . $_POST['item_time_fail'] . "'
            )";

      $result = mysql_query($sql);

      if(!$result)
      {
          //something went wrong, display the error
          echo 'Something went wrong.';
          //echo mysql_error(); //debugging purposes, uncomment when needed
      }
      else
      {
          echo 'Successful.';
      }
    }




  /**
  *
  * CHECK
  *
  */


  if ( $_POST['touch_target_id'])
  {
    $sql = "UPDATE `targets`
        SET `target_last` = NOW()
        WHERE `target_id` = " . $_POST['touch_target_id'] ;

    $result = mysql_query($sql);

    if(!$result)
    {
        //something went wrong, display the error
        echo 'Something went wrong.';
        //echo mysql_error(); //debugging purposes, uncomment when needed
    }
    else
    {
        echo 'Successful touch!';
    }
  }


  /**
  *
  * DELETE
  *
  */

  if ( $_POST['delete_item'])
  {
    $sql = "DELETE FROM `targets`
        WHERE `target_id` = " . $_POST['delete_item'] ;

    $result = mysql_query($sql);

    if(!$result)
    {
        //something went wrong, display the error
        echo 'Something went wrong.';
        //echo mysql_error(); //debugging purposes, uncomment when needed
    }
    else
    {
        echo 'Successful delete!';
    }
  }







}
?>
