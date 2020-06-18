<?php
//prints out the DIV of euLiga, where the database contains Mez,Pic INTO '#euLigaDiv'

session_start();
require_once '../config/connect.php'; //database connect
require_once '../config/functions.php'; //using methods
require_once '../php/Mez.php'; //using Mez Class

//response
$response              = array();
$response['html']      = "";
$response['error']     = false;
$response['errorCode'] = "";
$response['errMsg']    = '';

if (isset($_POST['eu']) && 1 == $_POST['eu']) {
 //post is arrived
 $response['html'] = '<div class="row">'; //The row is for positioning
 $response['html'] .= '<div class="col-lg-2">';
 $response['html'] .= '<div id="accordion">';
 //query for select teams, WHERE exists Any Mez
 $sql = "SELECT categorytable.CatName as kategoria, idTeam, tname AS csapat
        FROM teamtable, categorytable
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
                                    leaguetable.idleague=1
                                )
                        )
        )
        And categorytable.idCategory=teamtable.idCategory
        ORDER BY kategoria
        ";
 $res = $con->query($sql);
 if ($res) {
  //Team exists
  $colCounter  = 1;
  $aktCategory = "";
  $first       = true;
  while ($row = mysqli_fetch_array($res)) {
   if (true == $first) {
    $first       = false;
    $aktCategory = $row[0];
    $response['html'] .= '
          <div class="card" >
                        <div class="card-header">
                                <a class="card-link" data-toggle="collapse" href=" #collapse' . $colCounter . ' " >
                                    ' . $row[0] . '
                                </a>
                        </div>
                         <div id="collapse' . $colCounter . '" class="collapse show" data-parent="#accordion" >';
   }

   if ($aktCategory != $row[0]) {
    $colCounter++;
    $response['html'] .= "
                </div>" // endof Collapse1
     . "    </div>"; //endof card
    //open a new card
    $response['html'] .=
     '<div class="card">
                <div class="card-header">
                        <a class="collapsed card-link" data-toggle="collapse" href="#collapse' . $colCounter . '" >
                            ' . $row[0] . '
                        </a>
                </div>
                <div id="collapse' . $colCounter . '" class="collapse" data-parent="#accordion">';
    $aktCategory = $row[0];
   }
   $response['html'] .=
    '       <div class="card-body toHover data-euLigaMezek" data-euLigaMezekID="' . $row[1] . '">
                        <span class="text-center">' . $row[2] . '</span>
                    </div>';
  }

  $response['html'] .= '   </div>'; //endof the last collapse
  //   $html .= "</div>"; //endof last card
  $response['html'] .= '</div>'; //endof accordion
  $response['html'] .= '</div>'; //endof col-2

  $response['html'] .= '</div> ' //endof row
   . '<div class="col-lg-10 min-height500 bg-picEULeague2" id="euLigaTeam"></div>'; //place of Mez-s
  $response['html'] .= '<div class="p2"><h2 class="error text-danger"></h2></div>' //error
   . '</div>' //endof row
  ;
 } else {
  //no result for searching teams
  $response['error'] = true;
  $response['errMsg'] .= '
      <div class="row">'
   . '   <div class="col-2">Nincs adat feltöltve, a tábla üres. </div>'
   . '<div class="col-10 min-height500 bg-picNemzeti2" id="nationalTeams"></div>';
  http_response_code(512);
  $response['errorCode'] = 26484;
 }
} else {
 //no post
 $response['error'] = true;
 $response['errMsg'] .= '
    <div class="row">
         <div class="col-2">
            <h4 class="text-danger">Hiba, error code = 26481</h4>
         </div>
         <div class="col-10 min-height500 bg-picNemzeti2" id="nationalTeams"></div>
    </div>'; //for error messages
 http_response_code(512);
 $response['errorCode'] = 26481;
}

echo json_encode($response, JSON_UNESCAPED_UNICODE);
