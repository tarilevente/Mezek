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
    if (strpos("basicMez.jpg", $aktPic->getP1()) == 0) {
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
        <div class="row min-height500">
            <div class="col-sm-2 multimedia-gallery-wrapper" style="border:1px solid black">
                <div class="m-1">
                    <img src="' . $pic1 . '" alt="mez_1" style="width: 100%;">
                </div >';
    if (null !== $pic2) {
     $html .= '<div class="m-1">
                    <img src="' . $pic2 . '" alt="mez_1" style="width: 100%;">
                </div>';
    }
    if (null != $picWeared) {
     $html .= '<div class="m-1">
                    <img src="' . $picWeared . '" alt="mez_1" style="width: 100%;">
                </div>';
    }
    $html .= '
            </div>
            <div class="col-sm-10 image-gallery-wrapper" style="border:1px solid black">
                <div class="image-display"></div>
                <div class="image-display-controls"></div>
            </div>
        </div>
    </div>

  </div>' . //endof ModalBody
     '
  <!-- Modal footer -->
  <div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-dismiss="modal">Bezár</button>
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
