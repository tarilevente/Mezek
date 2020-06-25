<?php
require 'connect.php';

function dd($var)
{
 var_dump($var);
 die();
}

function IsLogged()
{
 if (isset($_SESSION['user']) && (!empty($_SESSION['user']))) {
  //Someone is logged in
  return true;
 } else {
  return false;
 }
}

function PrintMenu()
{
 if (IsLogged()) {
  return file_get_contents("html/menu_in.html");
 } else {
  return file_get_contents("html/menu_out.html");
 }
}

function GeneratePicCard(
 $teamName,
 $aktYears,
 $tipus,
 $aktPicPath1,
 $aktPicP1,
 $aktInfo,
 $aktPicID
) {
 $html = '<div class="card bg-light m-1" style="max-width:270px; min-width:270px;">'
 . '<div class="card-header csapat">
        <div>' . $teamName . '</div>
      </div>'
 . '<div class="card-body">'
 . '<div class="row">'
 . '<div class="text-left col-5 card-title">
            <p>
                <strong>Év:</strong>&nbsp' . $aktYears . '
            </p>
      </div>'
 . '<div class="text-right col-7 card-title">
            <p>
                <strong>Típus:</strong>&nbsp' . $tipus . '
            </p>
      </div>'
 . '</div>' //endof row
  . '<img class="card-img-top" src="' . $aktPicPath1 . '' . $aktPicP1 . '" alt="Mez_KÉP" style="max-width:265px">'
 . '</div>' //endof card-body
  . '<div class="card-footer text-center no-padding toHover picToShow" data-picid="' . $aktPicID . '">'
 . '   <button type="button" class="btn" data-toggle="modal" data-target="#myModal">
                <div>Megnézem</div>
         </button>' //<span class="fa fa-search-plus"></span> kihagytam végül
  . '</div>' //endof footer
  . '</div>'; //endof card
 return $html;
}

function PrintModal()
{
 $html = ' <!-- The Modal -->
  <div class="modal fade" id="myModal">
    <div class="modal-dialog modal-xl modal-dialog-centered">
      <div class="modal-content" id="modalContent">



      </div>
    </div>
  </div>
</div>';
 return $html;
}

function PrintModalError($errorString, $errorCode)
{
 $html = '<div class="modal-header">
          <h4 class="modal-title">' . $errorString . '</h4>
          <!-- "x" - button -->
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>

        <!-- Modal body -->
        <div class="modal-body" >

        Error code: ' . $errorCode . '
        </div>

        <!-- Modal footer -->
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Bezár</button>
        </div>';
 return $html;
}

function GetMezFromRow($con, $row)
{
 //generate aktMez
 $aktMez = null;
 $years  = "?";
 if (isset($row['Years'])) {
  $years = $row['Years'];
 }
 $info = "-";
 if (isset($row['Info'])) {
  $info = $row['Info'];
 }
 $time       = strtotime($row['UploadDate']);
 $uploadDate = date("yy.m.d. ", $time); //megcsinálni, hogy formailag jó legyen

 //Find the Upload user of the akt Mez
 $sql2   = "SELECT FirstName, LastName FROM UserTable WHERE idUser=" . $row['UploadUser'];
 $result = $con->query($sql2);
 $user   = "";
 while ($u = $result->fetch_array()) {
  $user = $u[1] . ' ' . $u[0];
 }
 ;
 if (!$user) {
  // http_response_code(404); //ezmi??
  // die('<h4 class="bg-danger text-light p-5 text-center">Hiba a megjelenítésnél! error code:  89660</h4>');
 }

//the type of the MEZ

 $tipus = "";
 switch ($row['Type']) {
  case '0':
   $tipus = "Egyéb";
   break;
  case '1':
   $tipus = "Hazai";
   break;
  case '2':
   $tipus = "Vendég";
   break;
  case '3':
   $tipus = "Third";
   break;
  case '4':
   $tipus = "Kapus";
   break;
  default:
   $tipus = "?";
   break;
 }
 $aktMez = new Mez($row['idMez'], $row['idPic'], $row['idTeam'], $tipus, $user, $uploadDate, $years, $info);
 return $aktMez;
}

function GetPicFromRow($con, $aktMez)
{
 $sql3   = "SELECT * FROM PicsTable WHERE idPic=" . $aktMez['idPic'];
 $resPic = $con->query($sql3);
 $aktPic = null;
 if ($resPic) {
  //There is a Pic for aktMez
  while ($u = $resPic->fetch_assoc()) {
   $p2 = "";
   if (isset($u['2'])) {
    $p2 = $u['2'];
   }
   $Path2 = "";
   if (isset($u['Path2'])) {
    $Path2 = $u['Path2'];
   }
   $weared = "";
   if (isset($u['weared'])) {
    $weared = $u['weared'];
   }
   $PathWeared = "";
   if (isset($u['PathWeared'])) {
    $PathWeared = $u['PathWeared'];
   }
   //Create the Pic object by datas
   $aktPic = new Pic(
    $u['idPic'],
    $u['1'],
    $u['Path1'],
    $p2,
    $Path2,
    $weared,
    $PathWeared
   );
  }
 } else {
  $aktPic = new Pic("9999", "basicMez.jpg", "../public/resources/pics/mezek/", "", "", "", "");
 }
 return $aktPic;
}

function testInput($data)
{
 $data = trim($data);
 $data = stripslashes($data);
 $data = htmlspecialchars($data);
 return $data;
}
//validation of email address
function emailIsValid($data)
{
 $email = testInput($data);
 if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
  return false;
 } else {
  return true;
 }
}

//regex for password
function pwdIsValidRegex($password)
{
 $uppercase = preg_match('@[A-Z]@', $password);
 $lowercase = preg_match('@[a-z]@', $password);
 $number    = preg_match('@[0-9]@', $password);

 if (!$uppercase || !$lowercase || !$number || strlen($password) < 8) {
  return false;
 } else {
  return true;
 }
}

//create a dir for pics (group by team) if not exists
function makeDir($path)
{
 return is_dir($path) || mkdir($path);
}
