<?php

class Mez {
    public $idMez;
    public $idPic;
    public $idTeam;
    public $type;
    public $uploadUser;
    public $uploadDate;
    public $years;
    public $info;
    
    //CONSTRUCTORS
    
     function __construct($idMez, $idPic, $idTeam, $type, $uploadUser, $uploadDate, $years, $info) {
    $this->idMez = $idMez;
    $this->idPic = $idPic;
    $this->idTeam = $idTeam;
    $this->type = $type;
    $this->uploadUser = $uploadUser;
    $this->uploadDate = $uploadDate;
    $this->years=$years;
    $this->info=$info;
  }
    
    // SETTERS AND GETTERS
    function set_idMez($idMez) {
    $this->idMez = $idMez;
  }
    function get_idMez() {
    return $this->idMez;
  }
  
      function set_idPic($idPic) {
    $this->idPic = $idPic;
  }
    function get_idPic() {
    return $this->idPic;
  }      
  function set_idTeam($idTeam) {
    $this->idTeam = $idTeam;
  }
    function get_idTeam() {
    return $this->idTeam;
  }
  
  function set_type($type) {
    $this->type = $type;
  }
    function get_type() {
    return $this->type;
  }
  function set_uploadUser($uu) {
    $this->uploadUser = $uu;
  }
    function get_uploadUser() {
    return $this->uploadUser;
  }
  
    function set_uploadDate($ud) {
    $this->uploadDate = $ud;
  }
    function get_uploadDate() {
    return $this->uploadDate;
  }
    function set_years($y) {
    $this->years = $y;
  }
    function get_years() {
    return $this->years;
  }
    function set_info($info) {
    $this->info = $info;
  }
    function get_info() {
    return $this->info;
  }
  
}
