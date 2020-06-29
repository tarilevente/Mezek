<?php
require '../../config/connect.php';
require '../../config/functions.php';

$html = "";

if (isset($_POST['valLeague']) && !empty($_POST['valLeague'])) {
 $html = printCatSelectOptions($con, $_POST['valLeague'], 'modifyM-Cat-select');
} else {
 //no post
}
echo $html;
