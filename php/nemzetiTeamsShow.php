<?php
//Pints out the pics to bootstrap "card" into "#NationalTeams" when clicking on '.data-national' by ajax

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

if (isset($_POST['nId']) && !empty($_POST['nId'])) {
 $nid = $_POST['nId']; //id of nation
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
  $response['html'] .= '<div>
                <div class="row p-1">';
  $counter = 0;
  while ($row = $res->fetch_assoc()) {
   //Loop for the result, Mez by Mez
   if ($counter % 4 == 0) {
    //set the rows
    $response['html'] .=
     ' </div>
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
  ;
  $response['html'] .=
  '</div>' //endof row
   . '</div>'; //endof container
  $response['html'] .= PrintModal();

 } else {
  //DO Not print Anything, ONLY BG appears
 }
} else {
 http_response_code(513);
 $response['error'] = true;
 $response['errMsg'] .=
  '<h4 class="bg-danger text-light p-5 text-center">
      Hiba a megjelenítésnél! error code: 78692
   </h4>';
 $response['errorCode'] = 78692;
}

echo json_encode($response, JSON_UNESCAPED_UNICODE);
