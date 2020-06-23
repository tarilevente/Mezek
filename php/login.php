<?php
require '../config/connect.php';
require '../config/functions.php';
session_start();

$response              = array();
$response['error']     = false;
$response['errorMsg']  = "";
$response['errorCode'] = 0;
$response['test']      = "";
$errorExists           = false;

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
  $response['errorMsg']  = "Helytelen adatok! A belépés sikertelen! 65601";
  $response['errorCode'] = 65601;
  http_response_code(405);
  $errorExists = true;
 }
 if (mb_strlen($pwd) < 8) {
  //too short the pwd
  $response['error']     = true;
  $response['errorMsg']  = "Helytelen adatok! A belépés sikertelen! 65602";
  $response['errorCode'] = 65602;
  http_response_code(405);
 }
 if (!pwdIsValidRegex($pwd)) {
  //pwd formaly is not permitted
  $response['error']     = true;
  $response['errorMsg']  = "Helytelen adatok! A belépés sikertelen! 65603";
  $response['errorCode'] = 65603;
  http_response_code(405);
 }
 $sql = 'SELECT * FROM UserTable WHERE Email="' . $uname . '" AND Password="' . $pwd . '" AND Active=1 ';
//  $response['test'] = $sql;
 $res = $con->query($sql);
 if ($res && 1 == $res->num_rows) {
  while ($row = mysqli_fetch_assoc($res)) {
   $user = $row;
  }

  $_SESSION['user'] = $user;
 } else {
  //$res: something is went wrong
  $response['error']     = true;
  $response['errorMsg']  = "A felhasználónév-jelszó páros helytelen adatokat tartalmaz! A belépés sikertelen!";
  $response['errorCode'] = 65604;
  http_response_code(405);
 }

} else {
 //post not arrived properly
 $response['error']     = true;
 $response['errorMsg']  = "Ismeretlen hiba történt! error code: 65600";
 $response['errorCode'] = 65600;
 http_response_code(404);
}

echo json_encode($response, JSON_UNESCAPED_UNICODE);
