<?php
//prints out the DIV of nations, where the database contains Mez,Pic INTO '#NemzetiDiv'

session_start();

require_once '../config/connect.php'; //database connect
require_once '../config/functions.php'; //using methods
require_once '../php/Mez.php'; //using Mez Class

if (isset($_POST['nemzeti']) && 1 == $_POST['nemzeti']) {
//post is arrived
 $html = '<div class="row">' //The row is for position with the Mez (nemzetiTeams.php writes out)
  . '<div class="sidenav col-lg-2">'; //Simple sidebar for nations where pics exist -- https://www.w3schools.com/howto/howto_js_dropdown_sidenav.asp

//query for select Categories, WHERE exists Any Mez
 $sql = "SELECT CategoryTable.idCategory, CategoryTable.CatName AS valogatott
            FROM CategoryTable, LeagueTable
            WHERE   LeagueTable.idLeague = CategoryTable.idLeague AND
                    LeagueName LIKE 'Nemzeti válogatottak' AND
                    categorytable.idCategory
                        IN(
                          SELECT teamtable.idCategory
                          from teamtable, categorytable,meztable
                          WHERE teamtable.idCategory=categorytable.idCategory AND
                              teamtable.idTeam=meztable.idTeam AND
                              teamtable.idTeam IN(
                                SELECT idTeam FROM meztable
                              )
                        )
            ORDER BY valogatott";

 $res = mysqli_query($con, $sql);
 if ($res) {
  //Category exists
  while ($row = mysqli_fetch_row($res)) {
   $html .= '<div class="toHover text-center p-1"><span class="text-danger text-center data-national" data-nationalID="' . $row[0] . '">' . $row[1] . '</span></div>';
  }

  $html .= '  </div>' //endof sidenav
   . '<div class="col-lg-10 min-height500 bg-picNemzeti2" id="nationalTeams"></div>'
  . '</div>' //endof row
  ; //for national teams. js ajax fills with data when it occurs
  echo $html;

 } else {
  die("A lekérdezés nem vezetett eredményre a national.php-n");
 }

//response

} else {
 die('Nincs post a nemzetiPHP-ra');
}
