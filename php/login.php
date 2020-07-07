<?php
require '../config/connect.php';
require '../config/functions.php';
session_start();

$response              = array();
$response['error']     = false;
$response['errorMsg']  = "";
$response['errorCode'] = 0;

if (
 isset($_POST['uname']) &&
 !empty($_POST['uname']) &&
 isset($_POST['pwd']) &&
 !empty($_POST['pwd'])
) {
 $uname = testInput($_POST['uname']);
 $pwd   = testInput($_POST['pwd']);

 if (mb_strlen($uname) < 5) {
  //too short the uname
  $response['error']     = true;
  $response['errorMsg']  = "Helytelen adatok! A belépés sikertelen! ";
  $response['errorCode'] = 65601;
 }
 if (mb_strlen($pwd) < 8) {
  //too short the pwd
  $response['error']     = true;
  $response['errorMsg']  = "Helytelen adatok! A belépés sikertelen! ";
  $response['errorCode'] = 65602;
 }
 if (!pwdIsValidRegex($pwd)) {
  //pwd formaly is not permitted
  $response['error']     = true;
  $response['errorMsg']  = "Helytelen adatok! A belépés sikertelen! ";
  $response['errorCode'] = 65603;
 }
 $stmt = $con->prepare('SELECT idUser FROM UserTable WHERE Email= ? AND Password = ? AND Active = 1');
 $stmt->bind_param('ss', $uname, $pwd);
 $stmt->execute();
 $stmt->store_result();
 $stmt->bind_result($userID);
 if (1 == $stmt->num_rows) {
  //only 1 user appears
  if ($stmt->fetch()) {
   $_SESSION['user'] = $userID;
  } else {
   $response['error']     = true;
   $response['errorMsg']  = "A felhasználónév-jelszó páros helytelen adatokat tartalmaz! A belépés sikertelen!";
   $response['errorCode'] = 65604;
  }
 } else {
  //numrows!==1 (0 is usual) -- something is went wrong
  $response['error']     = true;
  $response['errorMsg']  = "A felhasználónév-jelszó páros helytelen adatokat tartalmaz! A belépés sikertelen!";
  $response['errorCode'] = 65604;
 }

} else {
 //post not arrived properly
 $response['error']     = true;
 $response['errorMsg']  = "Ismeretlen hiba történt! error code: 65600";
 $response['errorCode'] = 65600;
}

echo json_encode($response, JSON_UNESCAPED_UNICODE);
