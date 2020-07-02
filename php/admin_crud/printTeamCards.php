<?php
require '../../config/connect.php';
require '../../config/functions.php';

$response              = array();
$response['html']      = "";
$response['error']     = false;
$response['errorCode'] = "";
$response['errMsg']    = '';

if (isset($_POST['idTeam']) && !empty($_POST['idTeam'])) {
 $idTeam = $_POST['idTeam'];
 if ($idTeam < 0) {$response['html'] = 'Válassz egy csapatot! ';} else {
  $sql = 'SELECT * FROM MezTable, PicsTable WHERE idTeam=' . $idTeam . ' AND MezTable.idPic=PicsTable.idPic';
  $res = $con->query($sql);
  if (!$res || 0 == $res->num_rows) {
   $response['html'] .= 'Nincs megjeleníthető mez! Először fel kell töltened egy képet. ';
  } else {
   $response['html'] .= '<div class="container-fluid text-center row">';
   $idPic      = '';
   $idMez      = '';
   $type       = '';
   $kep1       = '';
   $uploadDate = '';
   $Path1      = '';
   while ($row = mysqli_fetch_assoc($res)) {
    $idMez      = $row['idMez'];
    $Path1      = $row['Path1'];
    $kep1       = $row['1'];
    $type       = $row['Type'];
    $idPic      = $row['idPic'];
    $uploadDate = $row['UploadDate'];
    $typeString = getTypeString($type);

    $response['html'] .= '
        <div class="col-lg-3 p-1">
            <div class="card shadow MezCard p-2">
                <div class="height70PC">
                    <img class="card-img-top MezCardImg" src="' . $Path1 . $kep1 . '" alt="kep_' . $idPic . ', mez_' . $idMez . '">
                </div>
                <div class="card-body">
                    <h5 class="card-title">' . $typeString . '<smal><small> [' . $idMez . ']</small></small></h5>
                    <p class="card-text">Feltöltés: ' . $uploadDate . '</p>
                    <a href="#ModifyMezID" class="btn btn-primary ModifyMezCLASS m-1"  data-id="' . $idMez . '">Módosítom</a>
                </div>
            </div>
        </div> <!--endof card-->
            ';
   } //endof while
   $response['html'] .= '</div>'; //endof row
  } //endof $res
 } //endof $idTeam >0
} //endof isset$(_post..)
else {
 //no post, or empty post
 $response['error']    = true;
 $response['errorMsg'] = 'Nincs post a printTeamCards.php-re';
}

echo json_encode($response, JSON_UNESCAPED_UNICODE);
