<?php
define('__ROOT__', dirname(dirname(dirname(__DIR__))));
require_once(__ROOT__ . '/1.FUNCTIONS/MYSQL/QUERY.php');
require_once(__ROOT__ . '/2.ITEMS/USER.php');

use PHPUnit\Framework\TestCase;

final class QueryTest extends TestCase
{

  private $exampleUserProvider = array(
    'tableName' => 'users',
    'sheme' => array(
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
    ),

  );

  /**
   * @dataProvider createTableProvider
   */
  public function testGetCreateTableQuery($tableName, $sheme, $expected)
  {
    $query = QuerySQL::getCreateTableQuery($tableName, $sheme);
    $this->assertEquals($expected, $query);
  }

  public function createTableProvider()
  {
    $expected = 'CREATE TABLE users (id INT AUTO_INCREMENT, primary key(id), name VARCHAR(20) NOT NULL, email VARCHAR(20) NOT NULL, password VARCHAR(20) NOT NULL) ';
    return [
      'user table name and sheme return CREATE TABLE {tableName} ({columns})' => [
        $this->exampleUserProvider['tableName'],
        $this->exampleUserProvider['sheme'],
        $expected
      ],
    ];
  }

  /**
   * @dataProvider dropTableProvider
   */
  public function testGetDropTableQuery($tableName, $expected)
  {
    $query = QuerySQL::getDropTableQuery($tableName);

    $this->assertEquals($expected, $query);
  }

  public function dropTableProvider()
  {
    return [
      'user table return DROP TABLE {tableName}' => ['users', 'DROP TABLE users'],
    ];
  }

  /**
   * @dataProvider storeItemProvider
   */
  public function testGetStoreItemQuery($tableName, $sheme, $data, $expected)
  {
    $query = QuerySQL::getStoreItemQuery($tableName, $sheme, $data);
    $this->assertEquals($expected, $query);
  }

  public function storeItemProvider()
  {
    $storeData =
      array(
        'name' => 'Piotr',
        'email' => 'piotr.pieprzy@onet.pl',
        'password' => '123123'
      );
    $expected = "INSERT INTO users VALUES (NULL, 'Piotr', 'piotr.pieprzy@onet.pl', '123123') ";

    return [
      'users tableName, sheme, and data return INSERT INTO {tableName} VALUES ({values})' => [
        $this->exampleUserProvider['tableName'],
        $this->exampleUserProvider['sheme'],
        $storeData,
        $expected
      ],
    ];
  }

  /**
   * @dataProvider deleteItemProvider
   */
  public function testGetDeleteItemQuery($tableName, $sheme, $filter, $expected)
  {
    $query = QuerySQL::getDeleteItemQuery($tableName, $sheme, $filter);
    $this->assertEquals($expected, $query);
  }

  public function deleteItemProvider()
  {
    return [
      'users tableName and filter return DELETE FROM {tableName} {filter}' => [
        $this->exampleUserProvider['tableName'],
        $this->exampleUserProvider['sheme'],
        array(
          'id' => '1',
        ),
        "DELETE FROM users WHERE id='1'"
      ],
    ];
  }

  /**
   * @dataProvider getItemsProvider
   */
  public function testgetItems($tableName, $sheme, $page, $rowsOfPage, $filter, $expected)
  {
    $query = QuerySQL::getItemsQuery($tableName, $sheme, $page, $rowsOfPage, $filter);
    $this->assertEquals($expected, $query);
  }

  public function getItemsProvider()
  {
    return [
      'users tableName, page, rowsOfPage, and filter return SELECT * FROM {tableName} OFFSET {page} ROWS FETCH NEXT {rowsOfPage} ROWS ONLY' => [
        $this->exampleUserProvider['tableName'],
        $this->exampleUserProvider['sheme'],
        1,
        10,
        null,
        "SELECT * FROM users ORDER BY id LIMIT 0, 10"
      ],
      'page=2 rowsOfPage=50' => [
        $this->exampleUserProvider['tableName'],
        $this->exampleUserProvider['sheme'],
        2,
        50,
        null,
        "SELECT * FROM users ORDER BY id LIMIT 50, 50"
      ],
      'filter id=1' => [
        $this->exampleUserProvider['tableName'],
        $this->exampleUserProvider['sheme'],
        null,
        null,
        array(
          'id' => '1',
        ),
        "SELECT * FROM users WHERE id='1'"
      ],
    ];
  }

  /**
   * @dataProvider editItemProvider
   */
  public function testgetEditItemQuery($tableName, $sheme, $filter, $data, $expected)
  {
    $query = QuerySQL::getEditItemQuery($tableName, $sheme, $filter, $data);
    $this->assertEquals($expected, $query);
  }

  public function editItemProvider()
  {
    return [
      'users tableName, sheme, filter, and data return UPDATE users SET {data} {filter}' => [
        $this->exampleUserProvider['tableName'],
        $this->exampleUserProvider['sheme'],
        array(
          'id' => '1',
        ),
        array(
          'name' => 'Piotr',
          'email' => 'piotr@op.pl',
        ),
        "UPDATE users SET name='Piotr', email='piotr@op.pl' WHERE id='1'"
      ],
      'email = fake@op.pl' => [
        $this->exampleUserProvider['tableName'],
        $this->exampleUserProvider['sheme'],
        array(
          'id' => '1',
        ),
        array(
          'email' => 'fake@op.pl',
        ),
        "UPDATE users SET email='fake@op.pl' WHERE id='1'"
      ],
    ];
  }
}
