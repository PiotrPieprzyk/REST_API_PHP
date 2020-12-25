<?php

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

function getItems($tableName, $HOW_MANY = 10, $PAGE = 1, $ERROR_MESSAGE = "No items found.")
{
  header("Access-Control-Allow-Origin: *");
  header("Content-Type: application/json; charset=UTF-8");

  $query = "SELECT * FROM " . $tableName;

  $queryConnection = Database::getQueryConnection($query);
  $items = fetchItems($queryConnection, $HOW_MANY, $PAGE);

  if ($items) {
    http_response_code(200);
    echo json_encode($items);
  } else {
    http_response_code(404);
    echo json_encode(
      array("message" => $ERROR_MESSAGE)
    );
  }
}