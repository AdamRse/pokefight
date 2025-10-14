<?php
session_start();

require "../config/fct.php";
require "../config/autoloader.php";
require "../config/db.php";
require "../config/const.php";

if(HERO){
    $ruleset = new RulesetManager($connexion);
    if(isset($_GET['at'])){
        $hm = new HeroesManager($connexion);
        $hero = $hm->findId(HERO);
        $lvlMax = $ruleset->getLvlMax();
        if($hero && $hero->getLvl() <= $lvlMax){
            $mm = new MonsterManager($connexion);
            $fightManager = new FightsManager($hm, $mm);

            if(isset($_SESSION['fight']['monster']['id'])){
                if(empty($_SESSION['fight']['round'])) $_SESSION['fight']['round'] = 0;
                $fightManager->setRound(++$_SESSION['fight']['round']);
                $monster = $mm->findId($_SESSION['fight']['monster']['id']);
                $monster->setHp($_SESSION['fight']['monster']['hp']);
                echo json_encode($fightManager->fightTurnBased($hero, $monster));
            }
            else{
                echo json_encode(array("status" => 10, "err" => "No Monster created"));
            }
        }  
        else
            echo json_encode(array("status" => 10, "err" => "Invalid hero"));
    }
    else{
        $hm = new HeroesManager($connexion);
        $hero = $hm->findId(HERO);
        $hero->setHp(0);
        $hero->setRespawn($ruleset->getRespawnMax());
        $hero->setNom("Tricheur :o");
        $hm->save($hero);
    }
}
else
    echo json_encode(array("status" => 10, "err" => "No selected pokemon"));