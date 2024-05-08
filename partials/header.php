<?php

include './partials/head-config.php';
?>
<body class="bg-gradient-to-r from-gray-400 via-gray-600 to-blue-800 h-screen" onload="loader()">
<div id="divLoader" class="flex justify-center bg-black h-screen w-screen top-0 right-0 fixed z-50 overflow-hidden">
  <div class="flex items-center text-6xl text-white text-center">
    <div>
      <img src="./images/loader<?= 2 ?>.gif"/>
      <div class="mt-2">Loading</div>
    </div>
  </div>
</div>
<header>
    <!-- El super navbar del Jorge -->
    <nav class="bg-white border-gray-200 dark:bg-gray-900">
  <div class="max-w-screen-xl flex justify-between mx-auto">
    <a href="./index.php"><img src="../images/navbarpikachu.gif" class="h-12"/></a>
    <span class="self-center text-2xl font-semibold whitespace-nowrap dark:text-white"></span>
    <button data-collapse-toggle="navbar-default" type="button" class="inline-flex items-center p-2 w-10 h-10 justify-center text-sm text-gray-500 rounded-lg md:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600" aria-controls="navbar-default" aria-expanded="false">
    </button>
    <div class="hidden w-full md:block md:w-auto" id="navbar-default">
      <ul class="font-medium flex flex-end items-center pt-3">
        <?= DEVMOD ? "<li class='mx-2 bg-red-600'><a href='./devmod.php'>+DEVMOD+</a></li>" : "" ?>
        <li class="mx-3">
          <a href="./index.php?afficher" class="block py-2 px-3 text-white bg-blue-700 rounded md:bg-transparent md:text-blue-700 md:p-0 dark:text-white md:dark:text-blue-500" aria-current="page">
            <?= HERO ? "Change" : "Select a" ?> pokemon
          </a>
        </li>
        <li class="mx-3">
          <a href="./hub.php" class="block py-2 px-3 text-white bg-blue-700 rounded md:bg-transparent md:text-blue-700 md:p-0 dark:text-white md:dark:text-blue-500" aria-current="page">
            Pokémap
          </a>
        </li>
        <li class="mx-3">
            <a href="./?dc" class="text-red-500">Leave</a>
        </li>
      </ul>
    </div>
  </div>
</nav>
</header>