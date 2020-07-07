<?php
require '../../config/connect.php';
require '../../config/functions.php';

$response              = array();
$response['error']     = false;
$response['errorCode'] = "";
$response['errorMsg']  = "";

if (
 isset($_POST['liga']) && !empty($_POST['liga']) &&
 isset($_POST['Cname']) && !empty($_POST['Cname'])
) {
//posts are OK
 $liga  = testInput($_POST['liga']);
 $Cname = testInput($_POST['Cname']);

 if (!$liga || !$Cname) {
  $response['error']     = true;
  $response['errorMsg']  = "A megadott érték nem lehet csak szóköz! error code: 76101";
  $response['errorCode'] = 76101;
 }

 if ($liga < 0 || $liga > 10) {
  $response['error']     = true;
  $response['errorMsg']  = "A liga nem létezik! error code: 76102";
  $response['errorCode'] = 75102;
 }

 if (strlen($Cname) < 2 || strlen($Cname) > 100) {
  $response['error']     = true;
  $response['errorMsg']  = "Túl rövid, vagy túl hosszú a kategórianév! error code: 76103";
  $response['errorCode'] = 76103;
 }

 $usedCategories = array();
 $stmt           = $con->prepare('SELECT CatName FROM CategoryTable');
 $stmt->execute();
 $stmt->store_result();
 $stmt->bind_result($row);
 while ($stmt->fetch()) {
  $usedCategories[] = $row;
 }
 $stmt->close();

 if (in_array($Cname, $usedCategories)) {
  //Team already Exists
  $response['error']     = true;
  $response['errorMsg']  = "A kategória már létezik! error code: 76104";
  $response['errorCode'] = 76104;
 }

 if (false === $response['error']) {
  $sql = "INSERT INTO `CategoryTable` (`idCategory`, `idLeague`, `catName`) VALUES (NULL, '$liga', '$Cname');";
  $res = $con->query($sql);
  if (!$res) {
   //unsuccessful upload
   $response['error']     = true;
   $response['errorMsg']  = "Valami hiba történt! error code: 76105";
   $response['errorCode'] = 76105;
  }
 }
} else {
 //no post exist
 $response['error']     = true;
 $response['errorMsg']  = "Valami hiba történt! error code: 76100";
 $response['errorCode'] = 76100;
}

echo json_encode($response, JSON_UNESCAPED_UNICODE);
