<?php
  // Allow from any origin
  if (isset($_SERVER['HTTP_ORIGIN'])) {
    header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
    header('Access-Control-Allow-Credentials: true');
  }

  // Access-Control headers are received during OPTIONS requests
  if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD']))
      header("Access-Control-Allow-Methods: GET, POST, OPTIONS");         

    if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']))
      header("Access-Control-Allow-Headers: {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");

    exit(0);
  }
  
  header('Content-Type: application/json; charset=utf-8');

  $received = json_decode(file_get_contents('php://input'), TRUE);

  require_once("goodreads.php");

  // we have received a request
  if(!empty($received["request"])) {
    $goodreads = new Goodreads();

    // what does the client want?
    switch ($received["request"]) {
      case "getBooks":
        $response = $goodreads->getBooks($received["authorPageURL"], $received["limit"]);
      break;
      case "getBook":
        $response = $goodreads->getBook($received["bookPageURL"]);
      break;
    }

    echo json_encode($response); // send back response
  }
?>
