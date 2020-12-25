<?php
require_once(__ROOT__ . '/1.FUNCTIONS/MYSQL/QUERY.php');
require_once(__ROOT__ . '/3.CONFIG/DATABASE.php');

function CREATE_TABLE($tableName, $sheme)
{

  $queryStart = 'CREATE TABLE ' . $tableName;
  $columns = getColumnsQueryBasedOnSheme($sheme);
  $query = $queryStart . $columns;
  var_dump($query);
  Database::getQueryConnection($query);
}

function DROP_TABLE($tableName)
{

  $query = 'DROP TABLE ' . $tableName;
  var_dump($query);
  Database::getQueryConnection($query);
}
