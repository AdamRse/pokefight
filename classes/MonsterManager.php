<?php
class MonsterManager{
    
    protected $_bdd;

    public function __construct(PDO $connexion){
        $this->_bdd = $connexion;
    }
    public function add(Monster $monster){
        $q = $this->_bdd->prepare("INSERT INTO monster(nom, infos, atk, hp, maxHp, armor, sprite, lvl, difficulty) VALUES (:nom, :infos, :atk, :hp, :maxHp, :armor, :sprite, :lvl, :diff)");
        $q->execute([
            "nom" => $monster->getNom()
            , "infos" => $monster->getInfos()
            , "atk" => $monster->getAtk()
            , "hp" => $monster->getHp()
            , "maxHp" => $monster->getMaxHp()
            , "armor" => $monster->getArmor()
            , "sprite" => $monster->getSprite()
            , "lvl" => $monster->getLvl()
            , "diff" => $monster->getDifficulty()
        ]);
        $monster->setId($this->_bdd->lastInsertId());
    }
    public function save(Monster $monster){
        $q = $this->_bdd->prepare("UPDATE monster SET hp = ? WHERE id = ?");
        return $q->execute([$monster->getHp(), $monster->getId()]);
    }
    public function findNom($nom){
        $q = $this->_bdd->prepare("SELECT * FROM monster WHERE nom = ?");
        $q->execute([$nom]);
        $monster = $q->fetch(PDO::FETCH_ASSOC);
        return empty($monster) ? false : new Monster($monster);
    }
    public function findId($id){
        $q = $this->_bdd->prepare("SELECT * FROM monster WHERE id = ?");
        $q->execute([$id]);
        $monster = $q->fetch(PDO::FETCH_ASSOC);
        return empty($monster) ? false : new Monster($monster);
    }
    public function findOpponent(Hero $hero, $rangeLvl = 0){
        $q = $this->_bdd->query("SELECT * FROM monster WHERE lvl >= ".($hero->getLvl()-$rangeLvl)." AND lvl <= ".($hero->getLvl()+$rangeLvl)." ORDER BY RAND() LIMIT 1");
        $monsterBdd = $q->fetch(PDO::FETCH_ASSOC);
        if(empty($monsterBdd))
            $monsterBdd=[
            "nom" => "MissingNo"
            , "infos" => "Oh, a bug type pokemon !"
            , "atk" => $hero->getAtk()+10
            , "hp" => fourchetteRandom($hero->getHp(), 5)
            , "maxHp" => 1//$hero->getMaxHp()
            , "armor" => fourchetteRandom($hero->getArmor(), 2)
            , "sprite" => "missingno.webp"
            , "lvl" => 0//$hero->getLvl()
            , "difficulty" => 2
            ];
        return new Monster($monsterBdd);
    }
    public function isMonster(){
        
    }
    public function findAllAlive(){
        $q = $this->_bdd->query("SELECT * FROM monster WHERE hp > 0");
        $tabMonsterAlive = [];
        while($monsterAlive = $q->fetch(PDO::FETCH_ASSOC)){
            $tabMonsterAlive[]= new Monster($monsterAlive);
        }
        return $tabMonsterAlive;
    }
}
