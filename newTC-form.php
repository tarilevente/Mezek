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

<div class="row">
<!-- left: csapat létrehozása -->
    <div class="col-lg-6">
      <div class="container">
        <div class="bg-warning text-center p-1 mb-1"><h4>Új csapat létrehozása</h4></div>
            <form id="newT-form" class="needs-validation" novalidate >
                <div class="form-group row container">
                        <label class="col-lg-2 col-form-label" for="newT-Cat-select">Kategória:</label>
                        <div class="col-lg-10">
                            <select class="form-control custom-select" id="newT-Cat-select">
<?php
$sql = 'SELECT categorytable.idCategory, categorytable.CatName FROM categorytable ORDER BY categorytable.CatName';
$res = $con->query($sql);
if (!$res) {
 //  $response['errorT']     = true;
 //  $response['errorMsgT']  = "Nincs kategória az adatbázisban. error code: 75110";
 //  $response['errorCodeT'] = "75110";
} else {
 $first = true;
 while ($row = mysqli_fetch_row($res)) {
  if (true === $first) {
   echo '<option selected value=' . $row[0] . '>' . $row[1] . '</option>';
   $first = false;
  } else {
   echo '<option value=' . $row[0] . '>' . $row[1] . '</option>';
  }

 }
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
                </div>
                <div class="form-group row container">
                        <label class="col-lg-2 col-form-label" for="newT-teamName">Csapatnév:</label>
                        <div class="col-lg-10">
                            <input type="text" placeholder="Csapat neve" class="form-control" name="newT-teamName" id="teamName" required minlength="2" maxlength="100">
                            <small id="passwordHelpBlock" class="form-text text-muted">
                                <strong>Kötelező</strong> mező
                            </small>
                            <div class="valid-feedback">
                                Rendben!
                            </div>
                            <div class="invalid-feedback">
                                Min. 2, és Max. 100 karakter lehet!
                            </div>
                        </div>
                </div>
                <div class="form-group row container">
                        <label class="col-lg-2 col-form-label" for="newT-cityName">Városnév: </label>
                        <div class="col-lg-10">
                            <input type="text" placeholder="Város neve" class="form-control" name="newT-cityName" id="cityName" maxlength="100">
                              <small id="passwordHelpBlock" class="form-text text-muted">
                                <strong>Nem</strong> kötelező
                              </small>
                              <div class="valid-feedback">
                                  Rendben!
                              </div>
                              <div class="invalid-feedback">
                                  A városnév túl hosszú!
                              </div>
                        </div>
                </div>
                <div class="row mb-1">
                  <div class="col">
                        <input type="button" class="btn btn-primary form-control" value="Reset" id="resetT">
                  </div>
                  <div class="col">
                        <input type="submit" class="btn btn-primary form-control" value="Új csapat: Mehet" id="teamSubmit">
                  </div>
                </div>
                <div class="bg-danger text-light p-1 m-1" id="errorVanT"></div>
                <div class="bg-success text-light p-1 m-1" id="successVanT"></div>
            </form>
          </div>
          <!-- endof container -->
        </div>
        <!-- //endof col-lg-6 //endof csapat létrehozása -->
        <!-- ================================================================================================================= -->
        <!-- //right: kategória létrehozása -->
        <div class="col-lg-6">
          <div class="container">
            <div class="bg-warning text-center p-1 mb-1"><h4>Új kategória létrehozása</h4></div>
            <form id="newC-form" class="needs-validation" novalidate >
                <div class="form-group row container">
                        <label class="col-lg-2 col-form-label" for="newC-Liga-select">Liga:</label>
                        <div class="col-lg-10">
                            <select class="form-control custom-select" id="newC-Liga-select">
<?php
$sql = 'SELECT LeagueTable.idLeague, LeagueTable.LeagueName FROM LeagueTable ORDER BY LeagueName';
$res = $con->query($sql);
if (!$res) {
 //  $response['errorT']     = true;
 //  $response['errorMsgT']  = "Nincs kategória az adatbázisban. error code: 75110";
 //  $response['errorCodeT'] = "75110";
} else {
 $first = true;
 while ($row = mysqli_fetch_row($res)) {
  if (true === $first) {
   echo '<option selected value=' . $row[0] . '>' . $row[1] . '</option>';
   $first = false;
  } else {
   echo '<option value=' . $row[0] . '>' . $row[1] . '</option>';
  }
 }
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
                </div>
                <div class="form-group row container">
                        <label class="col-lg-2 col-form-label" for="newC-CatName">Kategórianév:</label>
                        <div class="col-lg-10">
                            <input type="text" placeholder="Kategória neve" class="form-control" name="newC-CatName" id="catName" required minlength="2" maxlength="100">
                              <small id="passwordHelpBlock2" class="form-text text-muted">
                                  <strong>Kötelező</strong> mező
                              </small>
                              <div class="valid-feedback">
                                  Rendben!
                              </div>
                              <div class="invalid-feedback">
                                  Min. 2, és Max. 100 karakter lehet!
                              </div>
                        </div>
                </div>
                <div class="row">
                  <div class="col">
                    <input type="button" class="btn btn-primary form-control" value="Reset" id="resetC">
                  </div>
                  <div class="col">
                    <input type="submit" class="btn btn-primary form-control" value="Új Kategória: Mehet" id="catSubmit">
                  </div>
                </div>
                <div class="bg-danger text-light p-1 m-1" id="errorVanC"></div>
                <div class="bg-success text-light p-1 m-1" id="successVanC"></div>
            </form>

            </div>
          <!--endof kategória létrehozása -->
          </div>
          <!-- endof container -->
        </div>
         <!-- //endof col-lg-6 -->
</div>

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
echo file_get_contents("html/footer.html");
