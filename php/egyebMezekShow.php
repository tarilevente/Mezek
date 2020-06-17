<?php
// this php prints out the pics(cards) of a selected team /js generates/. the content is loaded to '#egyebMezekTeam' /egyebMezekDiv.php/
session_start();

require_once '../config/connect.php'; //database connect
require_once '../config/functions.php'; //using methods
require_once '../php/Mez.php'; //using Mez Class
require_once '../php/Pic.php'; //using Pic Class

if (isset($_POST['eId']) && !empty($_POST['eId'])) {
 $eid = $_POST['eId']; //id of team (in egyebMezek League)
 //intitialize the response
 $html = "";
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
  $html .= '<div class="container-fluid">
                <div class="row p-1">';
  $counter = 0;
  while ($row = $res->fetch_assoc()) {
   //Loop for the result, Mez by Mez
   if ($counter % 4 == 0) {
    //set the rows
    $html .= '</div>
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
   $html .= GeneratePicCard(
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
  $html .= '</div>' //endof row
   . '</div>'; //endof container
  $html .= PrintModal();
  echo $html;
 } else {
  //no result - only bg appears
 }
} else {
 http_response_code(404);
 echo '<h4 class="bg-danger text-light p-5 text-center">Hiba a megjelenítésnél! error code: 56457</h4>';
 die();
}
