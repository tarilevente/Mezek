<?php
// this php prints out the pics(cards) of a selected team /js generates/. the content is loaded to '#egyebMezekTeam' /egyebMezekDiv.php/
session_start();

require_once '../config/connect.php'; //database connect
require_once '../config/functions.php'; //using methods
require_once '../php/Mez.php'; //using Mez Class
require_once '../php/Pic.php'; //using Pic Class

//Initialize the response
$response              = array();
$response['html']      = '';
$response['error']     = false;
$response['errorCode'] = '';
$response['errMsg']    = '';
if (isset($_POST['eId']) && !empty($_POST['eId'])) {
 $eid = $_POST['eId']; //id of team (in egyebMezek League)
 //query
 $sql = "SELECT meztable.idMez,
                meztable.idPic,
                meztable.idTeam,
                meztable.Type,
                meztable.UploadUser,
                meztable.UploadDate,
                meztable.Years,
                meztable.Info
        FROM    meztable, teamtable
        WHERE   teamtable.idTeam=meztable.idTeam AND
                teamtable.idteam=3
        ";
 $res = $con->query($sql);
 if ($res) {
  $response['html'] .=
   '<div>
        <div class="row p-1">';
  $counter = 0;
  while ($row = $res->fetch_assoc()) {
   //Loop for the result, Mez by Mez
   if ($counter % 4 == 0) {
    //set the rows
    $response['html'] .= '</div>
                          <div class="row d-flex justify-content-around">';
   }
   //aktmez to a Mez object
   $aktMez = GetMezFromRow($con, $row);

   //Find the pics of the aktMez by query
   $aktPic = GetPicFromRow($con, $row);

   //find the name of the team
   $sql4        = "SELECT tName FROM TeamTable WHERE idTeam= " . $aktMez->getIdTeam();
   $teamNameRes = $con->query($sql4);
   $teamName    = "";
   while ($u = $teamNameRes->fetch_row()) {
    $teamName = $u[0];
   }
   ;

//print out the Pic in a bootstrap "card" element
   $response['html'] .=
   GeneratePicCard(
    $teamName,
    $aktMez->getYears(),
    $aktMez->getType(),
    $aktPic->getPath1(),
    $aktPic->getP1(),
    $aktMez->getInfo(),
    $aktPic->getIdpic()
   );
   $counter++;
  }
  $response['html'] .=
  '     </div>' //endof row
   . '</div>'; //endof wrapper
  $response['html'] .= PrintModal();

 } else {
  //no result - only bg appears
  $response['error'] = true;
  $response['errMsg'] .=
   '<h4 class="bg-warning text-danger m-1 p-5 text-center">
      Nincs megjelenítendő adat.
   </h4>';
  $response['errorCode'] = 56457;
 }
} else {
 $response['error'] = true;
 $response['errMsg'] .=
  '<h4 class="bg-danger text-light p-5 text-center">
      Hiba a megjelenítésnél! error code: 56457
   </h4>';
 $response['errorCode'] = 56457;
}

echo json_encode($response, JSON_UNESCAPED_UNICODE);
