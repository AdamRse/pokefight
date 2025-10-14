<?php
require "config/init.php";
require "./partials/head-config.php";
require "./partials/header.php";

if(HERO){
    $bosses = array(
        [
            "nom" => "Articuno"
            , "infos" => "Boss Articuno"
            , "atk" => 160
            , "hp" => 230
            , "maxHp" => 230
            , "armor" => 100
            , "sprite" => "boss1.png"
            , "lvl" => 10
            , "boss" => true
        ]
        ,[
            "nom" => "Moltres"
            , "infos" => "Boss Moltres"
            , "atk" => 185
            , "hp" => 290
            , "maxHp" => 290
            , "armor" => 200
            , "sprite" => "boss2.png"
            , "lvl" => 15
            , "boss" => true
        ]
        ,[
            "nom" => "Zapdos"
            , "infos" => "Boss Zapdos"
            , "atk" => 200
            , "hp" => 300
            , "maxHp" => 300
            , "armor" => 220
            , "sprite" => "boss3.png"
            , "lvl" => 20
            , "boss" => true
        ]
        ,[
            "nom" => "Mewtwo"
            , "infos" => "Final Boss Mewtwo !"
            , "atk" => 250
            , "hp" => 450
            , "maxHp" => 450
            , "armor" => 350
            , "sprite" => "mewtwo.png"
            , "lvl" => 22
            , "boss" => true
        ]
    );

    $HeroManager = new HeroesManager($connexion);
    $hero = $HeroManager->findId(HERO);

    if($hero->getHp() > 0){
        if($hero->getBoss() < sizeof($bosses)){
            $monsterManager = new MonsterManager($connexion);

            $ruleset = new RulesetManager($connexion);
            $respawnMax = $ruleset->getRespawnMax();

            $FightsManager = new FightsManager($HeroManager, $monsterManager);
            
            $monster = new Monster($bosses[$hero->getBoss()]);
            $logs = $FightsManager->fight($hero , $monster); 
            ?>
            <div class="justify-center items-center h-screen bg-no-repeat bg-cover" style="background-image:url(./images/galaxy-1920x1080.jpg);">
                <div class="flex justify-center">
                    <div id="displayLogsMatch" class="screentext basis-50 p-5 mb-200 bg-black text-white border border-gray-200 rounded-lg
                    shadow dark:bg-gray-800 dark:border-gray-700 z-50">
                    <?php
                        foreach ($logs as $log1) {
                            ?>
                            <p class="mb-2"><?= $log1 ?></p>
                            <?php
                        }
                        ?>
                    </div>
                </div>
                
                <div class="flex flex-wrap justify-evenly">
                    
                    <!-- Héros -->
                    <div class="herocard1 block max-w-sm p-6">
                        <div class="herocard mx-50 text-center bg-black font-bold text-3xl mb-2 text-white">
                            <?= "(".$hero->getLvl().") ".$hero->getNom() ?>
                            <div class="font-bold text-lg"><i class="fa-solid fa-heart fa-beat" style="color: #ed333b;"></i> Lives : <?= 1+$respawnMax-$hero->getRespawn() ?> </div>
                        </div>
                        <div class="text-white"><?php $hero->hpBar() ?></div>
                        <img class="inline-block align-bottom w-1/2 rounded-full ml-20" src="<?= URL_AVATARS_H.$hero->getSprite(); ?>">
                    </div>

                    <!-- Monstre -->
                    <div class="monstercard1 block max-w-sm p-5">
                        <div class="text-center bg-black font-bold text-3xl mb-1 text-white">
                            <?= "(".$monster->getLvl().") ".$monster->getNom() ?>
                        </div>
                        <div class="text-white"><?php $monster->hpBar() ?></div>
                        <img class="h-64 mb-50" src="<?= URL_AVATARS_M.$monster->getSprite(); ?>">
                    </div>
                </div>
            </div>
            <?php
        }
        else{
            ?>
            <div class="text-9x lm-5 text-center text-green-200 m-5">
                <img src="./images/yourethestronger.png" alt="">
                <div class="flex justify-center">
            <div class="relative inline-block">
                <img src="./images/poketrophy.jpeg" alt="" class="photomap m-5">
            </div>
            </div>
            <?php
        }
    }
    else
    header("location:./pokemoncenter.php");
}
else
    header("location:./index.php");
require "./partials/footer.php";