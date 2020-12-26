<?php
require_once(__ROOT__ . '/3.CONFIG/DATABASE.php');
require_once(__ROOT__ . '/1.FUNCTIONS/CRUD/FETCH.php');
require_once(__ROOT__ . '/1.FUNCTIONS/CRUD/STORE.php');
require_once(__ROOT__ . '/1.FUNCTIONS/CRUD/DELETE.php');
require_once(__ROOT__ . '/1.FUNCTIONS/MYSQL/CREATE_TABLE.php');



class User
{
  public static $TABLE_NAME = 'users';

  public static $SHEME = array(
    'id' => array(
      'name' => 'id',
      'sql' => 'INT AUTO_INCREMENT, primary key(id)'
    ),
    'name' => array(
      'name' => 'name',
      'sql' => 'VARCHAR(20) NOT NULL'
    ),
    'email' => array(
      'name' => 'email',
      'sql' => 'VARCHAR(20) NOT NULL'
    ),
    'password' => array(
      'name' => 'password',
      'sql' => 'VARCHAR(20) NOT NULL'
    ),
  );

  public static function CREATE_TABLE(){
    CREATE_TABLE(self::$TABLE_NAME,self::$SHEME);
  }

  public static function DROP_TABLE(){
    DROP_TABLE(self::$TABLE_NAME);
  }

  public static function GET_USERS()
  {
    
    $users = getItems(self::$TABLE_NAME);

    sendJSON($users);
  }

  public static function GET_USER()
  {
    $id = $_GET['id'];

    $user = getItem(self::$TABLE_NAME,$id);

    sendJSON($user);
    /* 
      TODO: GET USER
    */
  }

  public static function STORE_USER()
  {
    storeItem($_REQUEST, self::$SHEME, self::$TABLE_NAME);
  }

  public static function EDIT_USER()
  {
    /* 
      TODO: EDIT_USER
    */
  }

  public static function DELETE_USER()
  {
    DELETE_USER(self::$TABLE_NAME);
    
    /* 
      TODO: DELETE_USER
    */
  }
}
