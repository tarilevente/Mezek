<?php
require '../../config/connect.php';
require '../../config/functions.php';

$response['error'] = false;
$response['cat']   = "";

if (isset($_POST['reset']) && 'reset' === $_POST['reset']) {$response['cat'] = "-";} else {
 if (isset($_POST['idCat']) && !empty($_POST['idCat'])) {
  $idCat = $_POST['idCat'];
  $stmt  = $con->prepare('SELECT categorytable.CatName FROM categorytable WHERE idCategory = ? ');
  $stmt->bind_param('i', $idCat);
  if (!$stmt->execute()) {
   $response['error']     = true;
   $response['errorCode'] = 90030;
   $response['cat']       = "-";
  } else {
   $stmt->store_result();
   $stmt->bind_result($response['cat']);
  }
 }
}
echo json_encode($response, JSON_UNESCAPED_UNICODE);
