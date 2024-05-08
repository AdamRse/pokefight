<?php
class FightsManager{
    protected $_heroManager;
    protected $_monsterManager;
    protected $_round = 0;
    protected array $_logCombat = [];//action : 0:rad, 1:hit

    public function __construct(HeroesManager $hm, MonsterManager $mm){
        $this->_heroManager = $hm;
        $this->_monsterManager = $mm;
    }
    public function createmonster(){
        return new Monster();
    }
    public function findMonsterFor(Hero $hero){
        
        //Faire un algo pour trouver ou créer des monstres du niveau du héro
        return $this->createmonster();
    }
    public function fight(Hero $hero , Monster $monster, $save=true){
        $logCombat = [];
        while($monster->getHp() > 0 && $hero->getHp() > 0 ){
            $this->_round++;
            $logCombat[] = "Round <b>$this->_round</b>";
            $logCombat[] = $monster->hit($hero);
            if($hero->getHp() > 0)
                $logCombat[] = $hero->hit($monster);
        }
        if($hero->getHp() > 0){
            $logCombat[] = "<span class='logFinal victory'> You won ! </span>";
            $logCombat[] = $hero->lvlUp();
            if($monster->getBoss())
                $hero->setIncrementBoss();
        }
        else{
            $logCombat[] = "<span class='logFinal defeat'> Defeated... ".$monster->getNom()." was too strong...</span>";
        }
        if($save)
            $this->_heroManager->save($hero);
        return $logCombat;

    }
    public function fightTurnBased(Hero $hero , Monster $monster){
        $logCombat = [];
        if($monster->getHp() > 0 && $hero->getHp() > 0 ){
            $this->addLogCombat("<span class='logNewRound'>Round <b>$this->_round</b></span>");
            $this->addLogCombat($hero->hit($monster), 1);
            if($monster->getHp() > 0)
                $this->addLogCombat($monster->hit($hero), 2);
        }
        if($monster->getHp() <= 0){
            $this->addLogCombat("<span class='logFinal victory'> You won ! </span>", 100);
            $this->addLogCombat($hero->lvlUp());
            if($monster->getBoss())
                $hero->setIncrementBoss();
        }
        elseif($hero->getHp() <= 0){
            $this->addLogCombat("<span class='logFinal defeat'> Defeated... ".$monster->getNom()." was too strong...</span>", 101);
        }
        $monster->saveSession();
        $this->_heroManager->save($hero);
        return array("status" => 1, "logs" => $this->_logCombat, "heroHp" => $hero->getHp(), "monsterHp" => $monster->getHp());//Status : 0=combat en cours, 1=win, 2=lose
    }

    public function setRound($round){
        $this->_round = $round;
    }
    private function addLogCombat($logLine, $action = false){
        $this->_logCombat[] = array(
            "logLine" => $logLine
            , "action" => $action 
        );
    }
}