<?php
  // Allow from any origin
  if (isset($_SERVER['HTTP_ORIGIN'])) {
    header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
    header('Access-Control-Allow-Credentials: true');
    //header('Access-Control-Max-Age: 86400');    // cache for 1 day
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

  $data = json_decode(file_get_contents('php://input'), TRUE);

  // we have received a request
  if(!empty($data["request"])) {
    // what does the client want?
    switch ($data["request"]) {
      case "getBooks":
        $books[] = [ 'id' => '1', 'title' => 'testTitle1', 'partialDescription' => 'testPartialDescription1', 'description' => 'testDescription1', 'coverURL' => 'testCover1', 'rating' => '1'];
        $books[] = [ 'id' => '2', 'title' => 'testTitle2', 'partialDescription' => 'testPartialDescription2', 'description' => 'testDescription2', 'coverURL' => 'testCover2', 'rating' => '2'];
        $books[] = [ 'id' => '3', 'title' => 'testTitle3', 'partialDescription' => 'testPartialDescription3', 'description' => 'testDescription3', 'coverURL' => 'testCover3', 'rating' => '3'];
        $books[] = [ 'id' => '4', 'title' => 'testTitle4', 'partialDescription' => 'testPartialDescription4', 'description' => 'testDescription4', 'coverURL' => 'testCover4', 'rating' => '4'];
        $books[] = [ 'id' => '5', 'title' => 'testTitle5', 'partialDescription' => 'testPartialDescription5', 'description' => 'testDescription5', 'coverURL' => 'testCover5', 'rating' => '5'];
        $books[] = [ 'id' => '6', 'title' => 'testTitle6', 'partialDescription' => 'testPartialDescription6', 'description' => 'testDescription6', 'coverURL' => 'testCover6', 'rating' => '6'];

        $response = $books;
        error_log("No suitable request received3");
    }

    echo json_encode($response); // send back response
  }
?>
