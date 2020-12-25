<?php

require_once(__ROOT__ . '/3.CONFIG/DATABASE.php');

function fetchItem($response)
{
  return $response->fetch(PDO::FETCH_ASSOC);
}

function fetchItems($response, $HOW_MANY, $PAGE)
{
  $itemsArr = array();

  for ($i = 0; $i < $HOW_MANY; $i++) {
    $newRow = $response->fetch(PDO::FETCH_ASSOC);
    if ($newRow) {
      array_push($itemsArr, $newRow);
    } else {
      break;
    }
  };
  return count($itemsArr) > 0 ? $itemsArr : false;
}

function sendJSON($data, $ERROR_MESSAGE)
{
  header("Access-Control-Allow-Origin: *");
  header("Content-Type: application/json; charset=UTF-8");

  if ($data) {
    http_response_code(200);
    echo json_encode($data);
  } else {
    http_response_code(404);
    echo json_encode(
      array("message" => $ERROR_MESSAGE)
    );
  }
}


function getItem($tableName, $ERROR_MESSAGE = "No item found.")
{

  $id = $_GET['id'];
  $query = 'SELECT * FROM ' . $tableName . ' WHERE id=' . $id;
  $queryConnection = Database::getQueryConnection($query);
  $items = fetchItem($queryConnection);

  sendJSON($items, $ERROR_MESSAGE);
}

function getItems($tableName, $HOW_MANY = 10, $PAGE = 1, $ERROR_MESSAGE = "No items found.")
{
  $query = "SELECT * FROM " . $tableName;
  $queryConnection = Database::getQueryConnection($query);
  $items = fetchItems($queryConnection, $HOW_MANY, $PAGE);

  sendJSON($items, $ERROR_MESSAGE);
}
