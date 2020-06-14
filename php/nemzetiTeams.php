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
  $html .= '<div class="container-fluid"><div class="row p-1">';
  $counter = 0;
  while ($row = $res->fetch_assoc()) {
   //Loop for the result, Mez by Mez
   if ($counter % 4 == 0) {
    //set the rows
    $html .= '</div>
                          <div class="row">';
   }
   //aktmez to a Mez object
   $info = "";
   if (isset($row['Info'])) {
    $info = $row['Info'];
   }
   $years = "";
   if (strlen($row['Years']) > 0) {
    $years = $row['Years'];
   }
   $uploadDate = substr($row['UploadDate'], 0, 9);
   //Find the Upload user of the akt Mez
   $sql3   = "SELECT FirstName, LastName FROM UserTable WHERE idUser=" . $row['UploadUser'];
   $result = $con->query($sql3);
   $user   = array();
   while ($u = $result->fetch_array()) {
    $user = $u;
   }
   ;
   if (!$user) {
    die("nincs user a MEZhez a nemzetiTeams.php-n");
   }
   //Create the Mez object by datas
   $aktMez = new Mez(
    $row['idMez'],
    $row['idPic'],
    $row['idTeam'],
    $row['Type'],
    $user[1] . ' ' . $user[0],
    $uploadDate,
    $years,
    $info
   );

   //Find the pics of the aktMez by query
   $sql4   = "SELECT * FROM PicsTable WHERE idPic=" . $aktMez->getIdPic();
   $resPic = $con->query($sql4);
   $aktPic = null;
   if ($resPic) {
    //There is a Pic for aktMez
    while ($u = $resPic->fetch_assoc()) {
     $p2 = "";
     if (isset($u['2'])) {
      $p2 = $u['2'];
     }
     $Path2 = "";
     if (isset($u['Path2'])) {
      $Path2 = $u['Path2'];
     }
     $weared = "";
     if (isset($u['weared'])) {
      $weared = $u['weared'];
     }
     $PathWeared = "";
     if (isset($u['PathWeared'])) {
      $PathWeared = $u['PathWeared'];
     }
     //Create the Pic object by datas
     $aktPic = new Pic(
      $u['idPic'],
      $u['1'],
      $u['Path1'],
      $p2,
      $Path2,
      $weared,
      $PathWeared
     );
    }
   } else {
    $aktPic = new Pic("9999", "basicMez.jpg", "../public/resources/pics/mezek/", "", "", "", "");
   }

   //find the name of the team
   $sql4        = "SELECT tName FROM TeamTable WHERE idTeam= " . $aktMez->getIdTeam();
   $teamNameRes = $con->query($sql4);
   $teamName    = "";
   while ($u = $teamNameRes->fetch_row()) {
    $teamName = $u[0];
   }
   ;
   $tipus = "";
   switch ($aktMez->getType()) {
    case '0':
     $tipus = "Egyéb";
     break;
    case '1':
     $tipus = "Hazai";
     break;
    case '2':
     $tipus = "Vendég";
     break;
    case '3':
     $tipus = "Third";
     break;
    case '4':
     $tipus = "Kapus";
     break;
    default:
     $tipus = "ismeretlen";
     break;
   }
   $aktYears = 'ismeretlen';
   if (strlen($aktMez->getYears()) > 2) {
    $aktYears = $aktMez->getYears();
   }
   $aktInfo = "-";
   if (($aktMez->getInfo())) {
    $aktInfo = $aktMez->getInfo();
   }
   //print out the Pic in a bootstrap "card" element
   $html .= '<div class="card bg-light m-1" style="max-width:270px">'
   . '<div class="card-header"><p>' . $teamName . '</p></div>'
   . '<div class="card-body">'
   . '<div class="row">'
   . '<div class="text-left col card-title"><p><strong>Év:</strong>&nbsp' . $aktYears . '</p></div>'
   . '<div class="text-right col card-title"><p><strong>Típus:</strong>&nbsp' . $tipus . '</p></div>'
   . '</div>' //endof row
    . '<img class="card-img-top" src="' . $aktPic->getPath1() . '' . $aktPic->getP1() . '" alt="Mez_KÉP" style="max-width:265px">'
   . ' <p class="card-text"><strong>Info</strong><br>' . $aktInfo . '</p>'
   . '</div>' //endof card-body
    . '<div class="card-footer text-center">'
   . '<a href="" class=" stretched-link"><p>Megnézem<p></a>'
   . '</div>' //endof footer
    . '</div>'; //endof card

   $counter++;
  }
  ;
  //Result exists
  $html .= '</div></div>';
  echo $html;
 } else {
  //die("nemzetiTeams.php-n nincs res!");//Not print Anything
 }
} else {
 die('Nincs post a nemzetiTeams.php-ra');
}
