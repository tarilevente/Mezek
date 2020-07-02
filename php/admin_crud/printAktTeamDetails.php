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
  $stmt   = $con->prepare('SELECT tName, tCity FROM teamtable WHERE idTeam = ?');
  $stmt->bind_param('i', $idTeam);
  if (!$stmt->execute()) {
   $response['error']     = true;
   $response['errorCode'] = 90010;
   $response['csapat']    = "-";
   $response['varos']     = "-";
  } else {
   $stmt->store_result();
   $stmt->bind_result($response['csapat'], $response['varos']);
   $stmt->fetch();
   $stmt->close();
  }
 }
}
echo json_encode($response, JSON_UNESCAPED_UNICODE);
