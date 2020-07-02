<?php
require '../../config/connect.php';
require '../../config/functions.php';

$response              = array();
$response['error']     = false;
$response['errorCode'] = "";
$response['errorMsg']  = "";

if (
 isset($_POST['cat']) && !empty($_POST['cat']) &&
 isset($_POST['Tname']) && !empty($_POST['Tname'])
) {
//posts are OK
 $cat   = testInput($_POST['cat']);
 $Tname = testInput($_POST['Tname']);

 if (isset($_POST['cityName']) && !empty($_POST['cityName'])) {
  $cityName = testInput($_POST['cityName']);} else { $cityName = "";}

 if (!$cat || !$Tname) {
  $response['error']     = true;
  $response['errorMsg']  = "A megadott érték nem lehet csak szóköz! error code: 75203";
  $response['errorCode'] = 75203;
 }

 if ($cat < 0 || $cat > 1000) {
  $response['error']     = true;
  $response['errorMsg']  = "A kategória nem létezik! error code: 75201";
  $response['errorCode'] = 75201;
 }

 if (strlen($Tname) < 2 || strlen($Tname) > 100) {
  $response['error']     = true;
  $response['errorMsg']  = "Túl rövid, vagy túl hosszú a csapatnév! error code: 75202";
  $response['errorCode'] = 75202;
 }
 if (strlen($cityName) < 1) {
  $cityName = "";
 } elseif
 (strlen($cityName) > 100) {
  $response['error']     = true;
  $response['errorMsg']  = "Túl hosszú a városnév! error code: 75204";
  $response['errorCode'] = 75204;
 }
 $usedTeams = array();
 $sql2      = "SELECT tName FROM TeamTable";
 $res2      = $con->query($sql2);
 if ($res2) {
  while ($row = mysqli_fetch_row($res2)) {
   $usedTeams[] = $row[0];
  }
 }

 if (in_array($Tname, $usedTeams)) {
  //Team already Exists
  $response['error']     = true;
  $response['errorMsg']  = "A csapatnév már létezik! error code: 75205";
  $response['errorCode'] = 75205;
 }

 if (false === $response['error']) {
  $sql = "INSERT INTO `teamtable` (`idTeam`, `idCategory`, `tName`, `tCity`) VALUES (NULL, '$cat', '$Tname', '$cityName')";
  $res = $con->query($sql);
  if (!$res) {
   //error to upload
   $response['error']     = true;
   $response['errorMsg']  = "Valami hiba történt! error code: 75206";
   $response['errorCode'] = 75206;
  }
 }
} else {
 //no post exist
 $response['error']     = true;
 $response['errorMsg']  = "Valami hiba történt! error code: 75200";
 $response['errorCode'] = 75200;
}

echo json_encode($response, JSON_UNESCAPED_UNICODE);
