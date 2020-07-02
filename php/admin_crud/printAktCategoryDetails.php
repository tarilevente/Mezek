<?php
require '../../config/connect.php';
require '../../config/functions.php';

$response['error'] = false;
$response['cat']   = "";

if (isset($_POST['reset']) && 'reset' === $_POST['reset']) {$response['cat'] = "-";} else {
 if (isset($_POST['idCat']) && !empty($_POST['idCat'])) {
  $idCat = $_POST['idCat'];
  $sql   = "SELECT * FROM categorytable WHERE idCategory = " . $idCat;
  $res   = $con->query($sql);
  if (!$res) {
   $response['error']     = true;
   $response['errorCode'] = 90030;
   $response['cat']       = "-";
  } else {
   while ($row = mysqli_fetch_assoc($res)) {
    $response['cat'] = $row['CatName'];
   }
   ;
  }
 }
}
echo json_encode($response, JSON_UNESCAPED_UNICODE);
