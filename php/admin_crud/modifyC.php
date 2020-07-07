<?php
require '../../config/connect.php';
require '../../config/functions.php';

$response['error']          = false;
$response['errorMessage']   = '';
$response['errorCode']      = '';
$response['successMessage'] = '';
$modifyName                 = false;

if (
 !isset($_POST['idCat']) || empty($_POST['idCat']) ||
 !isset($_POST['newCName']) || empty($_POST['newCName'])
) {
 //no post
 $response['error'] = true;
 $response['errorMessage'] .= "Valami hiba történt! error code: 90031<br>";
 $response['errorCode'] = 90031;
} else {
 //post arrived
 $idCat    = testInput($_POST['idCat']);
 $newCName = testInput($_POST['newCName']);

 $stmt = $con->prepare('SELECT categorytable.catName FROM categorytable WHERE idCategory = ?');
 $stmt->bind_param('i', $idCat);
 if (!$stmt->execute()) {
  $response['error'] = true;
  $response['errorMessage'] .= "Valami hiba történt! error code: 90032<br>";
  $response['errorCode'] = 90032;
 } else {
  $stmt->store_result();
  $stmt->bind_result($oldCname);
  $stmt->fetch();
  $stmt->close();
  //================================ COMPARISONS, WHAT IS CHANGED ===============================77
  //tname changed??
  if ($oldCname != $newCName) {
   //changed
   if (strlen($newCName) > 100 || strlen($newCName) < 2) {
    $response['error'] = true;
    $response['errorMessage'] .= "A kategórianév hossza nem megfelelő! error code: 90033<br>";
    $response['errorCode'] = 90033;
   } else { $modifyName = true;}
  } //endof tName changed
  //============================================= MODIFY ===================================================7
  //nothing is changed
  if (!$modifyName) {
   $response['error'] = true;
   $response['errorMessage'] .= "Nincs változás, nincs mit menteni! error code: 90034<br>";
   $response['errorCode'] = 90034;
  } else {
   //modify
   $response['successMessage'] = "Új kategórianév: " . $newCName;
   $stmt                       = $con->prepare('UPDATE `categorytable` SET `CatName` = ? WHERE `categorytable`.`idCategory` = ?;');
   $stmt->bind_param('si', $newCName, $idCat);
   $stmt->execute();
   $stmt->close();
  }
 } //endof execute(): ok
} //endof post exists

echo json_encode($response, JSON_UNESCAPED_UNICODE);
