<?php

define('__ROOT__', __DIR__);

// Include router class
include(__ROOT__ . '/1.FUNCTIONS/ROUTE/ROUTE.php');

// Require session functions

session_start();
require_once(__ROOT__ . '/1.FUNCTIONS/SESSION/LAST_ACTIVITY.php');
extendSessionOrDestroy();

var_dump($_SESSION['LOGIN']);


Route::add('/', function () {
  echo 'Welcome :-)';
});

Route::add('/user/create-table', function () {
  require_once(__ROOT__ . '/2.ITEMS/USER.php');
  User::CREATE_TABLE();
}, 'get');

Route::add('/user/drop-table', function () {
  require_once(__ROOT__ . '/2.ITEMS/USER.php');
  User::DROP_TABLE();
}, 'get');


Route::add('/user', function () {
  require_once(__ROOT__ . '/2.ITEMS/USER.php');
  User::STORE_USER();
}, 'post');

Route::add('/user', function () {
  require_once(__ROOT__ . '/2.ITEMS/USER.php');
  User::GET_USER();
}, 'get');

Route::add('/users', function () {
  require_once(__ROOT__ . '/2.ITEMS/USER.php');
  User::GET_USERS();
}, 'get');

Route::add('/login', function () {
  require_once(__ROOT__ . '/1.FUNCTIONS/AUTH/LOGIN.php');
  extract($_REQUEST);
  if ($id && $password) {
    login($id, $password);
  }
}, 'post');

Route::add('/logout', function () {
  require_once(__ROOT__ . '/1.FUNCTIONS/AUTH/LOGIN.php');
  logOut();
}, 'post');









Route::run('/');
