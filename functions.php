<?php

// TODO: CANVAS



/**
*
* GLOBALS
*
*/

$w_px       = 1000; // view items total pixel width
$h_px       = 600; // view items total pixel height
$w_p_delay  = 20;   // percent of total pixel width for delay region
$w_p_goal   = 40;   // percent of total pixel width for goal region
$w_p_fail   = 40;   // percent of total pixel width for fail region



/**
*
* FUNCTIONS
*
*/

function app() {
  if(isset($_SESSION['signed_in']) && $_SESSION['signed_in'] == true) {
    box__new();
    box__view();
  }

}



function user_signin() {
?><div class="box">
    <form method="post" action="">
      Username: <input type="text" name="user_name" />
      Password: <input type="password" name="user_pass">
      <input type="submit" value="Sign in" />
    </form>
  </div><?php
}

function box__view() {

  // Old, delete when done with canvas version below:
  print_matrix();



global $w_px;
global $h_px;
global $w_p_delay;
global $w_p_goal;
global $w_p_fail;
$w_px_delay = $w_px*$w_p_delay/100;
$w_px_goal = $w_px*$w_p_goal/100 + $w_px_delay;
$w_px_fail = $w_px;

  // Create canvas and background for our view of items
  echo '<div class="box">
          <canvas id="canvas-view-items" width="'.$w_px.'" height="'.$h_px.'">
            Canvas element should have been here.
          </canvas>
        </div>

        <script>
          var w_px = '.$w_px.';
          var h_px = '.$h_px.';
          var w_px_delay = '.$w_px_delay.';
          var w_px_goal = '.$w_px_goal.';
          var w_px_fail = '.$w_px_fail.';

          var c = document.getElementById("canvas-view-items");
          var ctx = c.getContext("2d");

          ctx.fillStyle = "#DDDDDD";
          ctx.fillRect(w_px-w_px_delay,0,w_px_delay,h_px);

          ctx.strokeStyle = "#00FF00";
          ctx.beginPath();
          ctx.moveTo(w_px-w_px_goal,0);
          ctx.lineTo(w_px-w_px_goal,h_px);
          ctx.stroke();
          ctx.closePath();

          ctx.strokeStyle = "#FF0000";
          ctx.beginPath();
          ctx.moveTo(0,0);
          ctx.lineTo(0,h_px);
          ctx.stroke();
          ctx.closePath();

          ctx.font = "24px Sans-Serif";
          ctx.fillStyle = "#BBBBBB";
          ctx.textBaseline = "top";
          ctx.textAlign = "center";
          ctx.fillText("INACTIVE", w_px-w_px_delay/2, 0);
          ctx.fillText("ACTIVE", (w_px-w_px_goal+w_px-w_px_delay)/2, 0);
          ctx.fillText("LATE", (w_px-w_px_goal)/2, 0);

          ctx.font = "16px Sans-Serif";
          ctx.fillStyle = "#888888";
          ctx.textBaseline = "top";
          ctx.textAlign = "left";
          ctx.fillText(" DELAY", w_px-w_px_delay, 0);
          ctx.fillText(" GOAL", w_px-w_px_goal, 0);
          ctx.fillText(" FAIL", 0, 0);

        </script>
        ';

  $item_array = get_items();
  // Draw items
  echo '<script>
          var c = document.getElementById("canvas-view-items");
          var ctx = c.getContext("2d");

          var img_check = new Image();
              img_check.src = "images/icon_check.png";
          var img_delete = new Image();
              img_delete.src = "images/icon_delete.png";
          img_check.onload = function() { ctx.drawImage(img_check, '.$item_array['w_px'].', 30, 16, 16); };
          img_delete.onload = function() { ctx.drawImage(img_delete, '.$item_array['w_px'].'+16, 30, 16, 16); };

        </script>
        ';
}

function get_items() {
  return array("w_px"=>"143","h_px"=>"69");
}



function box__new() {
?><div id="new-item-form-container" class="box">
    <form method="post" action="">
      <div class="new-item-input-container">New Item Name: <input type="text" name="new_item_name" autofocus /></div>
      <div class="new-item-input-container">Hours Delay before Item Active: <input type="text" name="item_time_delay" /></div>
      <div class="new-item-input-container">Total Hours to Goal Time: <input type="text" name="item_time_goal" /></div>
      <div class="new-item-input-container">Total Hours to Fail Time: <input type="text" name="item_time_fail" /></div>
      <div class="new-item-input-container"><input type="submit" value="Add" /></div>
    </form>
  </div><?php
}












