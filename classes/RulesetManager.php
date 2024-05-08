<?php
class RulesetManager{
    protected PDO $_bdd;

    public function __construct(PDO $connexion){
        $this->_bdd = $connexion;
    }

    public function getRuleset($id){
        $q = $this->_bdd->prepare("SELECT val FROM ruleset WHERE rule = ?");
        $q->execute(array($id));
        $tabRule = $q->fetch(PDO::FETCH_NUM);
        return isset($tabRule[0]) ? $tabRule[0] : false;
    }
    // public function getLvlMax(){
    //     $q = $this->_bdd->query("SELECT val FROM ruleset WHERE rule = 'lvlMax'");
    //     $tabRule = $q->fetch(PDO::FETCH_NUM);
    //     return isset($tabRule[0]) ? $tabRule[0] : false;
    // }
    public function getLvlMax(){
        $q = $this->_bdd->query("SELECT val FROM ruleset WHERE rule = 'lvlMax'");
        return $q->fetchColumn();
    }
    public function getRespawnMax(){
        $q = $this->_bdd->query("SELECT val FROM ruleset WHERE rule = 'respawn max'");
        return $q->fetchColumn();
    }
}