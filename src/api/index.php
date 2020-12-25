<?php

define('__ROOT__', __DIR__);

// Include router class
include(__ROOT__ . '/1.FUNCTIONS/ROUTE/ROUTE.php');

Route::add('/', function () {
  echo 'Welcome :-)';
});

Route::add('/users', function () {
  require_once(__ROOT__. '/2.ITEMS/USER.php');
  User::GET_USERS();
},'get');

Route::add('/user', function () {
  require_once(__ROOT__ . '/2.ITEMS/USER.php');
  User::STORE_USER();
},'post');

Route::run('/');