function print_matrix() {
  $user_id = $_SESSION['user_id'];
  $sql = "SELECT
            target_id,
            target_text,
            target_time_delay_hours,
            target_time_goal_hours,
            target_time_fail_hours,
            TIME_TO_SEC ( TIMEDIFF( NOW(), target_last ) ) / 60 / 60 AS target_last_decimal,
            target_time_goal_hours - TIME_TO_SEC ( TIMEDIFF( NOW(), target_last ) ) / 60 / 60 AS hours_remaining
          FROM `targets`
          WHERE `target_user` = $user_id
          ORDER BY hours_remaining";
  $result = mysql_query($sql);
  if ( mysql_num_rows( $result ) != 0 ) {

    $item_pixels_top_increment = 45;
    echo '<div class="box" style="width:1200px">
            <div id="view-item-container">';
    $item_pixels_top = 0; // initialize for items

    while ( $row = mysql_fetch_assoc( $result ) ) {

      $item_pixels_left = get_item_pixels_left(
          $row['target_last_decimal'], // $time (hours)
          $row['target_time_delay_hours'], // $delay (hours)
          $row['target_time_goal_hours'], // $goal (hours)
          $row['target_time_fail_hours'] // $fail (hours)
          );

      echo '<div class="view-item"
            style="left: ' . $item_pixels_left . 'px;
                    top: ' . $item_pixels_top . 'px;
                    ">' .

              '<form method="post" action="">

                <span  title="">' .
                  $row['target_text'] .
                  ' ( ' . intval( $row['hours_remaining'] ) . ' hours remaining )' .
                '</span>

                <input id="check-'. $row['target_id'] . '"
                        type="checkbox"
                        onChange = "this.form.submit()"
                        name="touch_target_id"
                        value="' . $row['target_id'] . '">
                <label for="check-'. $row['target_id'] . '">check</label>

                <input id="delete-'. $row['target_id'] . '"
                        type="checkbox"
                        onclick = "this.form.submit()"
                        name="delete_item"
                        value="' . $row['target_id'] . '">
                <label for="delete-'. $row['target_id'] . '">delete</label>

                </form>
              </div>' ;


            $item_pixels_top += $item_pixels_top_increment;
    }
    echo ' </div>
          </div>';

    echo '
    <script type="text/javascript">
      window.onload = function() {
        document.getElementById("view-item-container").style.height = "'.$item_pixels_top.'px";
        document.getElementById("view-item-container").style.width = "1500px";
      }
    </script>
    ';

  }
}



function get_item_pixels_left( $time, $delay, $goal, $fail ) {
// $time : hours passed since last check

global $w_px;
global $w_p_delay;
global $w_p_goal;
global $w_p_fail;

  $w_delay_px = $w_px * $w_p_delay / 100;
  $w_goal_px  = $w_px * $w_p_goal / 100;
  $w_fail_px  = $w_px * $w_p_fail / 100;

  $px_from_right = null;

  // y = mx + b
  $m = null;
  $x = null;
  $b = null;

  if ( $delay && $time < $delay ) {
    $m = $w_delay_px / $delay;
    $x = $time;
  } else if ( $goal && $time < $goal ) {
    $b = $w_delay_px;
    $m = ( $w_goal_px - $w_delay_px ) / ( $goal - $delay );
    $x = $time - $delay;
  } else if ( $fail && $time < $fail ) {
    $b = $w_delay_px + $w_goal_px;
    $m = ( $w_fail_px - $w_goal_px - $w_delay_px ) / ( $fail - $goal );
    $x = $time - $goal;
  } else {
    $b = $w_px;
    $m = 0;
    $x = 0;
  }

  $px_from_right = $m * $x + $b;

  $px_from_left = $w_px - $px_from_right;
  return $px_from_left;
}




function printtouchlist( $user_id )
{
  $sql = "SELECT target_id, target_text, TIMEDIFF( NOW(),target_last ) AS diffdate
      FROM  `targets`
      WHERE `target_user` = $user_id
      ORDER BY  `target_last`";

  $result = mysql_query($sql);

  if ( !result ) echo 'No result!';
  else
  {
    if ( mysql_num_rows( $result ) == 0 ) echo 'No rows!';
    else
    {
      echo '<form method="post" action="">
              <div id="item-container">';
      while ( $row = mysql_fetch_assoc( $result ) )
      {
        echo '<div class="item">' .
            '<span class="item-checkbox"><input type="checkbox" ' .
                'onChange = "this.form.submit()" ' .
                'name="touch_target_id" ' .
                'value="' . $row['target_id'] . '"></span>' .
            '<span class="item-name">' . $row['target_text'] . '</span>' .
            '<span class="item-time">' . $row['diffdate'] . '</span>' .
            '</div>';
      }
      echo '</div>
          </form>';
    }
  }

}





?>
