<?php

function storeItem($data, $sheme, $tableName)
{
  $newObject = array();
  foreach($sheme as $properties){
    $newObject[$properties] = $data[$properties];
  }
  // $value 
  $query = "INSERT INTO " . $tableName . " VALUES ('test', 'f')";
  var_dump($query);
  return Database::getQueryConnection($query);
}
