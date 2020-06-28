<?php
require '../../config/connect.php';
require '../../config/functions.php';

$response['error']  = false;
$response['csapat'] = "";
$response['varos']  = "";

if (isset($_POST['reset']) && 'reset' === $_POST['reset']) {
 $response['csapat'] = "-";
 $response['varos']  = "-";
} else {
 if (isset($_POST['idTeam']) && !empty($_POST['idTeam'])) {
  $idTeam = $_POST['idTeam'];
  $sql    = "SELECT * FROM teamtable WHERE idTeam = " . $idTeam;
  $res    = $con->query($sql);
  if (!$res) {
   $response['error']     = true;
   $response['errorCode'] = 90010;
   $response['csapat']    = "-";
   $response['varos']     = "-";
  } else {
   while ($row = mysqli_fetch_assoc($res)) {
    $response['csapat'] = $row['tName'];
    $response['varos']  = $row['tCity'];
   }
   ;
  }
 }
}
echo json_encode($response, JSON_UNESCAPED_UNICODE);
