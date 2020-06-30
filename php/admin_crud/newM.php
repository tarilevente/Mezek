<?php
session_start();
require_once '../../config/connect.php'; //database connect
require_once '../../config/functions.php'; //using methods
require_once '../../php/Mez.php';
require_once '../../php/Pic.php';

//response init
$response              = array();
$response['error']     = false;
$response['errorCode'] = array();
$response['errorMsg']  = "";

//1: $_session setted?
if (!isset($_SESSION['user'])) {
 //no user in session
 $response['error'] = true;
 $response['errorMsg'] .= 'Be kell jelentkezned: 89906<br>';
 $response['errorCode'][] = '89906';
} //endof $user error
else {
 $user = $_SESSION['user'];

 date_default_timezone_set("Europe/Budapest");

 //new Mez object init
 $idMez      = "null";
 $idPic      = "not_exist_yet";
 $idTeam     = "not_exist_yet";
 $type       = "not_exist_yet";
 $uploadUser = $user['idUser'];
 $uploadDate = date('Y-m-d H:i:s');
 $years      = "";
 $info       = "";

 //set years if exists
 if (isset($_POST['newM-years']) && !empty($_POST['newM-years'])) {$years = $_POST['newM-years'];} else {}
 //set info if exists
 if (isset($_POST['newM-info']) && !empty($_POST['newM-info'])) {$info = $_POST['newM-info'];} else {}
 //2: type-check
 if (!isset($_POST["type"])) {
  //error,the type is not properly setted
  $response['error'] = true;
  $response['errorMsg'] .= 'A mez típusának megadása kötelező! error code: 89900<br>' . $_POST['type'];
  $response['errorCode'][] = '89900';
 } else {
  //type is ok
  $type = $_POST['type'];
 } //endof type check
 //3: team check
 if (!isset($_POST['team']) || empty($_POST['team'])) {
  //error, the team not arrived
  $response['error'] = true;
  $response['errorMsg'] .= 'A csapat megadása kötelező: error code: 89902<br>';
  $response['errorCode'][] = '89902';
 } else {
  //3: team is in the database?
  $team = $_POST['team'];
  $sql  = "SELECT idTeam FROM TeamTable";
  $res  = $con->query($sql);
  if (!$res) {
   //error,the type is not properly setted
   $response['error'] = true;
   $response['errorMsg'] .= 'Valami hiba történt! error code: 89901<br>';
   $response['errorCode'][] = '89901';
  }
  $csapatIDs = array();
  while ($row = mysqli_fetch_row($res)) {
   $csapatIDs[] = $row[0];
  }
  ;
  if (!in_array($team, $csapatIDs)) {
   //error, the team not exists
   $response['error'] = true;
   $response['errorMsg'] .= 'A csapat nem megfelelő: error code: 89907<br>';
   $response['errorCode'][] = '89907';
  }
  $sql      = 'SELECT tName from TeamTable WHERE idTeam=' . $team;
  $res      = $con->query($sql);
  $teamName = "";
  if ($res) {
   while ($row = mysqli_fetch_row($res)) {
    $teamName = $row[0];
   }
   ;
  }
 } //endof team Check
 //4: upload pics - ajax sends data from admin_crud.js
 $locationCommon = "../../public/resources/pics/mezek/" . $teamName . "/";
 if (strlen($_FILES['#imageResult']['name']) < 2) {
  //kep1 must be setted
  $response['error'] = true;
  $response['errorMsg'] .= 'Az első kép kiválasztása kötelező! error code: 89903<br>';
  $response['errorCode'][] = '89903';
 } else {
  //kep1 setted (<input name="#imageResult">)
  $kep1filename  = $_FILES['#imageResult']['name'];
  $locationAkt1  = $locationCommon . $kep1filename;
  $imageFileType = pathinfo($locationAkt1, PATHINFO_EXTENSION);
  /* Valid extensions */
  $valid_extensions = array("jpg", "jpeg", "png");
  /* Check file extension */
  if (!in_array(strtolower($imageFileType), $valid_extensions)) {
   //error not a pic
   $response['error'] = true;
   $response['errorMsg'] .= 'A kép1 formátuma nem megfelelő!: error code: 89908<br>';
   $response['errorCode'][] = '89908';
  }
  //pic1
  elseif (fileAlreadyExists($locationAkt1)) {
   //kep1 filename already exists
   $response['error'] = true;
   $response['errorMsg'] .= 'A kép1 már létezik az adatbázisban! error code: 89905<br>';
   $response['errorCode'][] = '89905';
  } else {
   //check kep2
   $kep2exists = false;
   if (strlen($_FILES['#imageResult2']['name']) > 2) {
    //kep2 exists
    $kep2exists     = true;
    $kep2filename   = $_FILES['#imageResult2']['name'];
    $locationAkt2   = $locationCommon . $kep2filename;
    $imageFileType2 = pathinfo($locationAkt2, PATHINFO_EXTENSION);
    /* Valid extensions */
    $valid_extensions = array("jpg", "jpeg", "png");
    /* Check file extension */
    if (!in_array(strtolower($imageFileType2), $valid_extensions)) {
     //error not a pic
     $response['error'] = true;
     $response['errorMsg'] .= 'A kép2 formátuma nem megfelelő!: error code: 89909<br>';
     $response['errorCode'][] = '89909';
    } elseif (fileAlreadyExists($locationAkt2)) {
     $response['error'] = true;
     $response['errorMsg'] .= 'A kép2 már létezik az adatbázisban! error code: 89911<br>';
     $response['errorCode'][] = '89911';
    }
   }
   //check kep3
   $kep3exists = false;
   if (strlen($_FILES['#imageResult3']['name']) > 2) {
    $kep3exists = true;
    //kep2 exists
    $kep3filename   = $_FILES['#imageResult3']['name'];
    $locationAkt3   = $locationCommon . $kep3filename;
    $imageFileType3 = pathinfo($locationAkt3, PATHINFO_EXTENSION);
    /* Valid extensions */
    $valid_extensions = array("jpg", "jpeg", "png");
    /* Check file extension */
    if (!in_array(strtolower($imageFileType3), $valid_extensions)) {
     //error not a pic
     $response['error'] = true;
     $response['errorMsg'] .= 'A kép3 formátuma nem megfelelő!: error code: 89910<br>';
     $response['errorCode'][] = '89910';
    } elseif (fileAlreadyExists($locationAkt3)) {
     $response['error'] = true;
     $response['errorMsg'] .= 'A kép3 már létezik az adatbázisban! error code: 89912<br>';
     $response['errorCode'][] = '89912';
    }
   }
   if (false == $response['error']) {
    //3: section of sql-executes- upload datas to database
    //3/A: pic upload to DB
    $idPic = 'null';
    $p1    = $_FILES['#imageResult']['name'];
    $Path1 = 'public/resources/pics/mezek/' . $teamName . '/';
    $p2    = "";
    $Path2 = "";
    if ($kep2exists) {
     $p2    = $_FILES['#imageResult2']['name'];
     $Path2 = 'public/resources/pics/mezek/' . $teamName . '/';
    }
    $weared     = "";
    $PathWeared = "";
    if ($kep3exists) {
     $weared     = $_FILES['#imageResult3']['name'];
     $PathWeared = 'public/resources/pics/mezek/' . $teamName . '/';
    }
    $aktPic = new Pic($idPic, $p1, $Path1, $p2, $Path2, $weared, $PathWeared);
    $sql    = "INSERT INTO `picstable` (`idPic`, `1`, `Path1`, `2`, `Path2`, `weared`, `PathWeared`) VALUES ($idPic, '$p1', '$Path1', '$p2', '$Path2', '$weared', '$PathWeared');";
    $con->query($sql);
    $sql      = 'SELECT idPic FROM PicsTable ORDER BY idPic DESC LIMIT 1';
    $res      = $con->query($sql);
    $newPicID = "as";
    if ($res) {
     while ($row = mysqli_fetch_row($res)) {
      $newPicID = $row[0];
     }
     ;
    }
    //3/B Mez upload to DB
    $aktMez = new Mez($idMez, $newPicID, $team, $type, $uploadUser, $uploadDate, $years, $info);
    $sql    = "INSERT INTO `meztable`
    (`idMez`, `idPic`, `idTeam`, `Type`, `UploadUser`, `UploadDate`, `Years`, `Info`)
    VALUES
    (NULL,
    '" . $aktMez->getIdpic() . "',
    '" . $aktMez->getIdteam() . "',
    '" . $aktMez->getType() . "',
    '" . $aktMez->getUploaduser() . "',
    '" . $aktMez->getUploaddate() . "',
    '" . $aktMez->getYears() . "',
    '" . $aktMez->getInfo() . "'
    );";
    $con->query($sql);
    //4: section of uploads
    makeDir($locationCommon);
    if (!move_uploaded_file($_FILES['#imageResult']['tmp_name'], $locationAkt1)) {
     //error occurs moving the pic
     $response['error'] = true;
     $response['errorMsg'] .= 'Valami hiba történt a kép(ek) feltöltésekor! error code: 89904<br>';
     $response['errorCode'][] = '89904';

    } else {
     //kep1 success
    } //endof kep1
    if ($kep2exists) {
     if (!move_uploaded_file($_FILES['#imageResult2']['tmp_name'], $locationAkt2)) {
      //error occurs moving the pic
      $response['error'] = true;
      $response['errorMsg'] .= 'Valami hiba történt a kép(ek) feltöltésekor! error code: 89904<br>';
      $response['errorCode'][] = '89904';
     } else {
      //kep2 success
     }
    } //endof kep2
    if ($kep3exists) {
     if (!move_uploaded_file($_FILES['#imageResult3']['tmp_name'], $locationAkt3)) {
      //error occurs moving the pic
      $response['error'] = true;
      $response['errorMsg'] .= 'Valami hiba történt a kép(ek) feltöltésekor! error code: 89904<br>';
      $response['errorCode'][] = '89904';
     } else {
      //kep3 success
     }
    } //endof kep3
   } //$resp['error']==false, upload started
  } //endof kep1 filename already exists
 } //endof the kep1 is not setted
} //endof $user set
echo json_encode($response, JSON_UNESCAPED_UNICODE);
