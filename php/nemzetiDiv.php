<?php
//prints out the DIV of nations, where the database contains Mez,Pic... INTO '#NemzetiDiv'

session_start();

require_once '../config/connect.php'; //database connect
require_once '../config/functions.php'; //using methods
require_once '../php/Mez.php'; //using Mez Class

if (isset($_POST['nemzeti']) && 1 == $_POST['nemzeti']) {
//post is arrived
 $html = '<div class="row">' //The row is for position with the Mez (nemzetiTeamsShow.php writes out)
  . '<div class="col-lg-2">'; //Simple sidebar for nations where pics exist
 //query for select Categories, WHERE exists Any Mez
 $sql = "SELECT CategoryTable.idCategory, CategoryTable.CatName AS valogatott
            FROM CategoryTable, LeagueTable
            WHERE   LeagueTable.idLeague = CategoryTable.idLeague AND
                    LeagueName LIKE 'Nemzeti válogatottak' AND
                    CategoryTable.idCategory
                        IN(
                          SELECT TeamTable.idCategory
                          from TeamTable, CategoryTable,MezTable
                          WHERE TeamTable.idCategory = CategoryTable.idCategory AND
                              TeamTable.idTeam = MezTable.idTeam AND
                              TeamTable.idTeam IN(
                                SELECT idTeam FROM MezTable
                              )
                        )
            ORDER BY valogatott";

 $res = mysqli_query($con, $sql);
 if ($res) {
  //Category exists
  while ($row = mysqli_fetch_row($res)) {
   $html .= '<div class="card">
                <div class="card-header">
                  <a class="toHover card-link data-national" data-nationalID="' . $row[0] . '">
                    ' . $row[1] . '
                  </a>
                </div>
             </div>';
  }

  $html .= ''
  . '</div>' //endof col-lg-2
   . '<div class="col-lg-10 min-height500 bg-picNemzeti2" id="nationalTeams"></div>'
  . '</div>' //endof row
  ; //for national teams. js ajax fills with data when it occurs
  echo $html;

 } else {
  $html .= 'Nincs adat feltöltve</div>'
   . '<div class="col-lg-10 min-height500 bg-picNemzeti2" id="nationalTeams"></div>';
 }
} else {
 //no post
 echo '<div class="p2"><h4 class="error text-danger">Hiba, error code = 78691</h4></div>'; //for error messages
}
