<?php

require_once(__ROOT__ . '/1.FUNCTIONS/CRUD/FETCH.php');
require_once(__ROOT__ . '/2.ITEMS/USER.php');

function login($USER_ID, $PASSWORD)
{

  if ($_SESSION['LOGIN']) {
    return;
  }
  
  $user = getItems(User::$TABLE_NAME, User::$SHEME, 1, 1, array('id' => $USER_ID));

  var_dump($user);

  $isCorrectPassword = $user['password'] === $PASSWORD;


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
