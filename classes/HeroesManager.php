<?php
class HeroesManager{
    
    protected $_bdd;

    public function __construct(PDO $connexion){
        $this->_bdd = $connexion;
    }
    public function add(Hero $hero){
        $q = $this->_bdd->prepare("INSERT IGNORE INTO hero(nom, atk, hp, armor, sprite) VALUES (?, ?, ?, ?, ?)");
        $q->execute([$hero->getNom(), $hero->getAtk(), $hero->getHp(), $hero->getArmor(), $hero->getSprite()]);
        $hero->setId($this->_bdd->lastInsertId());
    }
    public function save(Hero $hero){
        $q = $this->_bdd->prepare("UPDATE hero SET nom = :nom, atk = :atk, hp = :hp, maxHp = :maxHp, armor = :armor, lvl = :lvl, respawn = :respawn, boss = :boss WHERE id = :id");
        return $q->execute([
            "id" => $hero->getId()
            , "nom" => $hero->getNom()
            , "atk" => $hero->getAtk()
            , "hp" => $hero->getHp()
            , "maxHp" => $hero->getMaxHp()
            , "armor" => $hero->getArmor()
            , "lvl" => $hero->getLvl()
            , "respawn" => $hero->getRespawn()
            , "boss" => $hero->getBoss()
        ]);
    }
    public function findNom($nom){
        $q = $this->_bdd->prepare("SELECT * FROM hero WHERE nom = ?");
        $q->execute([$nom]);
        $hero = $q->fetch(PDO::FETCH_ASSOC);
        return empty($hero) ? false : new Hero($hero);
    }
    public function findId($id){
        $q = $this->_bdd->prepare("SELECT * FROM hero WHERE id = ?");
        $q->execute([$id]);
        $hero = $q->fetch(PDO::FETCH_ASSOC);
        return empty($hero) ? false : new Hero($hero);
    }
    public function recupererListerHerosCimetierre(){
        $listHeroes = [];
        $q = $this->_bdd->query("SELECT * FROM hero WHERE hp <= 0");
        while($lineHero = $q->fetch(PDO::FETCH_ASSOC)){
            $listHeroes[] = new Hero($lineHero);
        }
        return $listHeroes;
    }
    public function respawn($id, $maxRespawn){
        $hero = $this->findId($id);
        if($hero->getHp() <= 0 && $hero->getRespawn() < $maxRespawn){
            $hero->respawnPenalties();
            $this->save($hero);
        }
        return $hero;
    }
    public function isHero(){
        
    }
    public function findAllAlive(){
        $q = $this->_bdd->query("SELECT * FROM hero WHERE hp > 0");
        $tabHeroAlive = [];
        while($heroAlive = $q->fetch(PDO::FETCH_ASSOC)){
            $tabHeroAlive[]= new Hero($heroAlive);
        }
        return $tabHeroAlive;
    }
}
