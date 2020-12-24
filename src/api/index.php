<?php

define('__ROOT__', __DIR__);

// Include router class
include('./Route.php');

// Include read class

Route::add('/', function () {
  echo 'Welcome :-)';
});

Route::add('/users', function () {
  require_once(__ROOT__. '/objects/User.php');
  User::GET_USERS();
});

Route::run('/');
