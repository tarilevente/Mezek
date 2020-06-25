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
      <form id="newM-form" class="needs-validation" novalidate>
            <!-- upload pics -->
            <div class="media border">
                <div class="media-body">
                        <div class="input-group mb-3 px-2 rounded-pill bg-white shadow-sm">
                            <input id="upload" type="file" onchange="readURL(this);" class="form-control border-0">
                            <label id="upload-label" for="upload" class="font-weight-light text-muted">Choose file</label>
                            <div class="input-group-append">
                                <label for="upload" class="btn btn-light m-0 rounded-pill px-4">
                                    <i class="fa fa-cloud-upload mr-2 text-muted"></i>
                                    <small class="text-uppercase font-weight-bold text-muted">Choose file</small>
                                </label>
                            </div>
                        </div>
                </div>
                <div class="image-area">
                    <img id="imageResult" src="#" alt="" class="img-fluid rounded mx-auto d-block align-self-center" style="max-height:150px">
                </div>
            </div>
      </form>
    </div>
</div> <!--endof min-height550-->



<?php
$con->close();
echo file_get_contents("html/footer.html");
