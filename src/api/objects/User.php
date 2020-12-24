<?php
require_once(__ROOT__ . '/config/database.php');
require_once(__ROOT__ . '/helpers/fetchItems.php');

class User
{
  public static $TABLE_NAME = 'users';

  public static function GET_USERS()
  {
    getItems("SELECT * FROM " . self::$TABLE_NAME);
  }

  public static function GET_USER()
  {
    /* 
      TODO: GET USER
    */
  }

  public static function STORE_USERS()
  {

    /* 
      TODO: STORE_USERS
    */
  }

  public static function EDIT_USERS()
  {
    /* 
      TODO: EDIT_USERS
    */
  }

  public static function DELETE_USERS()
  {
    /* 
      TODO: DELETE_USERS
    */
  }
}
