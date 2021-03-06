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
 $html = '<div class="card shadow bg-light m-1" style="max-width:270px; min-width:270px;">'
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
 $tipus  = getTypeString($row['Type']);
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

//returns true if a file exists in a spec. folder
function fileAlreadyExists($location)
{
 if (file_exists($location)) {
  return true;
 } else {
  return false;
 }
}

//print select category options
function printCatSelectOptions($con, $post, $id)
{
 $html = '<select class="form-control custom-select" id="' . $id . '" required>';
 $sql  = 'SELECT CategoryTable.idCategory, CatName FROM CategoryTable WHERE idLeague=' . $post . ' ORDER BY CatName';
 $res  = $con->query($sql);
 if (!$res) {
  $html .= '<option selected value="-1">Nincs még kategória! </option>';
 } else {

  if (0 == $res->num_rows) {
   $html .= '<option selected value="-1">Nincs még kategória! </option>';
  } elseif (1 == $res->num_rows) {
   while ($row = mysqli_fetch_row($res)) {
    $html .= '<option selected value="' . $row[0] . '">' . $row[1] . '</option>';
   }
  } else {
   $html .= '<option selected value="-1">Válassz!</option>';
   while ($row = mysqli_fetch_row($res)) {
    $html .= '<option value="' . $row[0] . '">' . $row[1] . '</option>';
   }

   $html .= '</select>
      <div class="valid-feedback">
      Rendben!
      </div>
      <div class="invalid-feedback">
      Válassz!
      </div>';
  }
 }
 return $html;
}

//print select team options
function printTeamSelectOptions($con, $post, $id)
{
 $html = "";
 $html .= '<select class="form-control custom-select" id="' . $id . '" required>';
 $sql = 'SELECT TeamTable.idTeam, TeamTable.tName FROM TeamTable WHERE idCategory=' . $post . ' ORDER BY tName';
 $res = $con->query($sql);
 if (0 == $res->num_rows) {
  $html .= '<option selected value="-1">Nincs még csapat!</option>';
 } else {
  if (1 == $res->num_rows) {
   while ($row = mysqli_fetch_row($res)) {
    $html .= '<option value=' . $row[0] . '>' . $row[1] . '</option>';
   }
  } else {
   $html .= '<option selected value="-1">Válassz</option>';
   while ($row = mysqli_fetch_row($res)) {
    $html .= '<option value=' . $row[0] . '>' . $row[1] . '</option>';
   }
  }
  $html .= '
        </select>
        <div class="valid-feedback">
            Rendben!
        </div>
        <div class="invalid-feedback">
            Válassz!
        </div>';
 }
 return $html;
}

function getTypeString($type)
{
 $typeString = '';
 switch ($type) {
  case '0':
   $typeString = 'Egyéb típusú mez';
   break;
  case '1':
   $typeString = 'Hazai mez';
   break;
  case '2':
   $typeString = 'Vendég mez';
   break;
  case '3':
   $typeString = 'Harmadik számú mez';
   break;
  case '4':
   $typeString = 'Kapus mez';
   break;

  default:
   $typeString = '?';
   break;
 } //endof $type String
 return $typeString;
}
