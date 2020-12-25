<?php
require_once(__ROOT__ . '/1.FUNCTIONS/MYSQL/QUERY.php');

function getStoreQuerySQL($data, $sheme, $tableName)
{
  $queryStart = 'INSERT INTO '  . $tableName . ' VALUES';
  $valuesQuerySQL = getValuesQueryBasedOnSheme($data, $sheme);

  $query = $queryStart . $valuesQuerySQL;

  return $query;
}

function storeItem($data, $sheme, $tableName)
{
  $query = getStoreQuerySQL($data, $sheme, $tableName);
  var_dump($query);
  Database::getQueryConnection($query);
}
