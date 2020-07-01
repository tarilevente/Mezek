<?php
require_once 'config/connect.php'; //database connect
require_once 'config/functions.php'; //using methods
if (!isset($_GET['idMez'])) {die('Valami hiba történt! :(');}
//read out the current datas from database
$idMez = $_GET['idMez'];
$sql   = 'SELECT * FROM MezTable, PicsTable WHERE MezTable.idPic=PicsTable.idPic AND MezTable.idMez=' . $idMez;
$res   = $con->query($sql);
if (!$res) {
 die('Valami hiba történt! :(:(');
} else {
 $idTeam = null;
 $type   = null;
 $years  = null;
 $info   = null;
 $idPic  = null;
 $kep1   = null;
 $Path1  = null;
 $kep2   = null;
 $Path2  = null;
 $kep3   = null;
 $Path3  = null;
 while ($row = mysqli_fetch_assoc($res)) {
  $idTeam = $row['idTeam'];
  $type   = $row['Type'];
  $years  = $row['Years'];
  $info   = $row['Info'];
  $idPic  = $row['idPic'];
  $kep1   = $row['1'];
  $Path1  = $row['Path1'];
  $kep2   = $row['2'];
  $Path2  = $row['Path2'];
  $kep3   = $row['weared'];
  $Path3  = $row['PathWeared'];

  $typeString = getTypeString($type);
 } //endof while
}
; //endof $res ?>

<div class="min-height550 container-fluid">
    <div class="bg-warning text-center p-1 mb-1">
        <h4>Módosítás: [<?php echo $idMez; ?>]-as mez</h4>
    </div>
    <div class="container-fluid">
        <div class="row height250">
            <div class="col-lg-4">
                <div class="image-area height250 border">
                    <img id="imageResult" src="<?php if (isset($kep1)) {echo $Path1 . $kep1;} else {echo '#';} ?>" alt="kep1" class="img-fluid rounded mx-auto d-block align-self-center" >
                </div>
            </div>
            <div class="col-lg-4">
                <div class="image-area height250 border">
                    <img id="imageResult2" src="<?php if (isset($kep2)) {echo $Path2 . $kep2;} else {echo '#';} ?>" alt="" class="img-fluid rounded mx-auto d-block align-self-center" >
                </div>
            </div>
            <div class="col-lg-4">
                <div class="image-area height250 border">
                    <img id="imageResult3" src="<?php if (isset($kep3)) {echo $Path3 . $kep3;} else {echo '#';} ?>" alt="" class="img-fluid rounded mx-auto d-block align-self-center">
                </div>
            </div>
        </div>
        <form id="modM-form" class="needs-validation" novalidate>
            <!-- upload pics -->
            <div class="row">
                <div class="col-lg-4">
                    <div class="input-group mb-3 p-2 rounded-pill bg-white shadow-sm">
                        <input id="uploadMod" type="file" accept="image/*"   class="form-control border-0 kepFeltoltes" name="#imageResult">
                        <label id="upload-labelMod" for="uploadMod" class="font-weight-light text-muted">Kép1 - kötelező</label>
                        <div class="input-group-append">
                            <label for="uploadMod" class="btn btn-light m-0 rounded-pill px-4">
                                <i class="fa fa-cloud-upload mr-2 text-muted"></i>
                                <small class="text-uppercase font-weight-bold text-muted">Kép1</small>
                            </label>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="input-group mb-3 p-2 rounded-pill bg-white shadow-sm">
                        <input id="uploadMod2" type="file" accept="image/*"   class="form-control border-0 kepFeltoltes" name="#imageResult2">
                        <label id="upload-labelMod2" for="uploadMod2" class="font-weight-light text-muted">Kép2 - nem kötelező</label>
                        <div class="input-group-append">
                            <label for="uploadMod2" class="btn btn-light m-0 rounded-pill px-4">
                                <i class="fa fa-cloud-upload mr-2 text-muted"></i>
                                <small class="text-uppercase font-weight-bold text-muted">Kép2</small>
                            </label>
                        </div>
                        <div class="input-group-append">
                            <label  class="btn btn-light m-0 rounded-pill px-4 deletePicKep2">
                                <i class="fa fa-cloud-upload mr-2 text-muted"></i>
                                <small class="text-uppercase font-weight-bold text-muted">Töröl</small>
                            </label>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="input-group mb-3 p-2 rounded-pill bg-white shadow-sm">
                        <input id="uploadMod3" type="file" accept="image/*"   class="form-control border-0 kepFeltoltes" name="#imageResult3">
                        <label id="upload-labelMod3" for="uploadMod3" class="font-weight-light text-muted">Kép3 - nem kötelező</label>
                        <div class="input-group-append">
                            <label for="uploadMod3" class="btn btn-light m-0 rounded-pill px-4">
                                <i class="fa fa-cloud-upload mr-2 text-muted"></i>
                                <small class="text-uppercase font-weight-bold text-muted">Kép3</small>
                            </label>
                        </div>
                        <div class="input-group-append">
                            <label  class="btn btn-light m-0 rounded-pill px-4 deletePicKep3">
                                <i class="fa fa-cloud-upload mr-2 text-muted"></i>
                                <small class="text-uppercase font-weight-bold text-muted">Töröl</small>
                            </label>
                        </div>
                    </div>
                </div>
            </div><!--endof row, endof pic upload-->
            <!-- ========================================================================================================== -->
            <div class="border-bottom my-3"></div>

            <!-- start of inputs -->
            <div class="row">
                <!-- left column -->
                <div class="col-xl-6 height280">
                    <!-- years -->
                    <div class="form-group row container">
                        <label class="col-lg-2 col-form-label" for="modM-Years">Év:</label>
                        <div class="col-lg-10">
                            <input type="text" placeholder="Ezekben az években hordták a mezt" class="form-control" name="modM-Years" id="modM-Years" maxlength="100" value="<?php if (isset($years)) {echo $years;} ?>">
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
                    <!-- type -->
                    <div class="form-group row container">
                        <label class="col-lg-2 col-form-label" for="modM-Type-select">Típus:</label>
                        <div class="col-lg-10">
                            <select class="form-control custom-select" id="modM-Type-select">
                                <option value="<?php echo $type; ?>"><?php echo $typeString; ?></option>
                                <?php

