<?php

class Database
{

  // specify your own database credentials
  private $servername = "db";
  private $username = "root";
  private $password = "example";
  private $dbname = "test";
  private $port = "3306";
  public $conn;

  // get the database connection
  public function getConnection()
  {

    $this->conn = null;

    try {
      $this->conn = new PDO("mysql:host=$this->servername;port=$this->port;dbname=$this->dbname", $this->username, $this->password);
      echo "Connected succesfully";
    } catch (PDOException $e) {
      echo "Connection failed: " . $e->getMessage();
    }

    return $this->conn;
  }
}
