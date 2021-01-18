<?php

require_once(__ROOT__ . '/3.CONFIG/DATABASE.php');

function mymapper($arrayparam, $valuecallback)
{
  $resultarr = array();
  foreach ($arrayparam as $key => $value) {
    $resultarr[] = $valuecallback($key, $value);
  }
  return $resultarr;
}

function getValuesWithQuoteMarks($array)
{
  $arrayWithQuoteMarks = array_map(function ($item) {
    $valueWithQuoteMarks = gettype($item) === 'string' ? "'" . $item . "'" : $item;
    return $valueWithQuoteMarks;
  }, $array);

  return $arrayWithQuoteMarks;
}


function getValuesQueryBasedOnSheme($data, $sheme)
{
  $values = array();
  foreach ($sheme as $properties) {
    $singleData = $data[$properties['name']];
    $value = $singleData ? "'" . $singleData . "'" : 'NULL';
    $values[$properties['name']] = $value;
  }

  return $values;
}

function getColumnsQuery($sheme)
{
  $columns = array_map(function ($i) {
    return $i['name'] . ' ' . $i['sql'];
  }, $sheme);

  return $columns;
}

function getValuesQuery($data){
  $arrayWithQuoteMarks = getValuesWithQuoteMarks($data);
  array_unshift($arrayWithQuoteMarks, 'NULL');
  return implode(', ', $arrayWithQuoteMarks);
}

function getSetArraySQL($data, $sheme){
  $arrayWithQuoteMarks = getValuesWithQuoteMarks($data);

  $implodedArray = mymapper($arrayWithQuoteMarks, function ($key, $value) {
    return $key . '=' . $value;
  });

  $arraySQL = implode(', ', $implodedArray);

  return ' SET ' . $arraySQL;
}

function getFilterQuery($data)
{

  $arrayWithQuoteMarks = getValuesWithQuoteMarks($data);

  $implodedArray = mymapper($arrayWithQuoteMarks, function ($key, $value) {
    return $key . '=' . $value;
  });

  $arraySQL = implode(' AND ', $implodedArray);

  return ' WHERE ' . $arraySQL;
}


function getPagination($page, $rowsOfPage)
{
  $offset = ($page - 1) * $rowsOfPage;
  return ' OFFSET ' . $offset . ' ROWS FETCH NEXT ' . $rowsOfPage . ' ROWS ONLY';
}


class QuerySQL
{
  public static function getCreateTableQuery($tableName, $sheme)
  {
    $columns = ' (' . implode(', ', getColumnsQuery($sheme)) . ') ';
    $query = 'CREATE TABLE ' . $tableName . $columns;
    return $query;
  }

  public static function getDropTableQuery($tableName)
  {
    $query = 'DROP TABLE ' . $tableName;
    return $query;
  }

  public static function getStoreItemQuery($tableName, $sheme, $data)
  {
    $query = 'INSERT INTO '  . $tableName . ' VALUES (' . getValuesQuery($data) . ') ';

    return $query;
  }

  public static function getDeleteItemQuery($tableName, $sheme, $filter)
  {

    $query = 'DELETE FROM ' . $tableName . getFilterQuery($filter, $sheme);

    return $query;
  }

  public static function getItemsQuery($tableName, $sheme, $page, $rowsOfPage, $filter)
  {
    $filterQuery = $filter ? getFilterQuery($filter, $sheme) : '';
    $paginationQuery = $page && $rowsOfPage ? getPagination($page, $rowsOfPage) : '';

    $query = 'SELECT * FROM ' . $tableName . $filterQuery . $paginationQuery;
    return $query;
  }

  public static function getEditItemQuery($tableName, $sheme, $filter, $data)
  {
    $filterQuery = $filter ? getFilterQuery($filter, $sheme) : false;
    $setQuery = getSetArraySQL($data, $sheme);

    if ($filterQuery) {
      $query = 'UPDATE ' . $tableName . $setQuery . $filterQuery;
    }
    return $query;
  }
}
