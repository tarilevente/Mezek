<?php
session_start();
require_once '../../config/connect.php'; //database connect
require_once '../../config/functions.php'; //using methods

$response              = array();
$response['error']     = false;
$response['errorCode'] = "";
$response['errorMsg']  = "";
$user                  = $_SESSION['user'];

date_default_timezone_set("Europe/Budapest");

$idMez      = "null";
$idPic      = "not_exist_yet";
$idTeam     = "not_exist_yet";
$type       = "not_exist_yet";
$uploadUser = $user['idUser'];
$uploadDate = date('Y-m-d H:i:s');
$years      = "";
$info       = "";

$aktMez = new Mez($idMez, $idPic, $idTeam, $type, $uploadUser, $uploadDate, $years, $info);
