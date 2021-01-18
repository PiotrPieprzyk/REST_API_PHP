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
    $valueIsNull = $item === 'NULL';
    if ($valueIsNull) {
      return $item;
    }
    $valueWithQuoteMarks = gettype($item) === 'string' ? "'" . $item . "'" : $item;

    return $valueWithQuoteMarks;
  }, $array);

  return $arrayWithQuoteMarks;
}


function getValuesBasedOnSheme($data, $sheme, $passStringNullIfNull)
{
  $values = array();
  foreach ($sheme as $properties) {
    if ($properties['name'] === 'id') {
      if ($passStringNullIfNull) {
        $values[$properties['name']] = 'NULL';
      }
    } else {
      $singleData = $data[$properties['name']];
      $value = $singleData ? $singleData : 'NULL';
      if ($value === 'NULL') {
        if ($passStringNullIfNull) {
          $values[$properties['name']] = $value;
        }
      } else {
        $values[$properties['name']] = $value;
      }
    }
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


function getSetArraySQL($data, $sheme)
{
  $onlyDataPassingToSheme = getValuesBasedOnSheme($data, $sheme, false);
  unset($onlyDataPassingToSheme['id']);

  $arrayWithQuoteMarks = getValuesWithQuoteMarks($onlyDataPassingToSheme);

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
  return ' ORDER BY id LIMIT ' . $offset . ', ' . $rowsOfPage;
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
    $valuesBasedOnSheme = getValuesBasedOnSheme($data, $sheme, true);
    $valuesWithQuoteMarks = getValuesWithQuoteMarks($valuesBasedOnSheme);
    $values = implode(', ', $valuesWithQuoteMarks);
    $query = 'INSERT INTO '  . $tableName . ' VALUES (' . $values . ') ';

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
