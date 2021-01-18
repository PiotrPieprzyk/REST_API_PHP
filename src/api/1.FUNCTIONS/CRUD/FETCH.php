<?php

require_once(__ROOT__ . '/3.CONFIG/DATABASE.php');

function fetchItems($response, $HOW_MANY)
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

function sendJSON($data, $ERROR_MESSAGE = "Not find items")
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

function getItems($tableName, $sheme, $page, $rowsOfPage, $filter)
{
  $query = QuerySQL::getItemsQuery($tableName, $sheme, $page, $rowsOfPage, $filter);
  $queryConnection = Database::getQueryConnection($query);
  $items = fetchItems($queryConnection, $rowsOfPage, $page);
  return $items;
}
