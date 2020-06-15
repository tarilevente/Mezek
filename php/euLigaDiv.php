<?php
//prints out the DIV of euLiga, where the database contains Mez,Pic INTO '#euLigaDiv'

session_start();
require_once '../config/connect.php'; //database connect
require_once '../config/functions.php'; //using methods
require_once '../php/Mez.php'; //using Mez Class

if (isset($_POST['eu']) && 1 == $_POST['eu']) {
 //post is arrived
 $html = '<div class="row">' //The row is for position with the Mez
  . '<div class="sidenav col-lg-2">'; //Sidebar for navigate
 //query for select Categories, WHERE exists Any Mez
 $sql = "SELECT idTeam, tname AS csapat
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
                                    leaguetable.idleague=1
                                )
                        )
        )
        ORDER BY csapat
        ";
 $res = $con->query($sql);
 if ($res) {
  //Team exists
  while ($row = mysqli_fetch_row($res)) {
   $html .= '<div class="toHover text-center p-1"><span class="text-danger text-center data-euLigaMezek" data-euLigaMezekID="' . $row[0] . '">' . $row[1] . '</span></div>';
  }

  $html .= '  </div>' //endof sidenav
   . '<div class="col-lg-10 min-height500 bg-picEULeague2" id="euLigaTeam"></div>' //
   . '<div class="p2"><h2 class="error text-danger"></h2></div>'
  . '</div>' //endof row
  ;
  echo $html;
 } else {
  //no result for searching teams
  $html .= "Nincs adat feltöltve</div>";
 }
} else {
 //no post
 echo '<div class="p2"><h4 class="error text-danger">Hiba, error code = 26481</h4></div>'; //for error messages
}
