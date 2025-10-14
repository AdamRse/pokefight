<?php
define("URL_AVATARS_H","./images/avatar/");
define("URL_AVATARS_M","./images/avatar/monstres/");
define("HERO", empty($_SESSION['hero']['id']) ? false : $_SESSION['hero']['id']);
define("PAGE_NO_EXT", pageNameNoExt());
define("DEVMOD", empty($_SESSION['devmod']) ? false : true);