<?php
require "config/init.php";
require "./partials/head-config.php";
require "./partials/header.php";

if (HERO) {
    $HeroManager = new HeroesManager($connexion);
    $hero = $HeroManager->findId(HERO);

    $ruleset = new RulesetManager($connexion);
    $lvlMax = $ruleset->getLvlMax();
    $respawnMax = $ruleset->getRespawnMax();

    if(isset($_GET['heal'])){
        $hero->setHp($hero->getMaxHp());
        $HeroManager->save($hero);
    }
    ?>

    <div class="justify-center items-center h-screen bg-no-repeat bg-cover z-10" style="background-image:url(./images/Pokemon_Center_Interior.png);">

    <div class="inline-block text-white textdialog text-xl p-3 border-4 border-white">
        <h2>Welcome to our Pokémon Center! <br>
            <?php
            if($hero->getHp() >= $hero->getMaxHp()){
                ?>
                You are fully restored !
                <audio src="./audio/pokemon-recovery.mp3" autoplay class="hidden"></audio>
                <?php
            }
            else{
                ?>
                We heal your Pokémon back to perfect health! <br>
                Shall we heal your Pokémon?</h2>

                <a href="./pokemoncenter.php?heal"><img src="./images/yes.png" alt="" width="60px" class="yestext"></a>
                <a href="./hub.php"><img src="./images/no.png" alt="" width="50px" class="notext"></a>
                <?php
            }
            ?>
    </div>

    <div class="cardpokemon items-center w-1/4 m-2 p-3 rounded overflow-hidden shadow-lg flex align-center text-white">
            <img class="imgAvatar rounded-full border border-solid border-black bg-white" src="<?= URL_AVATARS_H.$hero->getSprite(); ?>">
            <div class="px-6 py-4">
                <div class="font-bold text-lg">Level <?= $hero->getLvl() ?></div>
                <div class="font-bold text-xl"><?= $hero->getNom() ?></div>
                <?= $hero->hpBar() ?> 

                <div class="font-bold text-lg">Power : <?= $hero->getAtk() ?></div>
                <div class="font-bold text-lg">Armor : <?= $hero->getArmor() ?></div>
            </div>        
            <div class="buttonheal">
                <img src="./images/pokeball.png" alt="" class="w-24">
            </div>
        </div>
    </div>        
    <?php
}
else
    header("location:./index.php");
require "./partials/footer.php";