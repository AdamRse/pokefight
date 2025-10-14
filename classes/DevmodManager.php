<?php
class DevmodManager{
    protected $_bdd;

    public function __construct(PDO $connexion){
        $this->_bdd = $connexion;
    }
    public function respawn($heroId){
        $q = $this->_bdd->prepare("SELECT maxHp FROM hero WHERE id = ?");
        $q->execute([$heroId]);
        $hpMax = $q->fetchColumn();
        $q = $this->_bdd->prepare("UPDATE hero SET hp = '$hpMax' WHERE id = ?");
        return $q->execute([$heroId]);
    }
    public function reset($heroId){
        $q = $this->_bdd->prepare("UPDATE hero SET atk = '100', hp = '100', maxHp = '100', armor = '10', respawn = '0' WHERE id = ?");
        return $q->execute([$heroId]);
    }
    public function generateMonsters(int $instances = 5, int $difficulty = 1, bool $reset = false){
        $q = $this->_bdd->query("SELECT val FROM ruleset WHERE rule = 'lvlMax'");
        $lvlMax = $q->fetchColumn();
        $lvlMax+=3;
        if($reset)
            $q = $this->_bdd->query("TRUNCATE TABLE monstre");

        $heroes = [];
        for($i=0;$i<$instances;$i++)
            $heroes[] = new Hero();
        $mm = new MonsterManager($this->_bdd);

        while($heroes[0]->getLvl() <= $lvlMax){
            foreach($heroes as $hero1){
                $hpRandom = fourchetteRandom($hero1->getMaxHp()+($difficulty-1)*2, 10+($difficulty-1)*5);
                $tab = [
                    'id' => false
                    , 'nom' => "Voltorb"
                    , 'infos' => "A wild voltorb appears !"
                    , 'atk' => fourchetteRandom($hero1->getAtk()+($difficulty-1)*2, 10+($difficulty-1)*5)
                    , 'hp' => $hpRandom
                    , 'maxHp' => $hpRandom
                    , 'armor' => fourchetteRandom($hero1->getArmor()+($difficulty-1), $difficulty)
                    , 'sprite' => "voltorb.png"
                    , 'lvl' => $hero1->getLvl()
                    , 'difficulty' => $difficulty
                ];
                $hero1->lvlUp();
                $mm->add(new Monster($tab));
            }
        }
        return false;

    }
}