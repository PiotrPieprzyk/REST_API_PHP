<?php

class Database
{

  // specify your own database credentials


  // get the database connection
  public static function getConnection()
  {

    $servername = "db";
    $username = "root";
    $password = "example";
    $dbname = "test";
    $port = "3306";

    try {
      return new PDO("mysql:host=$servername;port=$port;dbname=$dbname", $username, $password);
    } catch (PDOException $e) {
      /* 
        TODO: Create error if API can't get access to DATABASE.
      */
    }
  }

  public static function getByQuery($query)
  {
    $db = self::getConnection();
    $result = $db->prepare($query);
    $result->execute();

    return $result;
  }
}
