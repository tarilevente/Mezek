<?php
//Pints out the pics to bootstrap "card" into "#NationalTeams" when clicking on '.data-national' by ajax

session_start();

require_once '../config/connect.php'; //database connect
require_once '../config/functions.php'; //using methods
require_once '../php/Mez.php'; //using Mez Class
require_once '../php/Pic.php'; //using Pic Class

if (isset($_POST['nId']) && !empty($_POST['nId'])) {
 $nid = $_POST['nId']; //id of nation
 //intitialize the response
 $html = "";
 //query
 $sql = " SELECT MezTable.idMez,
                    MezTable.idPic,
                    MezTable.idTeam,
                    MezTable.Type,
                    MezTable.UploadUser,
                    MezTable.UploadDate,
                    MezTable.Years,
                    MezTable.Info
                FROM MezTable, TeamTable, CategoryTable
                WHERE   CategoryTable.idCategory=TeamTable.idCategory AND
                        TeamTable.idTeam=MezTable.idTeam AND
                        CategoryTable.idCategory=$nid"; // find the the Mez-s of a Nation with query
 $res = $con->query($sql);
 if ($res->num_rows > 0) {
  //result exists (Mez-s)
  $html .= '<div>
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
  ;
  $html .= '</div>' //endof row
   . '</div>'; //endof container
  $html .= PrintModal();

  echo $html;
 } else {
  //die("nemzetiTeamsShow.php-n nincs res!");//Not print Anything
 }
} else {
 http_response_code(404);
 echo '<h4 class="bg-danger text-light p-5 text-center">Hiba a megjelenítésnél! error code: 78692</h4>';
 die();
}
