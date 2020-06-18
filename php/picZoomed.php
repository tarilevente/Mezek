<?php
//this php controls modal function.
session_start();

require_once '../config/connect.php'; //database connect
require_once '../config/functions.php'; //using methods
require_once '../php/Mez.php'; //using Mez Class
require_once '../php/Pic.php'; //using Pic Class

if (isset($_POST['picId']) && !empty($_POST['picId'])) {
 $picId = $_POST['picId'];

 $sql = 'SELECT * FROM MezTable WHERE idPic=' . $picId;
 $res = $con->query($sql);
 if ($res && 1 == $res->num_rows) {
  $aktMez = null;
  while ($row = mysqli_fetch_assoc($res)) {
   $aktMez = GetMezFromRow($con, $row);
  }

  //find the name of the team
  $sql2 = "SELECT tName FROM TeamTable WHERE idTeam= " . $aktMez->getIdTeam();
  $res2 = $con->query($sql2);
  if ($res2 && 1 == $res2->num_rows) {
   $teamName = "";
   while ($u = $res2->fetch_row()) {
    $teamName = $u[0];
   }
   ;

   //find the pics of the MEZ
   $sql3 = 'SELECT * FROM PicsTable WHERE idPic=' . $aktMez->getIdpic();
   $res3 = mysqli_query($con, $sql3);
   if ($res3 && 1 == $res3->num_rows) {
    $aktPic = null;
    while ($row3 = mysqli_fetch_assoc($res3)) {
     $aktPic = GetPicFromRow($con, $row3);
    }

    $pic1 = $aktPic->getPath1() . $aktPic->getP1();
    $pic2 = null;
    if ($aktPic->getP2() == "basicMez.jpg") {
     //the name of the pic is "basicMez.jpg"
     $pic2 = null;
    } else {
     $pic2 = $aktPic->getPath2() . $aktPic->getP2();
    }
    $picWeared = null;
    if ($aktPic->getWeared() == null) {
     //pic exists
     $picWeared = null;
    } else {
     $picWeared = $aktPic->getPathWeared() . $aktPic->getWeared();
    }
    $html = '
  <!-- Modal Header -->
  <div class="modal-header">
    <div class="container modal-title">
            <div class="clearfix">
                <h4 class="float-left">' . $teamName . '</h4>
                <button type="button" class="close float-right" data-dismiss="modal">&times;</button>
            </div>
    </div>
  </div>' //endof modalHeader
     . '<!-- Modal body -->
     <div class="container">
        <div class="row min-height500 p-2">
            <div class="col-sm-2 multimedia-gallery-wrapper" >
                <div class="m-1">
                    <img src="' . $pic1 . '" alt="mez_1" >
                </div>';
    if (null !== $pic2) {
     $html .= '<div class="m-1">
                    <img src="' . $pic2 . '" alt="mez_2" >
                </div>';
    }
    if (null !== $picWeared) {
     $html .= '<div class="m-1">
                    <img src="' . $picWeared . '" alt="mez_weared" >
                </div>';
    }
    $html .= '
            </div>
            <div class="col-sm-10 image-gallery-wrapper text-center max-height500 min-height500 p-2" >
                <div class="image-display">

                <!-- Carousel -->
                <div id="carouselZoom" class="carousel slide carousel-fade" data-ride="carousel">

                    <!-- Indicators -->
                <ul class="carousel-indicators">
                    <li data-target="#carouselZoom" data-slide-to="0" class="active"></li>';
    if (null !== $pic2) {
     $html .= '<li data-target="#carouselZoom" data-slide-to="1"></li>';
    }
    if (null !== $picWeared) {
     $html .= '<li data-target="#carouselZoom" data-slide-to="2"></li>';
    }
    $html .= '
                </ul>

                    <!-- The slideshow -->
                    <div class="carousel-inner">
                        <div class="carousel-item active">
                                <img src="' . $pic1 . '" alt="mez_1">
                        </div>';
    if (null !== $pic2) {
     $html .= '
                        <div class="carousel-item">
                                <img src="' . $pic2 . '" alt="mez_2">
                        </div>';
    }
    if (null !== $picWeared) {
     $html .= '
                        <div class="carousel-item">
                                <img src="' . $picWeared . '" alt="mez_weared">
                        </div>';
    }
    $html .= '  </div>'; //endof slideShow
    if ($pic2 || $picWeared) {
     $html .= '  <!-- Left and right controls -->
                    <a class="carousel-control-prev" href="#carouselZoom" data-slide="prev">
                        <span class="carousel-control-prev-icon bg-info p-3"></span>
                    </a>
                    <a class="carousel-control-next" href="#carouselZoom" data-slide="next">
                        <span class="carousel-control-next-icon bg-info p-3"></span>
                    </a>';
    }
    $html .= '</div>' //endof Carousel
     . '     </div>' //endof Image-display
     . '   </div>' //endof Image-GalleryWrapper
     . '   <div class="container">' //Info Starts here
     . '        <div class="d-flex justify-content-around toColumn1000">
                    <div class="p-2 text-muted "><strong class="text-info">Típus:</strong> ' . $aktMez->getType() . '</div>
                    <div class="p-2 text-muted "><strong class="text-info">Év:</strong> ' . $aktMez->getYears() . '</div>
                    <div class="p-2 text-muted "><strong class="text-info">Feltöltötte:</strong> ' . $aktMez->getUploaduser() . ', ' . $aktMez->getUploaddate() . '</div>
                    <div class="p-2 text-muted "><strong class="text-info">Info:</strong> ' . $aktMez->getInfo() . ' </div>
                </div>'
    . '    </div>' //endof Info

    . '   </div>' //endof Row
     . ' </div>' //endof container

    . '</div>' . //endof ModalBody
     '
  <!-- Modal footer -->
  <div class="modal-footer">
    <div class="float-right">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">&nbspBezár&nbsp</button>
    </div>
  </div>
  ';

    echo $html;

   } else {
    //Missing $res3 -> NO Team FOUND
    http_response_code(307);
    echo printModalError("Csapat nem található! " . $aktMez->getTeam(), "87423");
   }
  } else {
//Missing $res2 -> NO PIC FOUND
   http_response_code(306);
   echo printModalError("Kép nem található! " . $aktPic->getidPic(), "87422");
  }
 } else {
  //Missing $res -> NO MEZ FOUND
  http_response_code(305);
  echo printModalError("Mez nem található! " . $res->num_rows, "87421");
 }
} else {
 //$_post['picId'] is Missing
 http_response_code(305);
 echo printModalError('Ismeretlen hiba! ' . $picId, "87420");
}
