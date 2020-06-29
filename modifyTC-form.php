<?php
session_start();
require_once 'config/connect.php'; //database connect
require_once 'config/functions.php'; //using methods
if (!isLogged()) {
 header('Location:not_logged_in.php');
}
echo file_get_contents("html/header.html");
echo PrintMenu(); //menu_in.html will appears ?>

<div class="row min-height550">
<!-- left: csapat létrehozása -->
    <div class="col-lg-6">
      <div class="container">
        <div class="bg-warning text-center p-1 mb-1"><h4>Csapat módosítása</h4></div>
            <form id="modT-form" class="needs-validation" novalidate >
                <!-- league select -->
                <div class="form-group row container">
                        <label class="col-lg-2 col-form-label" for="modT-League-select">Liga:</label>
                        <div class="col-lg-10">
                            <select class="form-control custom-select" id="modT-League-select">
<?php
$sql = 'SELECT idLeague, LeagueName FROM LeagueTable ORDER BY LeagueName';
$res = $con->query($sql);
echo '<option selected value="-">Válassz!</option>';
while ($row = mysqli_fetch_row($res)) {
 echo '<option value=' . $row[0] . '>' . $row[1] . '</option>';
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
                <div class="form-group row container">
                        <label class="col-lg-2 col-form-label" for="modT-Cat-select">Kategória:</label>
                        <div class="col-lg-10" id="categorySelectT">
                            <select class="form-control custom-select" id="modT-Cat-select" required>
                              <!-- ajax fills options -->
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
                          <label class="col-lg-2 col-form-label" for="modT-Team-select">Csapat:</label>
                          <div class="col-lg-10" id="teamSelectT">
                            <select class="form-control custom-select" id="modT-Team-select">
                              <option selected value="-">Nincs még csapat!</option>
                              <!-- ajax fills options -->
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
                        <label class="col-lg-2 col-form-label" for="modT-teamName">Csapatnév:</label>
                        <div class="col-lg-10">
                            <input type="text" placeholder="Csapat neve" class="form-control" name="modT-teamName" id="teamName" required minlength="2" maxlength="100">
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
                        <label class="col-lg-2 col-form-label" for="modT-cityName">Városnév: </label>
                        <div class="col-lg-10">
                            <input type="text" placeholder="Város neve" class="form-control" name="modT-cityName" id="cityName" maxlength="100">
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
                        <input type="submit" class="btn btn-primary form-control" value="Módosítás mehet!" id="modTeamSubmit">
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
            <div class="bg-warning text-center p-1 mb-1"><h4>Kategória módosítása</h4></div>
            <form id="modC-form" class="needs-validation" novalidate >
                <div class="form-group row container">
                        <label class="col-lg-2 col-form-label" for="modC-League-select">Liga:</label>
                        <div class="col-lg-10">
                            <select class="form-control custom-select" id="modC-League-select">
<?php
$sql = 'SELECT idLeague, LeagueName FROM LeagueTable ORDER BY LeagueName';
$res = $con->query($sql);
echo '<option selected value="-">Válassz!</option>';
while ($row = mysqli_fetch_row($res)) {
 echo '<option value=' . $row[0] . '>' . $row[1] . '</option>';
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
                        <label class="col-lg-2 col-form-label" for="modC-Cat-select">Kategória:</label>
                        <div class="col-lg-10" id="categorySelectC">
                            <select class="form-control custom-select" id="modC-Cat-select" required>
                              <!-- ajax fills options -->
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
                        <label class="col-lg-2 col-form-label" for="modC-CatName">Kategórianév:</label>
                        <div class="col-lg-10">
                            <input type="text" placeholder="Kategória neve" class="form-control" name="modC-CatName" id="catName" required minlength="2" maxlength="100">
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
                    <input type="submit" class="btn btn-primary form-control" value="Módosítás mehet!" id="catSubmit">
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

<?php
$con->close();
$footer       = file_get_contents("html/footer.html");
$js_modify_TC = '<script src="js/admin_crud_modify_TC.js"></script>';
echo str_replace("::otherjs::", $js_modify_TC, $footer);
