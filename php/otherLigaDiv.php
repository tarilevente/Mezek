<?php
//prints out the DIV of otherLiga, where the database contains Mez,Pic INTO '#otherLigaDiv'

session_start();
require_once '../config/connect.php'; //database connect
require_once '../config/functions.php'; //using methods
require_once '../php/Mez.php'; //using Mez Class

if (isset($_POST['other']) && 1 == $_POST['other']) {
 //post is arrived
 $html = '<div class="row">'; //The row is for positioning
 $html .= '<div class="col-lg-2">';
 $html .= '<div id="accordion">';
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
                                    leaguetable.idleague=2
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
    $html .= '      <div class="card" >
                        <div class="card-header">
                                <a class="card-link" data-toggle="collapse" href=" #collapse' . $colCounter . ' " >
                                    ' . $row[0] . '
                                </a>
                        </div>
                    <div id="collapse' . $colCounter . '" class="collapse show" data-parent="#accordion" >';
   }

   if ($aktCategory != $row[0]) {
    $colCounter++;
    $html .= "  </div>" // endof Collapse1
     . "    </div>"; //endof card
    //open a new card
    $html .= '<div class="card">
                <div class="card-header">
                        <a class="collapsed card-link" data-toggle="collapse" href="#collapse' . $colCounter . '" >
                            ' . $row[0] . '
                        </a>
                </div>
                <div id="collapse' . $colCounter . '" class="collapse" data-parent="#accordion">';
    $aktCategory = $row[0];
   }
   $html .= '       <div class="card-body toHover data-otherLigaMezek" data-otherLigaMezekID="' . $row[1] . '">
                        <span class="text-center">' . $row[2] . '</span>
                    </div>';
  }

  $html .= '   </div>'; //endof the last collapse
  //   $html .= "</div>"; //endof last card
  $html .= '</div>'; //endof accordion
  $html .= '</div>'; //endof col-2

  $html .= '</div> ' //endof row
   . '<div class="col-lg-10 min-height500 bg-picOtherLeague2" id="otherLigaTeam"></div>'; //place of Mez-s
  $html .= '<div class="p2"><h2 class="error text-danger"></h2></div>' //error
   . '</div>' //endof row
  ;
  echo $html;
 } else {
  //no result for searching teams
  $html .= "Nincs adat feltöltve</div>";
 }
} else {
 //no post
 echo '<div class="p2"><h4 class="error text-danger">Hiba, error code = 12674</h4></div>'; //for error messages
}
