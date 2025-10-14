<?php
require "config/init.php";
require "partials/head-config.php";
require "partials/header.php";
if(DEVMOD){
    ?>
    <h1 class="text-center text-red-900 font-bold text-5xl p-5">-- DEVMOD --</h1>
    <div class="flex justify-center">
        <?php
        if(HERO){
            $hm = new HeroesManager($connexion);
            $hero = $hm->findId(HERO);
            ?>
            <div class="items-center w-1/4 m-2 p-3 rounded overflow-hidden shadow-lg flex align-center">
                <img class="imgAvatar rounded-full border border-solid border-black" src="<?= URL_AVATARS_H.$hero->getSprite(); ?>">
                <div class="px-6 py-4">
                    <div class="font-bold text-lg">Level <?= $hero->getLvl() ?></div>
                    <div class="font-bold text-xl"><?= $hero->getNom() ?></div>
                    <?php $hero->hpBar() ?>
                    <div class="font-bold text-lg">Power : <?= $hero->getAtk() ?></div>
                    <div class="font-bold text-lg">Armor : <?= $hero->getArmor() ?></div>
                </div>
            </div>
            <?php
        }
        if(!empty($_GET)){
            $devmod = new DevmodManager($connexion);
            if(isset($_GET['full'])){
                if($devmod->respawn(HERO))
                    header("location:./hub.php");
            }
            if(isset($_GET['reset'])){
                if($devmod->reset(HERO))
                    header("location:./hub.php");
            }
            if(isset($_GET['generer'])){
                $devmod->generateMonsters(1);
            }
        }
        ?>
        <ul>
            <li class="m-3"><a class="p-3" href="./devmod.php?full">> Full HP</a></li class="m-3">
            <li class="m-3"><a class="p-3"  href="./devmod.php?reset">> Reset Pokemon</a></li>
            <li class="m-3"><a class="p-3"  href="./devmod.php?generer">> Generate monsters</a></li>
        </ul>
    </div>
    <?php
}
else
    header("location:./index.php");
require "partials/footer.php";