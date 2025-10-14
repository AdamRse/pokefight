<?php
function my_autoloader($classe){
    require $_SERVER['DOCUMENT_ROOT']."/classes/$classe.php";
}
spl_autoload_register("my_autoloader");