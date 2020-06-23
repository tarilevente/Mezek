<?php
require 'config/functions.php';
echo file_get_contents("html/header.html");
?>

<div class="container-fluid bg_not_logged_in min-height500" >
<h2 class="text-warning text-left p-2 not_logged_in_resp">Be kell lépned a megtekintéshez! :( </h2>

<div class="text-right"><a href="index.php" class="text-center bg-success text-light p-3">Vissza a kezdőlapra</a></div>
</div>

<?php
echo file_get_contents("html/footer.html");
