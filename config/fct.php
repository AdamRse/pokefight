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
function get_from_env_file($key){
    $file_env=".env";
    if(file_exists($file_env)){
        $lines = file($file_env, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        foreach ($lines as $line){
            $line = trim($line);
            if(empty($line))
                continue;
            $parts = explode('=', $line, 2);
            if($parts[0] == $key){
                if(!isset($parts[1]))
                    return false;
                return ["payload" => $parts[1] ];
            }
        }
    }
    return false;
}
function env($key){
    if(isset($_SESSION['env'][$key])){
        return $_SESSION['env'][$key];
    }
    elseif($value = get_from_env_file($key)){
        $_SESSION['env'][$key]=$value['payload'];
        return $value['payload'];
    }
    else{
        die("Erreur : la clé '$key' demmandée n'existe pas dans le .env");
    }
}