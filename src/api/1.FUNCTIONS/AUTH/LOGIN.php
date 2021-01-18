<?php

require_once(__ROOT__ . '/1.FUNCTIONS/CRUD/FETCH.php');
require_once(__ROOT__ . '/2.ITEMS/USER.php');

function login($USER_ID, $PASSWORD)
{

  if ($_SESSION['LOGIN']) {
    var_dump('Jesteś już zalogowany');
    return;
  }
  
  $user = getItems(User::$TABLE_NAME, User::$SHEME, 1, 1, array('id' => $USER_ID))[0];

  $isCorrectPassword = $user['password'] === $PASSWORD;

  if ($isCorrectPassword) {
    $_SESSION['LOGIN'] = true;
    var_dump('Pomyślnie zalogowano');

    if ($user['ADMIN']) {
      $_SESSION['ADMIN'] = true;
    }
  }

}

function logOut(){
  if ($_SESSION['LOGIN']) {
    $_SESSION['LOGIN'] = false;
    var_dump('Pomyślnie wylogowano');
  }
}
