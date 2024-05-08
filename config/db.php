<?php

try {
    $connexion = new PDO("mysql:host=5.39.77.77;dbname=tp-combat-poo", 'tp_combat', 'V3IIC[s/YCZauem!', [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ]);
} catch (\Throwable $th) {
    die('erreur db');
}