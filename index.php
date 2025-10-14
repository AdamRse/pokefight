<?php
require "config/init.php";
require "./partials/head-config.php";
require "./partials/header.php";

if(empty($_POST["name"]) && !isset($_GET["afficher"])){
?>

  <div class="grid place-items-center h-screen">
    <div class="max-w-lg mx-auto">
      <img src="./images/4pokemon_PNG98.png" class="w-200" alt="" srcset="">
      <img src="./images/International_Pokémon_logo.svg.png" alt="" srcset="">
      <img src="./images/pokemonstarters.png" alt="" srcset="">
      <form class="max-w-sm mx-auto" method="post">
        <div class="text-center">
          <input type="text" placeholder="Player Name" name="name" id="small-input" class="block w-full p-2 text-gray-900 border border-gray-300 rounded-lg bg-gray-50 sm:text-xs focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
          <button type="submit" class="px-4 py-2 font-medium text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Create pokemon</button>
        </div>
      </form>
    </div>
  </div>

  <?php
}
else {
  $heroManager = new HeroesManager($connexion);
  $ruleset = new RulesetManager($connexion);
  $respawnMax = $ruleset->getRespawnMax();//Pour calculer le nombre de vie

  if (!empty($_POST["name"]) && (!$hero = $heroManager->findNom($_POST["name"]))){
    $hero = new Hero();
    $hero->setNom(noTags($_POST["name"]));
    $hero->setSprite(fetchAvatarsHero(true));
    $heroManager->add($hero);
  }

?>
  <h1 class="text-center text-3xl my-5">Choisissez votre pokemon</h1>
  <div class="flex flex-wrap justify-center">
    <?php
  foreach ($heroManager->findAllAlive() as $hero1) {
  ?>
    <div class="<?= (empty($hero) && HERO && $hero1->getId() == HERO) ? "bg-green-100 " : "" ?>items-center w-1/4 m-2 p-3 rounded overflow-hidden shadow-lg flex align-center">
      <img class="imgAvatar rounded-full border border-solid border-black" src="<?= URL_AVATARS_H.$hero1->getSprite(); ?>">
      <div class="px-6 py-4">
        <div class="font-bold text-lg">Level <?= $hero1->getLvl() ?></div>
        <div class="font-bold text-xl"><?= $hero1->getNom() ?></div>
        <?php $hero1->hpBar() ?>
        <div class="font-bold text-lg pt-2" style="color: #9b6806;"><i class="fa-solid fa-hand-fist fa-xl pr-2"></i>  <?= $hero1->getAtk() ?></div>
        <div class="font-bold text-lg pt-2" style="color: #2b2a2a;"><i class="fa-solid fa-shield-halved fa-xl pr-2"></i>  <?= $hero1->getArmor() ?></div>
        <div class="font-bold text-lg pt-2"><i class="fa-solid fa-heart fa-beat fa-xl pr-2" style="color: #ed333b;"></i>  <?= 1+$respawnMax-$hero1->getRespawn() ?></div>
        <button type="button" data-id="<?= $hero1->getId() ?>" class="btSelectHero text-white bg-gradient-to-r from-purple-500 via-purple-600 to-purple-700 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-purple-300 dark:focus:ring-purple-800
          shadow-lg shadow-purple-500/50 dark:shadow-lg dark:shadow-purple-800/80 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2">
          <?php
            if(HERO != $hero1->getId()){
                ?>
                <a href="./process/process_select_hero.php?hero_id=<?= $hero1->getId() ?>">Sélectionner</a>
                <?php
            }
          ?>
        </button>
      </div>
    </div>
<?php
  }
  ?>
  </div>

  <?php
}
require "./partials/footer.php";
