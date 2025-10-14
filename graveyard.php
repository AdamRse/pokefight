<?php
require "config/init.php";
require "./partials/head-config.php";
require "./partials/header.php";

$HeroManager = new HeroesManager($connexion);
$ruleset = new RulesetManager($connexion);
$respawnMax = $ruleset->getRespawnMax();
if(empty($_GET['respawn'])){//On affiche les héros morts
    $listeHeros = $HeroManager->recupererListerHerosCimetierre();
    ?>
    <audio src="./audio/PokemonLavender Town.mp3" autoplay class="hidden"></audio>
    <div class="justify-center items-center w-screen min-h-screen bg-cover" style="background-image:url(./images/graveyard.jpg);">
        <h1 class="font-3xl font-bold text-center">Graveyard</h1>
        <div class="flex flex-wrap">
        <?php
        foreach($listeHeros as $hero1){
            ?>
            <div class="relative inline-block ">
                <img class="imgAvatarSmall1 rounded-full" src="<?= URL_AVATARS_H.$hero1->getSprite(); ?>">
                <div class="tombtext w-1/2 text-center">
                    <div class="font-bold text-xl mb-2"><?= $hero1->getNom() ?></div>
                    Mort <?= $hero1->getRespawn()+1 ?> fois
                    <button type="button" class="text-white bg-gradient-to-r from-green-500 via-green-600 to-green-700 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-green-300 dark:focus:ring-green-800 shadow-lg shadow-green-500/50 dark:shadow-lg dark:shadow-green-800/80 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2">
                        <?php
                                if($hero1->getRespawn()<$respawnMax){
                                    ?>
                                    <a href="./graveyard.php?respawn=<?= $hero1->getId() ?>">Ramener à la vie (<?= $respawnMax-$hero1->getRespawn() ?> restant)</a>
                                    <?php
                                }
                                else{
                                    ?>
                                    <span class="font-lg font-bold text-center text-red-900">Mort définitive</span>
                                    <?php
                                }
                                ?>
                            </button>   
                        </div>
                        <img src="./images/Tomb.png" alt="" class="tomb">
                </div>
            </div>

            
            <?php
        }
        ?>
        <img src="./images/Haunter.png" class="haunter" alt="" width="300px">
    </div>
    <?php
}
else{//On a demmandé un respawn
    $hero = $HeroManager->respawn($_GET['respawn'], $respawnMax);
    if($hero->getHp() > 0){
        header('Location: ./hub.php');
    }
    else{
        ?>
        <div class="text-center flex justify-center items-center"><?= $hero->getNom() ?> tente de tricher :s</div>
        <?php
    }
}
require "./partials/footer.php";