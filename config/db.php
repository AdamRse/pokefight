<?php

try {
    $db_addr=env('DB_ADDR');
    $db_name=env('DB_NAME');
    $db_user=env('DB_USER');
    $db_pwd=env('DB_PASSWORD');
    $db_port=env('DB_PORT');

    $connexion = new PDO('mysql:host='.$db_addr.":$db_port;dbname=$db_name", $db_user, $db_pwd, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ]);
}
catch (\PDOException $e) {
    // Afficher le message d'erreur détaillé
    die('<h2>Erreur de connexion à la base de données</h2>' . $e->getMessage());
}
catch (\Throwable $th) {
    die('<h2>Erreur générale</h2>' . $th->getMessage());
}