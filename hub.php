<?php
require "config/init.php";
require "./partials/head-config.php";
require "./partials/header.php";

if(HERO){
    $ruleset = new RulesetManager($connexion);
    $HeroManager = new HeroesManager($connexion);
    $hero = $HeroManager->findId(HERO);

    $lvlMax = $ruleset->getLvlMax();
    $respawnMax = $ruleset->getRespawnMax();

    ?>
<audio src="./PokemonLavender Town.mp3" id="my_audio2"></audio>
<!-- <div class="justify-center items-center h-screen bg-center bg-no-repeat z-10" style="background-image:url(./images/kanto.png);"> -->
    <div class="m-3 flex justify-center">
        <div class="w-1/4">
        <h1 class="text-xl text-center font-bold m-5">Welcome to the pokébattle central hub !</h1>
    <p class="p-1">
        You are level <b><?= $hero->getLvl() ?></b>, your goal is to get stronger in order to defeat the boss !
        <br/>
        You enhance your pokemon after each won fights, if you die, you can go to the <a href="./graveyard.php" class="text-red-400 font-bold">graveyard</a> and try to come back to life.
    </p>
            <div class="items-center w-full m-2 p-3 rounded overflow-hidden flex align-center">
                <img class="imgAvatar rounded-full border border-solid border-black" src="<?= URL_AVATARS_H.$hero->getSprite(); ?>">
                <div class="px-6 py-4">
                    <div class="font-bold text-lg">Level <?= $hero->getLvl() ?></div>
                    <div class="font-bold text-xl"><?= $hero->getNom() ?></div>
                    <?php $hero->hpBar() ?>
                    <div class="font-bold text-lg">Power : <?= $hero->getAtk() ?></div>
                    <div class="font-bold text-lg">Armor : <?= $hero->getArmor() ?></div>
                </div>
            </div>
        </div>
        <div class="flex justify-center">
            <div class="relative inline-block">
                <img src="./images/kanto.png" alt="" class="photomap">
                <div class="point1">
                <a href="./fightBoss.php"><img src="./images/Warning.png" class="w-32" alt=""></a>
                </div>
                <div class="point2">
                    <a href="./fight.php"><img src="./images/avatar/monstres/monstergeo.png" class="w-32" alt=""></a>
                </div>
                <div class="point3">
                    <a href="./pokemoncenter.php"><img src="./images/pokemoncenter.png" class="w-32" alt=""></a>
                </div>
                <div class="point4">
                    <a href="./graveyard.php"><img src="./images/RIP.png" class="w-20" alt=""></a>
                </div>
                <span class='start-btn fighthebosstext'>FIGHT THE BOSS</span>
                <span class='start-btn graveyardtext'>GRAVEYARD</span>
                <span class='start-btn pokemoncentertext'>POKEMON CENTER</span>
                <span class='start-btn battletrainingtext'>BATTLE TRAINING</span>
            </div>
        </div>
    </div>




    <?php
}
else
    header("location:./index.php");

require "./partials/footer.php";
