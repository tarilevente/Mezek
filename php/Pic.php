<?php
//Class for Pics
class Pic
{
 private $__idPic;
 private $__p1;
 private $__Path1;
 private $__p2;
 private $__Path2;
 private $__weared;
 private $__PathWeared;

 public function __construct($idPic, $p1, $Path1, $p2, $Path2, $weared, $PathWeared)
 {
  $this->idPic      = $idPic;
  $this->p1         = $p1;
  $this->Path1      = $Path1;
  $this->p2         = $p2;
  $this->Path2      = $Path2;
  $this->weared     = $weared;
  $this->PathWeared = $PathWeared;
 }

 // SETTERS AND GETTERS
 public function setIdpic($idPic)
 {
  $this->idPic = $idPic;
 }
 public function getIdpic()
 {
  return $this->idPic;
 }

 public function setP1($p1)
 {
  $this->p1 = $p1;
 }
 public function getP1()
 {
  return $this->p1;
 }

 public function setP2($p2)
 {
  $this->p2 = $p2;
 }
 public function getP2()
 {
  return $this->p2;
 }

 public function setPath1($x)
 {
  $this->Path1 = $x;
 }
 public function getPath1()
 {
  return $this->Path1;
 }

 public function setPath2($x)
 {
  $this->Path1 = $x;
 }
 public function getPath2()
 {
  return $this->Path2;
 }

 public function setWeared($x)
 {
  $this->$weared = $x;
 }
 public function getWeared()
 {
  return $this->weared;
 }

 public function setPathweared($x)
 {
  $this->PathWeared = $x;
 }
 public function getPathweared()
 {
  return $this->PathWeared;
 }
}
