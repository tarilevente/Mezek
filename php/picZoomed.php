<?php
//this php controls modal function.
session_start();

require_once '../config/connect.php'; //database connect
require_once '../config/functions.php'; //using methods
require_once '../php/Mez.php'; //using Mez Class
require_once '../php/Pic.php'; //using Pic Class

if (isset($_POST['picId']) && !empty($_POST['picId'])) {
 $picId = $_POST['picId'];

 $sql = 'SELECT * FROM MezTable WHERE idMez=' . $picId;
 $res = $con->query($sql);
 if ($res && 1 == $res->num_rows) {
  $aktMez = null;
  while ($row = mysqli_fetch_row($res)) {
   print_r($row);
   $aktMez = GetMezFromRow($row);
  }

 } else {
  //Missing $res
  http_response_code(305);
  printModalError("Mez nem található! ", "87421");
 }
} else {
 //$_post['picId'] is Missing
 http_response_code(305);
 printModalError('Ismeretlen hiba! ', "87420");
}
