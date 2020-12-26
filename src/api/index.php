<?php

define('__ROOT__', __DIR__);

// Include router class
require_once(__ROOT__ . '/1.FUNCTIONS/ROUTE/ROUTE.php');

// Require session functions

session_start();
require_once(__ROOT__ . '/1.FUNCTIONS/SESSION/LAST_ACTIVITY.php');
extendSessionOrDestroy();

Route::add('/', function () {
  echo 'Welcome :-)';
});

// AUTH ROUTES

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

// USER ROUTES

if ($_SESSION['LOGIN']) {

  require_once(__ROOT__ . '/2.ITEMS/USER.php');

  Route::add('/user/create-table', function () {
    User::CREATE_TABLE();
  }, 'get');

  Route::add('/user/drop-table', function () {
    User::DROP_TABLE();
  }, 'get');

  Route::add('/user', function () {
    User::STORE_USER();
  }, 'post');

  Route::add('/user', function () {
    User::GET_USER();
  }, 'get');

  Route::add('/users', function () {
    User::GET_USERS();
  }, 'get');

  Route::add('/user', function () {
    User::DELETE_USER();
  }, 'delete');
}











Route::run('/');