if (0 != $type) {
 echo '<option value="0">Egyéb típusú mez</option>';
}
if (1 != $type) {
 echo '<option value="1">Hazai mez</option>';
}
if (2 != $type) {
 echo '<option value="2">Vendég mez</option>';
}
if (3 != $type) {
 echo '<option value="3">Harmadik számú mez</option>';
}
if (4 != $type) {
 echo '<option value="4">Kapus mez</option>';
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
                    </div><!--endof type-->
                </div><!--endof left column-->

                <!-- right column -->
                <div class="col-xl-6 height280">
                    <!-- info -->
                    <div class="form-group row container">
                        <label class="col-lg-2 col-form-label" for="modM-Info">Info:</label>
                        <div class="col-lg-10">
                            <textarea rows="6" cols="25" class="form-control" name="modM-Info" id="modM-Info" maxlength="255"><?php if (isset($info)) {echo $info;} ?></textarea>
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
                                        <input type="button" class="btn btn-primary form-control" value="Vissza" id="resetMM">
                                    </div>
                                    <div class="col-lg-6">
                                        <input type="submit" name="submitMez" id="submitMezMod" value="Mez módosítása" class="btn btn-primary form-control">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div><!--endof submit, reset-->
                </div><!--endof right column-->
            </div><!--endof row-->
            <div id="errorVanMM" class="bg-danger p-1 text-light"></div>
            <div id="successVanMM" class="bg-success p-1 text-light"></div>
        </form>
    </div><!--endof container-fluid-->
</div> <!--endof min-height550-->




