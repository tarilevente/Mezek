<?php
//prints out the DIV of egyebMezek, where the database contains Mez,Pic INTO '#NemzetiDiv'

session_start();

require_once '../config/connect.php'; //database connect
require_once '../config/functions.php'; //using methods
require_once '../php/Mez.php'; //using Mez Class

//response initialize
$response              = array();
$response['html']      = "";
$response['error']     = false;
$response['errorCode'] = "";
$response['errMsg']    = '';

if (isset($_POST['egyeb']) && 1 == $_POST['egyeb']) {
 //post is arrived
 $response['html'] = '<div class="row">' //The row is for position with the Mez
  . '<div class="col-lg-2">';
 //query for select Categories, WHERE exists Any Mez
 $sql = "   SELECT idTeam, tname AS csapat
            FROM teamtable
            WHERE idTeam
                IN(
                    SELECT idteam
                    FROM meztable
                    WHERE idteam
                        IN( SELECT idTeam
                            FROM teamtable,categorytable
                            WHERE categoryTable.idcategory=teamtable.idcategory AND
                                categorytable.idcategory
                                    IN(
                                        SELECT idcategory
                                        FROM categorytable,leaguetable
                                        WHERE leaguetable.idleague=categorytable.idleague AND
                                        leaguetable.idleague=4
                                    )
                            )
            )
            ORDER BY csapat";
 $res = mysqli_query($con, $sql);
 if ($res) {
//Team exists
  while ($row = mysqli_fetch_row($res)) {
   $response['html'] .= '
            <div class="card">
                <div class="card-header">
                    <a class="toHover card-link data-egyebMezek" data-EgyebMezekID="' . $row[0] . '">
                    ' . $row[1] . '
                    </a>
                </div>
            </div>';
  }

  $response['html'] .=
  '     </div>' //endof sidenav
   . '  <div class="col-lg-10 min-height500 bg-picEgyeb2" id="egyebMezekTeam"></div>' //
   . '  <div class="p2"><h2 class="error text-danger"></h2></div>'
  . '</div>' //endof row
  ;
 } else {
  $response['error'] = true;
  $response['errMsg'] .= '
        <div class="row">'
   . '   <div class="col-2">Nincs adat feltöltve, a tábla üres. </div>'
   . '<div class="col-10 min-height500 bg-picNemzeti2" id="nationalTeams"></div>';
  http_response_code(513);
  $response['errorCode'] = 56459;
 }

} else {
 //no post arrived
 $response['error'] = true;
 $response['errMsg'] .= '
    <div class="row">
         <div class="col-2">
            <h4 class="text-danger">Hiba, error code = 56456</h4>
         </div>
         <div class="col-10 min-height500 bg-picNemzeti2" id="nationalTeams"></div>
    </div>'; //for error messages
 http_response_code(512);
 $response['errorCode'] = 56456;
}

//response
echo json_encode($response, JSON_UNESCAPED_UNICODE);
