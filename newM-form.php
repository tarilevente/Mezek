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
        <h4>Új Mez létrehozása</h4>
    </div>
    <div class="container-fluid">
        <div class="row height250">
            <div class="col-lg-4">
                <div class="image-area height250 border">
                    <img id="imageResult" src="#" alt="" class="img-fluid rounded mx-auto d-block align-self-center" >
                </div>
            </div>
            <div class="col-lg-4">
                <div class="image-area height250 border">
                    <img id="imageResult2" src="#" alt="" class="img-fluid rounded mx-auto d-block align-self-center" >
                </div>
            </div>
            <div class="col-lg-4">
                <div class="image-area height250 border">
                    <img id="imageResult3" src="#" alt="" class="img-fluid rounded mx-auto d-block align-self-center">
                </div>
            </div>
        </div>
        <form id="newM-form" class="needs-validation" novalidate>
            <!-- upload pics -->
            <div class="row">
                <div class="col-lg-4">
                    <div class="input-group mb-3 p-2 rounded-pill bg-white shadow-sm">
                        <input id="upload" type="file" class="form-control border-0 kepFeltoltes" name="#imageResult">
                        <label id="upload-label" for="upload" class="font-weight-light text-muted">Kép1 - kötelező</label>
                        <div class="input-group-append">
                            <label for="upload" class="btn btn-light m-0 rounded-pill px-4">
                                <i class="fa fa-cloud-upload mr-2 text-muted"></i>
                                <small class="text-uppercase font-weight-bold text-muted">Kép1</small>
                            </label>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="input-group mb-3 p-2 rounded-pill bg-white shadow-sm">
                        <input id="upload2" type="file" class="form-control border-0 kepFeltoltes" name="#imageResult2">
                        <label id="upload-label2" for="upload2" class="font-weight-light text-muted">Kép2 - nem kötelező</label>
                        <div class="input-group-append">
                            <label for="upload2" class="btn btn-light m-0 rounded-pill px-4">
                                <i class="fa fa-cloud-upload mr-2 text-muted"></i>
                                <small class="text-uppercase font-weight-bold text-muted">Kép2</small>
                            </label>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="input-group mb-3 p-2 rounded-pill bg-white shadow-sm">
                        <input id="upload3" type="file" class="form-control border-0 kepFeltoltes" name="#imageResult3">
                        <label id="upload-label3" for="upload3" class="font-weight-light text-muted">Kép3 - nem kötelező</label>
                        <div class="input-group-append">
                            <label for="upload3" class="btn btn-light m-0 rounded-pill px-4">
                                <i class="fa fa-cloud-upload mr-2 text-muted"></i>
                                <small class="text-uppercase font-weight-bold text-muted">Kép3</small>
                            </label>
                        </div>
                    </div>
                </div>
            </div><!--endof row, endof pic upload-->
            <!-- ========================================================================================================== -->
            <div class="border-bottom my-2"></div>

            <!-- start of inputs -->
            <div class="row">
                <!-- left column -->
                <div class="col-xl-6 height280">
                    <!-- league select -->
                    <div class="form-group row container">
                        <label class="col-lg-2 col-form-label" for="newM-league-select">Liga:</label>
                        <div class="col-lg-10">
                            <select class="form-control custom-select" id="newM-league-select">
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
                        <label class="col-lg-2 col-form-label" for="newM-Cat-select">Kategória:</label>
                        <div class="col-lg-10" id="categorySelect">
                            <select class="form-control custom-select" id="newM-Cat-select" required>
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
                    <label class="col-lg-2 col-form-label" for="newM-team-select">Csapat:</label>
                    <div class="col-lg-10" id="teamSelect">
                        <select class="form-control custom-select" id="newM-team-select" required>
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

                    <!-- years -->
                    <div class="form-group row container">
                        <label class="col-lg-2 col-form-label" for="newM-years">Év:</label>
                        <div class="col-lg-10">
                            <input type="text" placeholder="Ezekben az években hordták a mezt" class="form-control" name="newM-years" id="newM-years" maxlength="100">
                            <small id="passwordHelpBlock" class="form-text text-muted">
                                <strong>Nem</strong> kötelező mező
                            </small>
                            <div class="valid-feedback">
                                Rendben!
                            </div>
                            <div class="invalid-feedback">
                                Max. 100 karakter lehet!
                            </div>
                        </div>
                    </div> <!--endof years-->
                </div><!--endof left column-->

                <!-- right column -->
                <div class="col-xl-6 height280">
                    <!-- type -->
                    <div class="form-group row container">
                        <label class="col-lg-2 col-form-label" for="newM-type-select">Típus:</label>
                        <div class="col-lg-10">
                            <select class="form-control custom-select" id="newM-type-select">
                                <option value="0">Egyéb típusú mez</option>
                                <option value="1" selected>Hazai mez</option>
                                <option value="2">Vendég mez</option>
                                <option value="3">Harmadik számú mez</option>
                                <option value="4">Kapus mez</option>
                            </select>
                            <div class="valid-feedback">
                                Rendben!
                            </div>
                            <div class="invalid-feedback">
                                Válassz!
                            </div>
                        </div>
                    </div><!--endof type-->
                    <!-- info -->
                    <div class="form-group row container">
                        <label class="col-lg-2 col-form-label" for="newM-info">Info:</label>
                        <div class="col-lg-10">
                            <textarea rows="6" cols="25" class="form-control" name="newM-info" id="newM-info" maxlength="255"></textarea>
                            <small id="passwordHelpBlock" class="form-text text-muted">
                                <strong>Nem</strong> kötelező mező
                            </small>
                            <div class="valid-feedback">
                                Rendben!
                            </div>
                            <div class="invalid-feedback">
                                Max. 255 karakter lehet!
                            </div>
                        </div>
                    </div> <!--endof info-->
                    <!-- submit, reset -->
                    <div class="form-group row container">
                            <div class="col-lg-2"></div>
                            <div class="col-lg-10">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <input type="button" class="btn btn-primary form-control" value="Reset" id="resetM">
                                    </div>
                                    <div class="col-lg-6">
                                        <input type="submit" name="submitMez" id="submitMez" value="Mez feltöltése" class="btn btn-primary form-control">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div><!--endof submit, reset-->
                </div><!--endof right column-->
            </div><!--endof row-->
            <div id="errorVanM" class="bg-danger p-1 text-light"></div>
            <div id="successVanM" class="bg-success p-1 text-light"></div>
        </form>
    </div><!--endof container-fluid-->
</div> <!--endof min-height550-->
<script>
// Example starter JavaScript for disabling form submissions if there are invalid fields
(function() {
    'use strict';
    window.addEventListener('load', function() {
        // Fetch all the forms we want to apply custom Bootstrap validation styles to
        var forms = document.getElementsByClassName('needs-validation');
        // Loop over them and prevent submission
    var validation = Array.prototype.filter.call(forms, function(form) {
        form.addEventListener('submit', function(event) {
            if (form.checkValidity() === false) {
                event.preventDefault();
                event.stopPropagation();
            }
            form.classList.add('was-validated');
        }, false);
    });
  }, false);
})();
</script>

<?php
$con->close();
$footer    = file_get_contents("html/footer.html");
$js_newMez = '<script src="js/admin_crud_newM.js"></script>';
echo str_replace("::otherjs::", $js_newMez, $footer);
