<?php
require '../../config/connect.php';
require '../../config/functions.php';

// $response         = array();
// $response['html'] = '';

$html = "";
if (isset($_POST['reset']) && 'reset' === $_POST['reset']) {
 $html = '<select class="form-control custom-select" id="newM-team-select" required>
        </select>
        <div class="valid-feedback">
            Rendben!
        </div>
        <div class="invalid-feedback">
            Válassz!
        </div>';
} else {
 if (isset($_POST['valCat']) && !empty($_POST['valCat'])) {
  $html .= '<select class="form-control custom-select" id="newM-team-select" required>';
  $idCat = $_POST['valCat'];
  $sql   = 'SELECT TeamTable.idTeam, TeamTable.tName FROM TeamTable WHERE idCategory=' . $idCat . ' ORDER BY tName';
  $res   = $con->query($sql);
  if (!$res) {
   //something
   //error
  } else {
   if (0 == $res->num_rows) {
    $html .= '<option selected value="-">Nincs még csapat!</option>';
   } else {
    if (1 == $res->num_rows) {
     while ($row = mysqli_fetch_row($res)) {
      $html .= '<option value=' . $row[0] . '>' . $row[1] . '</option>';
     }
    } else {
     $html .= '<option selected value="-">Válassz!</option>';
     while ($row = mysqli_fetch_row($res)) {
      $html .= '<option value=' . $row[0] . '>' . $row[1] . '</option>';
     }
    }
   }
   $html .= '
        </select>
        <div class="valid-feedback">
            Rendben!
        </div>
        <div class="invalid-feedback">
            Válassz!
        </div>';
  }
 } else {
//do nothing
  //error
  $html = 'error printTeamSelect.php';
 }
}
echo $html;
