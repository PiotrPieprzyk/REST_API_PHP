<?php

require_once(__ROOT__ . '/3.CONFIG/DATABASE.php');

function getQueryArraySQL($arrayValues)
{
  $queryStart = ' (';
  $queryEnd = ') ';
  $queryArraySQL = '';

  $first = true;
  foreach ($arrayValues as $value) {

    $queryArraySQL = $first ? $queryArraySQL . $value : $queryArraySQL . ', ' . $value;

    if ($first) {
      $first = false;
    }
  }

  return $queryStart . $queryArraySQL . $queryEnd;
}

function getValuesQueryBasedOnSheme($data, $sheme)
{
  $valuesBasedOnSheme = array();
  foreach ($sheme as $properties) {
    if ($data[$properties['name']]) {
      $valuesBasedOnSheme[$properties['name']] = "'". $data[$properties['name']] . "'";
    } else {
      $valuesBasedOnSheme[$properties['name']] = 'NULL';
    }
  }

  return getQueryArraySQL($valuesBasedOnSheme);
}

function getColumnsQueryBasedOnSheme($sheme)
{

  function getColumnName($i)
  {
    return $i['name'] . ' ' . $i['sql'];
  }

  $columns = array_map('getColumnName', $sheme);
  return getQueryArraySQL($columns);
}
