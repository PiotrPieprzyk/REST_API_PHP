<?php
define('__ROOT__', dirname(dirname(dirname(__DIR__))));
require_once(__ROOT__ . '/1.FUNCTIONS/MYSQL/QUERY.php');


use PHPUnit\Framework\TestCase;

final class QueryTest extends TestCase{
  public function testGetQueryArrayShouldReturnSqlQueryArray(){
    $array = array('1', '2', '3');
    $query = getQueryArraySQL($array);

    $shouldReturn = ' (1, 2, 3) ';

    $this->assertEquals($shouldReturn,$query);
  }
}