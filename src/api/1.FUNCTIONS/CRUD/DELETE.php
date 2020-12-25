<?php

require_once(__ROOT__ . '/3.CONFIG/DATABASE.php');

function getDeleteQuery($tableName, $id)
{
  return 'DELETE FROM ' . $tableName . ' WHERE id=' . $id;
}

function DELETE_USER($tableName)
{
  $id = $_GET['id'];

  if ($id) {
    $query = getDeleteQuery($tableName, $id);
    Database::getQueryConnection($query);
  }
}
