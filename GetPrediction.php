<?php
ini_set('display_errors', false);
set_exception_handler('returnError');
$jsonStr = json_decode(file_get_contents(
  "http://api.wmata.com/StationPrediction.svc/json/GetPrediction/" . $_GET["station"] . "?api_key=YOURKEYHERE"));
$trains = $jsonStr->Trains;
for ($i = 0; $i < count($trains); $i++) {
  unset($trains[$i]->DestinationName);
  unset($trains[$i]->LocationName);
  }
echo json_encode($jsonStr);

function returnError() {
  echo '{"error":true}';
  }
?>
