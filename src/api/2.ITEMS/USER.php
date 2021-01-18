<?php
require_once(__ROOT__ . '/3.CONFIG/DATABASE.php');
require_once(__ROOT__ . '/1.FUNCTIONS/CRUD/FETCH.php');
require_once(__ROOT__ . '/1.FUNCTIONS/MYSQL/QUERY.php');



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

  public static function CREATE_TABLE()
  {
    $query = QuerySQL::getCreateTableQuery(self::$TABLE_NAME, self::$SHEME);
    Database::getQueryConnection($query);
  }

  public static function DROP_TABLE()
  {
    $query = QuerySQL::getDropTableQuery(self::$TABLE_NAME);
    Database::getQueryConnection($query);
  }

  public static function GET_USERS()
  {

    $users = getItems(self::$TABLE_NAME, self::$SHEME, 1, 10, NULL);

    sendJSON($users);
  }

  public static function GET_USER()
  {
    $id = $_GET['id'];

    $user = getItems(self::$TABLE_NAME, self::$SHEME, 1, 1, array('id' => $id));

    sendJSON($user);
  }

  public static function STORE_USER()
  {
    $query = QuerySQL::getStoreItemQuery(self::$TABLE_NAME, self::$SHEME, $_REQUEST );
    Database::getQueryConnection($query);
  }

  public static function EDIT_USER()
  {
    $id = $_REQUEST['id'];
    $query = QuerySQL::getEditItemQuery(self::$TABLE_NAME, self::$SHEME, array('id'=>$id), $_REQUEST);
    Database::getQueryConnection($query);
  }

  public static function DELETE_USER()
  {
    $id = $_GET['id'];

    if ($id) {
      $query = QuerySQL::getDeleteItemQuery(self::$TABLE_NAME, self::$SHEME, array(
        'id' => $id,
      ));

      Database::getQueryConnection($query);
    }
  }
}
