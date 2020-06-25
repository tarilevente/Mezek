<?php
require '../../config/connect.php';
require '../../config/functions.php';

// $response         = array();
// $response['html'] = '';

$html = "";

if (isset($_POST['valLeague']) && !empty($_POST['valLeague'])) {
 $html .= '<select class="form-control custom-select" id="newM-cat-select" required>';
 $idLeague = $_POST['valLeague'];
 $sql      = 'SELECT CategoryTable.idCategory, CatName FROM CategoryTable WHERE idLeague=' . $idLeague . ' ORDER BY CatName';
 $res      = $con->query($sql);
 if (!$res) {
  //something
  //error
 } else {
  if (0 == $res->num_rows) {
   $html .= '<option selected value="-">Nincs még kategória! </option>';
  } else {
   $html .= '<option selected value="-">Válassz!</option>';
   while ($row = mysqli_fetch_row($res)) {
    $html .= '<option value=' . $row[0] . '>' . $row[1] . '</option>';
   }
  }

  $html .= '</select>
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
 $html = 'errorprintCategorySelect.php';
}
echo $html;
