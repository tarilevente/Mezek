<?php
session_start();

require_once '../config/connect.php'; //database connect
require_once '../config/functions.php'; //using methods
require_once '../php/Mez.php'; //using Mez Class

if (isset($_POST['nemzeti']) && 1 == $_POST['nemzeti']) {
//post is arrived
    $html = '<div class="row">' //Simple sidebar for nations where pics exist -- https://www.w3schools.com/howto/howto_js_dropdown_sidenav.asp
     . '<div class="sidenav col-2 bg-primary ">';

//query
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
        //Result exists
        while ($row = mysqli_fetch_row($res)) {
            $html .= '<span href="" class=" text-danger text-center data-national" data-nationalID="' . $row[0] . '">' . $row[1] . '</span>';
        }

        $html .= '  </div>' //endof sidenav
         . '<div class="col-10 bg-warning min-height500" id="nationalTeams" ></div>'
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
