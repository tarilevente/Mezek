<?php
require '../../config/connect.php';
require '../../config/functions.php';

$response['error']          = false;
$response['errorMessage']   = '';
$response['errorCode']      = '';
$response['successMessage'] = '';
$modifyName                 = false;
$modifyCity                 = false;

if (
 !isset($_POST['idTeam']) || empty($_POST['idTeam']) ||
 !isset($_POST['newTName']) || empty($_POST['newTName'])
) {
 //no post
 $response['error'] = true;
 $response['errorMessage'] .= "Valami hiba történt! error code: 90020<br>";
 $response['errorCode'] = 90020;
} else {
 //post arrived
 $idTeam   = testInput($_POST['idTeam']);
 $newTName = testInput($_POST['newTName']);
 $sql      = "SELECT * FROM teamtable WHERE idTeam = " . $idTeam;
 $res      = $con->query($sql);
 if (!$res) {
  $response['error'] = true;
  $response['errorMessage'] .= "Valami hiba történt! error code: 90021<br>";
  $response['errorCode'] = 90021;
 } else {
  $oldTname = "";
  $oldTcity = "";
  while ($row = mysqli_fetch_assoc($res)) {
   $oldTname = $row['tName'];
   $oldTcity = $row['tCity'];
  }
  ;
  if (isset($_POST['newTCity'])) {
   $newTCity = $_POST['newTCity'];
  }

  //================================ COMPARISONS, WHAT IS CHANGED ===============================77
  //tname changed??
  if ($oldTname != $newTName) {
   //changed
   if (strlen($newTName) > 100 || strlen($newTName) < 2) {
    $response['error'] = true;
    $response['errorMessage'] .= "A csapatnév hossza nem megfelelő! error code: 90022<br>";
    $response['errorCode'] = 90022;
   } else {
    //the change is valid
    //to be modified
    $modifyName = true;
   }
  } //endof tName changed

  //tCity is changed?
  if (isset($_POST['newTCity'])) {
   //tCity isset
   if ($newTCity != $oldTcity) {
    //city is modified
    if (strlen($newTCity) > 100) {
     $response['error'] = true;
     $response['errorMessage'] .= "A városnév túl hosszú! error code: 90023<br>";
     $response['errorCode'] = 90023;
    } else {
     //modify
     $modifyCity = true;
    }
   }
  }
  //============================================= MODIFY ===================================================7
  //nothing is changed
  if (!$modifyCity && !$modifyName) {
   $response['error'] = true;
   $response['errorMessage'] .= "Nincs változás, nincs mit menteni! error code: 90024<br>";
   $response['errorCode'] = 90024;
  }

  //modify
  if ($modifyCity) {
   if ($modifyName) {
    //name and city also changed
    $sql = "UPDATE `teamtable` SET `tName` = '$newTName', `tCity` = '$newTCity' WHERE `teamtable`.`idTeam` =  $idTeam ;";
    $con->query($sql);
    $response['successMessage'] = "Új csapatnév: " . $newTName . "<br>Új városnév: " . $newTCity;
   } else {
    //modifyCity only changed
    $sql = "UPDATE `teamtable` SET `tCity` = '$newTCity' WHERE `teamtable`.`idTeam` = $idTeam; ";
    $con->query($sql);
    $response['successMessage'] = "Új városnév: " . $newTCity;
   }
  } else {
   if ($modifyName) {
       if(){
           //modifyName only changed
           $sql = "UPDATE `teamtable` SET `tName` = '$newTName' WHERE `teamtable`.`idTeam` =  $idTeam ;";
           $con->query($sql);
           $response['successMessage'] = "Új csapatnév: " . $newTName;
       }
   }
  }
 } //endof $res: ok
} //endof post exists

echo json_encode($response, JSON_UNESCAPED_UNICODE);
