<?php
//class for Mez
class Mez
{
 private $__idMez;
 private $__idPic;
 private $__idTeam;
 private $__type;
 private $__uploadUser;
 private $__uploadDate;
 private $__years;
 private $__info;

 //CONSTRUCTORS

 public function __construct($idMez, $idPic, $idTeam, $type, $uploadUser, $uploadDate, $years, $info)
 {
  $this->idMez      = $idMez;
  $this->idPic      = $idPic;
  $this->idTeam     = $idTeam;
  $this->type       = $type;
  $this->uploadUser = $uploadUser;
  $this->uploadDate = $uploadDate;
  $this->years      = $years;
  $this->info       = $info;
 }

 // SETTERS AND GETTERS
 public function setIdmez($idMez)
 {
  $this->idMez = $idMez;
 }
 public function getIdmez()
 {
  return $this->idMez;
 }

 public function setIdpic($idPic)
 {
  $this->idPic = $idPic;
 }
 public function getIdpic()
 {
  return $this->idPic;
 }
 public function setIdteam($idTeam)
 {
  $this->idTeam = $idTeam;
 }
 public function getIdteam()
 {
  return $this->idTeam;
 }

 public function setType($type)
 {
  $this->type = $type;
 }
 public function getType()
 {
  return $this->type;
 }
 public function setUploaduser($uu)
 {
  $this->uploadUser = $uu;
 }
 public function getUploaduser()
 {
  return $this->uploadUser;
 }

 public function setUploaddate($ud)
 {
  $this->uploadDate = $ud;
 }
 public function getUploaddate()
 {
  return $this->uploadDate;
 }
 public function setYears($y)
 {
  $this->years = $y;
 }
 public function getYears()
 {
  return $this->years;
 }
 public function setInfo($info)
 {
  $this->info = $info;
 }
 public function getInfo()
 {
  return $this->info;
 }

}
