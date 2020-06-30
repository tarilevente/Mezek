
<?php
session_start();
require_once 'config/connect.php'; //database connect
require_once 'config/functions.php'; //using methods
if (!isLogged()) {
 header('Location:not_logged_in.php');
}
echo file_get_contents("html/header.html");
$menu = PrintMenu(); //menu_in.html will appears
echo $menu;
?>

<div class="min-height550 container-fluid">
    <div class="bg-warning text-center p-1 mb-1">
        <h4>Mez módosítása</h4>
    </div>
        <!-- <form id="newM-form" class="needs-validation" novalidate> -->
            <div class="container text-center">
                    <!-- league select -->
                    <div class="form-group row container">
                        <label class="col-lg-2 col-form-label text-left" for="modifyM-League-select">Liga:</label>
                        <div class="col-lg-10">
                            <select class="form-control custom-select" id="modifyM-League-select">
<?php
$sql1 = 'SELECT idLeague, LeagueName FROM LeagueTable ORDER BY LeagueName';
$res1 = $con->query($sql1);
echo '<option selected value="-">Válassz!</option>';
while ($row1 = mysqli_fetch_row($res1)) {
 echo '<option value=' . $row1[0] . '>' . $row1[1] . '</option>';
}
?>
                            </select>
                            <div class="valid-feedback">
                                 Rendben!
                            </div>
                            <div class="invalid-feedback">
                                 Válassz!
                            </div>
                        </div>
                    </div><!--endof league select-->

                    <!-- category select -->
                    <div class="form-group row container">
                        <label class="col-lg-2 col-form-label text-left" for="modifyM-Cat-select">Kategória:</label>
                        <div class="col-lg-10" id="categorySelect">
                            <select class="form-control custom-select" id="modifyM-Cat-select" required>
                                <!-- ajax fills options funtions.php via printCategorySelect_newM.php-->
                            </select>
                            <div class="valid-feedback">
                                Rendben!
                            </div>
                            <div class="invalid-feedback">
                                Válassz!
                            </div>
                        </div>
                    </div><!--endof category select-->


                <!-- team select -->
                <div class="form-group row container">
                    <label class="col-lg-2 col-form-label text-left" for="modifyM-Team-select">Csapat:</label>
                    <div class="col-lg-10" id="teamSelect">
                        <select class="form-control custom-select" id="modifyM-Team-select" required>
                        <!-- ajax fills options funtions.php via printTeamSelect_newM.php-->
                        </select>
                        <div class="valid-feedback">
                            Rendben!
                        </div>
                        <div class="invalid-feedback">
                            Válassz!
                        </div>
                    </div>
                </div><!--endof team select-->
        </div><!---endof container-->
        <!-- team cards to choose Mez -->
        <div id="teamCards" class="text-center">
        </div>
        <div id="ModifyMezID">

        </div><!--endof ModifyMezID-->
            <div id="errorVanM" class="bg-danger p-1 text-light">
            <div id="successVanM" class="bg-success p-1 text-light"></div>
        </form>
    </div><!--endof container-fluid-->
</div> <!--endof min-height550-->

<?php
$con->close();
$footer    = file_get_contents("html/footer.html");
$js_newMez = '<script src="js/admin_crud_modifyM.js"></script>';
echo str_replace("::otherjs::", $js_newMez, $footer);
