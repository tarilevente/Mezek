<?php
require '../../config/connect.php';
require '../../config/functions.php';

$html = "";
if (isset($_POST['reset']) && 'reset' === $_POST['reset']) {
 $html = '<select class="form-control custom-select" id="modifyM-Team-select" required>
        </select>
        <div class="valid-feedback">
            Rendben!
        </div>
        <div class="invalid-feedback">
            Válassz!
        </div>';
} else {
 if (isset($_POST['valCat']) && !empty($_POST['valCat'])) {
  $html = printTeamSelectOptions($con, $_POST['valCat'], "modifyM-Team-select");
 }
}
echo $html;
