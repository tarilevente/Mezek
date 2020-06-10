<?php
$con=new mysqli('localhost', 'root', '', 'mezekdb', '3306');
if($con ->errno){
    die('<h1>Az adatbázishoz nem sikerült csatlakozni. </h1>');
}

if(!$con -> set_charset("utf8")){
    echo '<h2>Nem sikerült beállítani a karakterkódolást. </h2>';
}