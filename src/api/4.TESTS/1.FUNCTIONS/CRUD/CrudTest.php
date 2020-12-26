<?php

define('__ROOT__', dirname(dirname(dirname(__DIR__))));
require_once(__ROOT__ . '/1.FUNCTIONS/CRUD/STORE.php');
require_once(__ROOT__ . '/2.ITEMS/USER.php');

use PHPUnit\Framework\TestCase;

final class CrudTest extends TestCase
{
  public function testStoreQuerySqlShouldReturnStoreSqlQuery()
  {
    $data = array('name' => "Piotr", "email" => "piotr@op.pl", "password" => "123123");
    $sheme = User::$SHEME;
    $tableName = User::$TABLE_NAME;
    $query = getStoreQuerySQL($data, $sheme, $tableName);

    $shouldReturn = "INSERT INTO users VALUES (NULL, 'Piotr', 'piotr@op.pl', '123123') ";

    $this->assertEquals($shouldReturn, $query);
  }
}
