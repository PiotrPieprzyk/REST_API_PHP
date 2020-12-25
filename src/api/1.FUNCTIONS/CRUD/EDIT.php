<?php

require_once(__ROOT__ . '/3.CONFIG/DATABASE.php');

function getEditQuery($tableName, $id)
{

  /*
    TODO: ADD QUERY
  
  */
  return 'UPDATE ' . $tableName . ' WHERE id=' . $id;
}

function EDIT_USER($tableName)
{
  $id = $_GET['id'];

  if ($id) {
    $query = getEditQuery($tableName, $id);
    Database::getQueryConnection($query);
  }
}
