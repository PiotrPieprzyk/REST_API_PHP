<?php
require_once(__ROOT__ . '/config/database.php');
require_once(__ROOT__ . '/helpers/CRUD_FUNCTIONS/fetchItems.php');
require_once(__ROOT__ . '/helpers/CRUD_FUNCTIONS/storeItem.php');


class User
{
  public static $TABLE_NAME = 'users';
  public static $SHEME = array('name', 'sex');

  public static function GET_USERS()
  {
    getItems(self::$TABLE_NAME);
  }

  public static function GET_USER()
  {
    /* 
      TODO: GET USER
    */
  }

  public static function STORE_USER()
  {

    storeItem(array('name' => 'test', 'sex' => 'f'), self::$SHEME, self::$TABLE_NAME);
  }

  public static function EDIT_USER()
  {
    /* 
      TODO: EDIT_USER
    */
  }

  public static function DELETE_USER()
  {
    /* 
      TODO: DELETE_USER
    */
  }
}
