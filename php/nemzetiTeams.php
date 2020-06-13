<?php
session_start();

require_once '../config/connect.php'; //database connect
require_once '../config/functions.php'; //using methods
require_once '../php/Mez.php'; //using Mez Class

if (isset($_POST['nId']) && !empty($_POST['nId'])) {
    $nid = $_POST['nId']; //id of nation
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
                        CategoryTable.idCategory=$nid"; // find out the the Mez-s of a Nation
    $res = $con->query($sql);
    if ($res->num_rows > 0) {
        $html .= '<div class="container-fluid"><div class="row">';
        $counter = 0;
        while ($row = $res->fetch_assoc()) {
            if ($counter % 4 == 0) {
                $html .= '</div>
                            <div class="row">';
            }
            //aktmez to a Mez object
            $info = "";
            if (isset($row['info'])) {
                $info = $row['info'];
            }

            $years = "";
            if (isset($row['years'])) {
                $years = $row['years'];
            }

            $uploadDate = substr($row['UploadDate'], 0, 9);

            $sql3 = "SELECT FirstName, LastName FROM UserTable WHERE idUser=" . $row['UploadUser'];
            $result = $con->query($sql3);
            $user = array();
            while ($u = $result->fetch_array()) {
                $user = $u;
            }
            ;
            if (!$user) {
                die("nincs user a MEZhez a nemzetiTeams.php-n");
            }
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
            //Create a Pic Class!!!!
            $aktKep = '<div class="card">'
                        . '<img class="card-image-top" src="'.$row[1].$row[0].'" style="width: 100%">'
                        . '<div class="card-body">'
                            . '<h4 class="card-title">'.$row['nev'].'</h4>'
                            . '<p class="card-text">'.$row['ar'].' Ft</p>'
                            . '<a class="btn btn-outline-success" href="details.php?pid='.$row['id'].'">Részletek</a>&emsp;'
                            . '<button data-id="'. $row['id'].'" class="addcart btn btn-success">Kosárba</button>'
                        . '</div>'
                        . '</div>';
                       </div>';
            $html .= '<div class="col-sm-3 p-1 text-center">' . $aktkep . '</div>';
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
