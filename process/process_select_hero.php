<?php
require $_SERVER['DOCUMENT_ROOT']."/config/init.php";

if(!empty($_GET['hero_id'])){
    //Connecter le héro en session
    $heroManager = new HeroesManager($connexion);
    if($hero = $heroManager->findId($_GET['hero_id'])){
        $_SESSION['hero']['id'] = $_GET['hero_id'];
        header("location:../hub.php"); exit();
    }
}
header("location:../index.php");
ob_end_flush();