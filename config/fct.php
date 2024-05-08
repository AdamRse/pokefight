<?php
function fourchetteRandom($num, $fourchette){
    return $num + rand(0,$fourchette*2) - $fourchette;
}
function noTags($elem){
    $rt = false;
    if(is_string($elem))
        $rt = preg_replace("/<(^>)+>/", "", $elem);
    $rt = str_replace("<", "+", $rt);
    return htmlspecialchars(trim($rt));
}
function fetchAvatarsHero($rand = false){
    $avatars = [];
    $content = scandir(URL_AVATARS_H);
    foreach($content as $avatar)
        if($avatar != "." && $avatar != ".." && is_file(URL_AVATARS_H.$avatar) && $avatar != "pikachu.png" && $avatars != "bulbasaur.png")
            $avatars[] = $avatar;

    if($rand)
        $avatars = $avatars[rand(0, sizeof($avatars)-1)];

    return $avatars;
}
function fetchAvatarsMonstre($rand = false){
    $avatars = [];
    $content = scandir(URL_AVATARS_M);
    foreach($content as $avatar)
        if($avatar != "." && $avatar != ".." && is_file(URL_AVATARS_M.$avatar) && $avatar != "mewtwo.png")
            $avatars[] = $avatar;

    if($rand)
        $avatars = $avatars[rand(0, sizeof($avatars)-1)];

    return $avatars;
}
function pageNameNoExt(){
    $rt = false;
    $name = $_SERVER['PHP_SELF'];
    $exp=explode(".", strrev($name), 2);
    if(!empty($exp[1]))
        $rt = strrev(str_replace("/", "", $exp[1]));
    return $rt;
}