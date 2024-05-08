<?php
require "config/init.php";
require "./partials/head-config.php";
require "./partials/header.php";


if(HERO){
    $HeroManager = new HeroesManager($connexion);
    $hero = $HeroManager->findId(HERO);

    $ruleset = new RulesetManager($connexion);
    $lvlMax = DEVMOD ? 131072 : $ruleset->getLvlMax();
    $respawnMax = $ruleset->getRespawnMax();

    //Si le pokémon est niveau max, on l'envoie sur le boss
    if($hero->getLvl() >= $lvlMax)
        header('location:fightBoss.php');
    if($hero->getHp() <= 0)
        header('location:graveyard.php');

    $monsterManager = new MonsterManager($connexion);
    $FightsManager = new FightsManager($HeroManager, $monsterManager);

    $monster = $monsterManager->findOpponent($hero);
    $logs = $FightsManager->fight($hero, $monster, !DEVMOD);
    ?>

    <div class="justify-center items-center h-screen bg-no-repeat bg-cover" style="background-image:url(./images/pokemon-stadium.webp);">
        <div class="flex justify-center">
            <div id="displayLogsMatch" class="screentext basis-50 p-5 mb-200 bg-black text-white border border-gray-200 rounded-lg
            shadow dark:bg-gray-800 dark:border-gray-700 z-40">
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
        <div class ="buttonfight">
            <a href="./fight.php" class="" id="button"><span class='video-game-button'><i class="fa-solid fa-play fa-xl"></i></span></a>
            <span class='start-btn'>PLAY AGAIN</span>  
            <button class="" id="buttonattack"><img src="./images/buttonattack.png" alt="" width="100px"></button>  
        </div>
    </div>

    <?php
}
require "./partials/footer.php";
