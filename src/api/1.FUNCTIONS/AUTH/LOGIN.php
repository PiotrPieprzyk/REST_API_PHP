<?php

require_once(__ROOT__ . '/1.FUNCTIONS/CRUD/FETCH.php');

function login($USER_ID, $PASSWORD)
{

  if ($_SESSION['LOGIN']) {
    return;
  }

  $user = getItem("users", $USER_ID);

  $isCorrectPassword = $user['password'] === $PASSWORD;

  var_dump($isCorrectPassword);

  if ($isCorrectPassword) {
    $_SESSION['LOGIN'] = true;

    if ($user['ADMIN']) {
      $_SESSION['ADMIN'] = true;
    }
  }

  var_dump($_SESSION['LOGIN']);
}

function logOut(){
  if ($_SESSION['LOGIN']) {
    $_SESSION['LOGIN'] = false;
  }
}
