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
 $sqlMOD   = "SELECT * FROM teamtable WHERE idTeam = " . $idTeam;
 $res      = $con->query($sqlMOD);
 if (!$res) {
  $response['error'] = true;
  $response['errorMessage'] .= "Valami hiba történt! error code: 90021<br>";
  $response['errorCode'] = 90021;
 } else {
  $oldTName = "";
  $oldTcity = "";
  while ($row = mysqli_fetch_assoc($res)) {
   $oldTName = trim($row['tName']);
   $oldTcity = $row['tCity'];
  }
  ;
  if (isset($_POST['newTCity'])) {$newTCity = $_POST['newTCity'];}

  //================================ COMPARISONS, WHAT IS CHANGED OR NOT ===============================
  if ($oldTName != $newTName) {
   //Tname changed
   if (strlen($newTName) > 100 || strlen($newTName) < 2) {
    $response['error'] = true;
    $response['errorMessage'] .= "A csapatnév hossza nem megfelelő! error code: 90022<br>";
    $response['errorCode'] = 90022;
   } else { $modifyName = true;}
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
    } else { $modifyCity = true;}
   }
  }
  //=============================================  NOTHING CHANGED  ===============================
  //nothing is changed
  if (!$modifyCity && !$modifyName) {
   $response['error'] = true;
   $response['errorMessage'] .= "Nincs változás, nincs mit menteni! error code: 90024<br>";
   $response['errorCode'] = 90024;
  }

  //=============================================  MODIFY  ========================================
  //____________________________________modify Team City_______________________________________________
  $sqlMOD = "UPDATE `teamtable` SET `tName` = '::Tname::', `tCity` = '::Tcity::' WHERE `teamtable`.`idTeam` =  $idTeam ";
  if ($modifyCity) {
   $sqlMOD                     = str_replace('::Tcity::', $newTCity, $sqlMOD);
   $response['successMessage'] = "Új városnév: " . $newTCity . '<br>';
  } else {
   $sqlMOD = str_replace('::Tcity::', $oldTcity, $sqlMOD);
  } //endof modifyCity

  //____________________________________modify TeamName_______________________________________________
  if (!$modifyName) {
   //the Tname is not modified
   $sqlMOD = str_replace('::Tname::', $oldTName, $sqlMOD);
   $con->query($sqlMOD);
  } else {
   //modify the tname
   //we need to change the folder name too. First of  all, because of error could be happen
   $oldFoldername = '../../public/resources/pics/mezek/' . $oldTName . '/';
   $newFoldername = '../../public/resources/pics/mezek/' . $newTName . '/';
   if (!rename($oldFoldername, $newFoldername)) {
    $response['error'] = true;
    $response['errorMessage'] .= "Valami hiba történt, Error code: 90025";
   } else {
    //we have to change the paths in picstable too
    $sqlSelect = "SELECT meztable.idPic
                FROM meztable,teamtable
                WHERE meztable.idTeam=teamtable.idTeam
                AND teamtable.idTeam=" . $idTeam;
    $picIDs    = array();
    $resSelect = $con->query($sqlSelect);
    if ($resSelect) {
     while ($row = mysqli_fetch_row($resSelect)) {
      $picIDs[] = $row[0];
     }
     foreach ($picIDs as $item) {
      $kep1setted = '';
      $kep2setted = '';
      $kep3setted = '';
      //we have to check, if the current paths are setted or not for kep1, kep2, kep3
      $sqlPaths = " SELECT Path1, Path2, PathWeared
                    FROM picstable
                    WHERE picstable.idPic=$item";
      $resPaths = $con->query($sqlPaths);
      if ($resPaths) {
       //find the paths setted or not
       while ($row2 = mysqli_fetch_array($resPaths)) {
        if (strlen($row2[0]) > 3) {
         $kep1setted = "public/resources/pics/mezek/$newTName/";}
        if (isset($row2[1])) {
         if (strlen($row2[1]) > 3) {
          $kep2setted = "public/resources/pics/mezek/$newTName/";}}
        if (isset($row2[2])) {
         if (strlen($row2[2]) > 3) {
          $kep3setted = "public/resources/pics/mezek/$newTName/";}}
       }
       $sqlOvervrite = "UPDATE `picstable`
                        SET
                                `Path1` = '$kep1setted',
                                `Path2` = '$kep2setted',
                                `PathWeared` = '$kep3setted'
                        WHERE `picstable`.`idPic` = $item";
       $con->query($sqlOvervrite);
      } //endof $resPaths
     } //endof foreach
    } //endof $resSelect
    //folder rename is successsully changed
    $sqlMOD = str_replace('::Tname::', $newTName, $sqlMOD);
    $con->query($sqlMOD);
    $response['successMessage'] = "Új csapatnév: " . $newTName;
   } //endof rename Tname

  } //endof TnameModify
 } //endof $res: ok
} //endof post exists

echo json_encode($response, JSON_UNESCAPED_UNICODE);
