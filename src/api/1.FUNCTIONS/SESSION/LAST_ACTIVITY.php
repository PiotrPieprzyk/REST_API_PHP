<?php

/* 

  Last activity session 
  https://stackoverflow.com/questions/520237/how-do-i-expire-a-php-session-after-30-minutes/1270960#1270960
  
*/

function extendSessionOrDestroy()
{
  if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > 1800)) {
    // last request was more than 30 minutes ago
    session_unset();     // unset $_SESSION variable for the run-time 
    session_destroy();   // destroy session data in storage
  }
  $_SESSION['LAST_ACTIVITY'] = time();

  if (!isset($_SESSION['CREATED'])) {
    $_SESSION['CREATED'] = time();
  } else if (time() - $_SESSION['CREATED'] > 1800) {
    // session started more than 30 minutes ago
    session_regenerate_id(true);    // change session ID for the current session and invalidate old session ID
    $_SESSION['CREATED'] = time();  // update creation time
  }
}
