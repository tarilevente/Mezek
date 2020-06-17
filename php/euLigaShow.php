<?php
// this php prints out the pics(cards) of a selected team /js generates/. the content is loaded to '#egyebMezekTeam' /egyebMezekDiv.php/
session_start();

require_once '../config/connect.php'; //database connect
require_once '../config/functions.php'; //using methods
require_once '../php/Mez.php'; //using Mez Class
require_once '../php/Pic.php'; //using Pic Class

if (isset($_POST['euId']) && !empty($_POST['euId'])) {
 $ELID = $_POST['euId'];
 $html = "";
 //select the MEZs where category=/selected category/
 $sql = " SELECT MezTable.idMez,
            MezTable.idPic,
            MezTable.idTeam,
            MezTable.Type,
            MezTable.UploadUser,
            MezTable.UploadDate,
            MezTable.Years,
            MezTable.Info
        FROM MezTable, TeamTable
        WHERE TeamTable.idTeam=MezTable.idTeam AND
            TeamTable.idTeam=$ELID
        ";
 $res = $con->query($sql);
 if ($res->num_rows > 0) {
  //result exists (Mez-s)
  $html .= '<div><div class="row p-1">';
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
  } //endof while($row=$res->fetch...)
  ;
  $html .= '</div>' //endof row
   . '</div>'; //endof container
  $html .= PrintModal();

  echo $html;
 } else {
  //Not print Anything
 }
} else {
 http_response_code(404);
 echo '<h4 class="bg-danger text-light p-5 text-center">Hiba a megjelenítésnél! error code: 26482</h4>';
 die();
}
