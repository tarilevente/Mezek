<?php
session_start();
require '../../config/connect.php';
require '../../config/functions.php';

$response['error']      = false;
$response['errorMsg']   = '';
$response['successMsg'] = '';

//1: $_session setted?
if (!isset($_SESSION['user'])) {
 //no user in session
 $response['error'] = true;
 $response['errorMsg'] .= 'A módosításokhoz be kell jelentkezned! error code:90101<br>';
} else {
//2. Init variables, and post-CHECK
 $idPic = null;
 $info  = null;
 $years = null;
 $type  = null;

 $kep1Filename = null;
 $kep2Filename = null;
 $kep3Filename = null;

 $kep2DELETED = false;
 $kep3DELETED = false;

 $Kep1Changed  = false;
 $Kep2Changed  = false;
 $Kep3Changed  = false;
 $TypeChanged  = false;
 $InfoChanged  = false;
 $YearsChanged = false;

 $base_dir = realpath($_SERVER["DOCUMENT_ROOT"]);

 if (
  !isset($_POST['idMez']) || empty($_POST['idMez'] ||
   !isset($_POST['type']) || empty($_POST['type']))
 ) {
  $response['error'] = true;
  $response['errorMsg'] .= "Valami hiba történt! error code: 90100<br>";
 } else {
  //post exists
  // 3: =======================get the posts, and put them into variables======================
  $type       = testInput($_POST['type']);
  $typeExists = array(0, 1, 2, 3, 4);
  if (!in_array($type, $typeExists)) {
   $response['error'] = true;
   $response['errorMsg'] .= 'Ilyen típus nincs az adatbázisban. error code: 90102<br>';
  }
  $idMez       = testInput($_POST['idMez']);
  $mezIDs      = array();
  $sqlMezCheck = "SELECT idMez FROM MezTable";
  $resMezCheck = $con->query($sqlMezCheck);
  if (!$resMezCheck) {
   $response['error'] = true;
   $response['errorMsg'] .= "Valami hiba történt! error code: 90104<br>";
  } else {
   while ($row = mysqli_fetch_row($resMezCheck)) {
    $mezIDs[] = $row[0];
   }
   if (!in_array($idMez, $mezIDs)) {
    $response['error'] = true;
    $response['errorMsg'] .= 'Ilyen mez nincs az adatbázisban. error code: 90103<br>';
   }
  }
  if (isset($_POST['modM-Info'])) {$info = testInput($_POST['modM-Info']);}
  if (isset($_POST['modM-Years'])) {$years = testInput($_POST['modM-Years']);}

  if (strlen($_FILES['#imageResult']['name']) > 2) {$kep1Filename = $_FILES['#imageResult']['name'];}
  if (strlen($_FILES['#imageResult2']['name']) > 2) {$kep2Filename = $_FILES['#imageResult2']['name'];}
  if (strlen($_FILES['#imageResult3']['name']) > 2) {$kep3Filename = $_FILES['#imageResult3']['name'];}

//4. ===========================get the current datas from db===============================
  $sql = "SELECT * FROM MezTable, PicsTable WHERE MezTable.idPic=PicsTable.idPic AND idMez= " . $idMez;
  $res = $con->query($sql);
  if (!$res || 1 != $res->num_rows) {
   $response['error'] = true;
   $response['errorMsg'] .= "Valami hiba történt! error code: 90105<br>";
  } else {
   while ($row = mysqli_fetch_assoc($res)) {
    $idPic    = $row['idPic'];
    $infoOLD  = $row['Info'];
    $yearsOLD = $row['Years'];
    $typeOLD  = $row['Type'];

    $kep1FilenameOLD = $row['1'];
    $kep1FilePathOLD = $row['Path1'];
    $kep2FilenameOLD = $row['2'];
    $kep2FilePathOLD = $row['Path2'];
    $kep3FilenameOLD = $row['weared'];
    $kep3FilePathOLD = $row['PathWeared'];
   }
  } //endof db to variables
  //5. compare the datas
  if (isset($years) && $years != $yearsOLD) {$YearsChanged = true;}
  if (isset($info) && $info != $infoOLD) {$InfoChanged = true;}
  if ($type != $typeOLD) {$TypeChanged = true;}

  if (false == $response['error']) {
   //5/A: First, we will delete the pics, what are no more necessary
   if (isset($_POST['kep2Deleted']) && true == $_POST['kep2Deleted']) {
    if (strlen($kep2FilenameOLD) > 2) {
     $file_delete2 = str_replace('\\', '/', $base_dir) . "/mezek/mezek/" . $kep2FilePathOLD . $kep2FilenameOLD;
     if (!file_exists($file_delete2)) {
      $response['error'] = true;
      $response['errorMsg'] .= 'Hiba, nem találom a kép2-t : ' . $file_delete2;
     } else {
      if (!unlink($file_delete2)) {
       $response['error'] = true;
       $response['errorMsg'] .= "Hiba a kép2 törlésénél! ";
      } else {
       $kep2DELETED = true;
       $response['successMsg'] .= 'Kép 2 törölve!<br>';
      }
     }
    }
   } //endof kep2 delete the .jpg from server
   if (isset($_POST['kep3Deleted']) && true == $_POST['kep3Deleted']) {
    if (strlen($kep3FilenameOLD) > 2) {
     $file_delete2 = str_replace('\\', '/', $base_dir) . "/mezek/mezek/" . $kep3FilePathOLD . $kep3FilenameOLD;
     if (!file_exists($file_delete2)) {
      $response['error'] = true;
      $response['errorMsg'] .= 'Hiba, nem találom a kép3-at : ' . $file_delete2;
     } else {
      if (!unlink($file_delete2)) {
       $response['error'] = true;
       $response['errorMsg'] .= "Hiba a kép3 törlésénél! ";
      } else {
       $kep3DELETED = true;
       $response['successMsg'] .= 'Kép 3 törölve!<br>';
      }
     }
    }
   } //endof kep3 delete the .jpg from server
   //5/B: Check which pics are used now
   if (isset($kep1Filename)) {
    //something happened, because it is setted (basicly: null)
    if ($kep1Filename != $kep1FilenameOLD) {
     // file is changed
     $Kep1Changed = true;
    }
   }
   if (isset($kep2Filename) && $kep2Filename != $kep2FilenameOLD) {$Kep2Changed = true;}
   if (isset($kep3Filename) && $kep3Filename != $kep3FilenameOLD) {$Kep3Changed = true;}
   if (
    false == $Kep1Changed &&
    false == $Kep2Changed &&
    false == $Kep3Changed &&
    false == $TypeChanged &&
    false == $InfoChanged &&
    false == $YearsChanged &&
    false == $kep2DELETED &&
    false == $kep3DELETED) {
    $response['error']    = true;
    $response['errorMsg'] = 'Nincs változás, nincs mit menteni.';
   }
   //5/C: new pics move to the destionation folder ::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::://////!!
   if ($Kep1Changed) {
    $file_upload  = "/mezek/mezek/" . $kep1FilePathOLD;
    $file_upload2 = str_replace('\\', '/', $base_dir) . $file_upload;
    if (!move_uploaded_file($_FILES['#imageResult']['tmp_name'], $file_upload2 . $kep1Filename)) {
     //error occurs moving the pic
     $response['error'] = true;
     $response['errorMsg'] .= 'Valami hiba történt a kép1 feltöltésekor!';
    } else {
     //kep1 successfully moved to the destionation folder,
     //we have to remove the last one
     $file_delete2 = str_replace('\\', '/', $base_dir) . "/mezek/mezek/" . $kep1FilePathOLD . $kep1FilenameOLD;
     if (!file_exists($file_delete2)) {
      $response['error'] = true;
      $response['errorMsg'] .= 'Hiba, nem találom a kép1-et : ' . $file_delete2;
     } else {
      if (!unlink($file_delete2)) {
       $response['error'] = true;
       $response['errorMsg'] .= "Hiba a kép1 törlésénél! ";
      } else {
       //kep1 deleted
      }
     }
    } //endof kep1
   }
   if ($Kep2Changed && false == $kep2DELETED && false == $response['error']) {
    $file_upload  = "/mezek/mezek/" . $kep1FilePathOLD;
    $file_upload2 = str_replace('\\', '/', $base_dir) . $file_upload;
    if (!move_uploaded_file($_FILES['#imageResult2']['tmp_name'], $file_upload2 . $kep2Filename)) {
     //error occurs moving the pic
     $response['error'] = true;
     $response['errorMsg'] .= 'Valami hiba történt a kép2 feltöltésekor!';
    } else {
     //kep2 successfully uploaded
     if ($kep2FilenameOLD && $kep2FilenameOLD) {
      //we have to remove the last one
      $file_delete2 = str_replace('\\', '/', $base_dir) . "/mezek/mezek/" . $kep2FilePathOLD . $kep2FilenameOLD;
      if (!file_exists($file_delete2)) {
       $response['error'] = true;
       $response['errorMsg'] .= 'Hiba, nem találom a kép2-t : ' . $file_delete2;
      } else {
       if (!unlink($file_delete2)) {
        $response['error'] = true;
        $response['errorMsg'] .= "Hiba a kép2 törlésénél! ";
       } else {
        //kep1 deleted
       }
      }
     }
    } //endof kep2
   }
   if ($Kep3Changed && false == $kep3DELETED && false == $response['error']) {
    $file_upload  = "/mezek/mezek/" . $kep1FilePathOLD;
    $file_upload2 = str_replace('\\', '/', $base_dir) . $file_upload;
    if (!move_uploaded_file($_FILES['#imageResult3']['tmp_name'], $file_upload2 . $kep3Filename)) {
     //error occurs moving the pic
     $response['error'] = true;
     $response['errorMsg'] .= 'Valami hiba történt a kép3 feltöltésekor!';
    } else {
     //kep3 successfully uploaded
     if ($kep3FilenameOLD && $kep3FilenameOLD) {
      //we have to remove the last one
      $file_delete2 = str_replace('\\', '/', $base_dir) . "/mezek/mezek/" . $kep3FilePathOLD . $kep3FilenameOLD;
      if (!file_exists($file_delete2)) {
       $response['error'] = true;
       $response['errorMsg'] .= 'Hiba, nem találom a kép3-at : ' . $file_delete2;
      } else {
       if (!unlink($file_delete2)) {
        $response['error'] = true;
        $response['errorMsg'] .= "Hiba a kép3 törlésénél! ";
       } else {
        //kep1 deleted
       }
      }
     }
    } //endof kep3
   }
   if (false == $response['error']) {
    //write the sql file
    //info, years, type changes
    $sql = "UPDATE `meztable`
            SET `Type` = '::type::', `Years` = '::years::', `Info` = '::info::'
            WHERE `meztable`.`idMez` = $idMez ";
    if ($TypeChanged) {
     $newTypeString = getTypeString($type);
     $sql           = str_replace('::type::', $type, $sql);
     $response['successMsg'] .= 'Típus változott: ' . $newTypeString . '<br>';} else { $sql = str_replace('::type::', $typeOLD, $sql);}
    if ($InfoChanged) {
     $sql = str_replace('::info::', $info, $sql);
     $response['successMsg'] .= 'Info változott: ' . $info . '<br>';} else { $sql = str_replace('::info::', $infoOLD, $sql);}
    if ($YearsChanged) {
     $sql = str_replace('::years::', $years, $sql);
     $response['successMsg'] .= 'Évek változott: ' . $years . '<br>';} else { $sql = str_replace('::years::', $yearsOLD, $sql);}
    $con->query($sql);

    //pic1,Path1, pic2,Path2, pic3,Path3,
    $sqlUPD = " UPDATE `picstable`
              SET
                `1` = '::1::', `Path1` = '::Path1::',
                `2` = '::2::', `Path2` = '::Path2::',
                `weared` = '::weared::', `PathWeared` = '::PathWeared::'
              WHERE `picstable`.`idPic` = " . $idPic;
    if ($Kep1Changed) {
     $sqlUPD = str_replace('::1::', $kep1Filename, $sqlUPD);
     $sqlUPD = str_replace('::Path1::', $kep1FilePathOLD, $sqlUPD);
     $response['successMsg'] .= "Kép1 megváltozott: " . $kep1Filename . '<br>';
    } else {
     $sqlUPD = str_replace('::1::', $kep1FilenameOLD, $sqlUPD);
     $sqlUPD = str_replace('::Path1::', $kep1FilePathOLD, $sqlUPD);
    }
    if ($Kep2Changed) {
     $sqlUPD = str_replace('::2::', $kep2Filename, $sqlUPD);
     $sqlUPD = str_replace('::Path2::', $kep1FilePathOLD, $sqlUPD);
     $response['successMsg'] .= "Kép2 megváltozott: " . $kep2Filename . '<br>';
    } elseif ($kep2DELETED) {
     $sqlUPD = str_replace('::2::', "", $sqlUPD);
     $sqlUPD = str_replace('::Path2::', "", $sqlUPD);
    } else {
     $sqlUPD = str_replace('::2::', $kep2FilenameOLD, $sqlUPD);
     $sqlUPD = str_replace('::Path2::', $kep2FilePathOLD, $sqlUPD);
    }

    if ($Kep3Changed) {
     $sqlUPD = str_replace('::weared::', $kep3Filename, $sqlUPD);
     $sqlUPD = str_replace('::PathWeared::', $kep1FilePathOLD, $sqlUPD);
     $response['successMsg'] .= "Kép3 megváltozott: " . $kep3Filename . '<br>';
    } elseif ($kep3DELETED) {
     $sqlUPD = str_replace('::weared::', "", $sqlUPD);
     $sqlUPD = str_replace('::PathWeared::', "", $sqlUPD);
    } else {
     $sqlUPD = str_replace('::weared::', $kep3FilenameOLD, $sqlUPD);
     $sqlUPD = str_replace('::PathWeared::', $kep3FilePathOLD, $sqlUPD);
    }
    $con->query($sqlUPD);
   } //endof $response['error']==false
  } //endof $response==false
 } //endof isset $_post
} //endof $_session['user'] CHECK
echo json_encode($response, JSON_UNESCAPED_UNICODE);
