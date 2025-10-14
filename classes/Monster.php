<?php
class Monster{
    
    protected $_id = false;
    protected $_nom = "Voltorb";
    protected $_infos = "Un monstre !";
    protected $_atk = 100;
    protected $_hp = 100;
    protected $_maxHp = 100;
    protected $_armor = 10;
    protected $_sprite = "voltorb.png";
    protected $_lvl = 1;
    protected $_boss = false;
    protected $_difficulty = 1;

    public function __construct($attributs = false){
        if(!empty($attributs)){
            $this->_id = empty($attributs['id']) ? false : $attributs['id'];
            $this->_nom = $attributs['nom'];
            $this->_infos = $attributs['infos'];
            $this->_atk = $attributs['atk'];
            $this->_hp = $attributs['hp'];
            $this->_maxHp = $attributs['maxHp'];
            $this->_armor = $attributs['armor'];
            $this->_sprite = $attributs['sprite'];
            $this->_lvl = $attributs['lvl'];
            $this->_difficulty = empty($attributs['difficulty']) ? 0 : $attributs['difficulty'];
            $this->_boss = empty($attributs['boss']) ? false : true;
        }
    }

    //Fight
    public function hit(Hero $hero){
        $log = "<span class='lineLog lineMonster'><img class='avatar' src='".URL_AVATARS_M.$this->_sprite."'>";
        $dmgMax = round($this->_atk/2);
        $cc = rand(0, 10);
        $damage= rand(1, $dmgMax);

        if($damage == $dmgMax){
            $damage = $dmgMax*2;
            $log .= "<b>FATAL HIT !!!</b> ";
        }
        if($cc==0){
            $damage += 10;
            $log .= "<b>Critical hit !</b> ";
        }
        $log .= "<span class='nameMonster'>".$this->_nom."</span> deals $damage damage".($damage>1 ? "s" : "").".";
        $log .= $hero->damages($damage);
        $log .= "</span>";

        return $log;
    }
    public function damages($dmg){
        $log = "";
        $isBlock = round(0, 4);

        if($isBlock == 0){
            $block = rand(0, floor($this->_armor/10)-2);
            if($block>0){
                $dmg-=$block;
                $log .= " ($block damage".($block>1 ? "s" : "")." blocked through armor)";
            }
        }
        $this->_hp -= $dmg;
        if($this->_hp < 0)
            $this->_hp = 0;
        
        return $log;
    }
    public function saveSession(){
        $_SESSION['fight']['monster']=array(
            "hp" => $this->_hp
            , "id" => $this->_id
        );
    }
    public function exportArray(){
        return array(
            "lvl" => $this->_lvl
            , "nom" => $this->_nom
            , "infos" => $this->_infos
            , "hp" => $this->_hp
            , "maxHp" => $this->_maxHp
            , "sprite" => $this->_sprite
        );
    }
    //Utils
    public function hpBar(){
        $percent = $this->_hp*100/$this->_maxHp;
        if($percent>100) $percent=100;
        ?>
        <div class="mb-6 h-1 w-full bg-neutral-200 dark:bg-neutral-600">
            <div class="monsterHpBar h-3 bg-<?= $percent>=50 ? "green":($percent>=25 ? "yellow" : "red") ?>-500" style="width:  <?= $percent ?>%"></div>
            <div class=""><span class="monsterHp"><?= $this->_hp ?></span> / <span class="monsterMaxHp"><?= $this->_maxHp ?></span></div>
        </div>
        <?php
    }
    ///GETTERS

    public function getId(){
        return $this->_id;
    }
    public function getNom(){
       return $this->_nom;
    }
    public function getInfos(){
       return $this->_infos;
    }
    public function getAtk(){
       return $this->_atk;
    }
    public function getHp(){
        return $this->_hp;
    }
    public function getMaxHp(){
        return $this->_maxHp;
    }
    public function getArmor(){
        return $this->_armor;
    }
    public function getSprite(){
        return $this->_sprite;
    }
    public function getLvl(){
        return $this->_lvl;
    }
    public function getDifficulty(){
        return $this->_difficulty;
    }
    public function getBoss(){
        return $this->_boss;
    }
    
    //SETTERS

    public function setId($id){
        $this->_id = $id;
    }
    public function setNom($nom){
        $this->_nom = $nom;
    }
    public function setInfos($infos){
        $this->_infos = $infos;
    }
    public function setAtk($atk){
        $this->_atk = $atk;
    }
    public function setHp($hp){
        $this->_hp = $hp;
    }
    public function setMaxhp($hp){
        $this->_maxHp = $hp;
    }
    public function setArmor($armor){
        $this->_armor = $armor;
    }
    public function setSprite($sprite){
        $this->_sprite = $sprite;
    }
    public function setLvl($l){
        $this->_lvl = $l;
    }
    public function setDifficulty($d){
        $this->_difficulty = $d;
    }

}
    
