<?php
class Hero{

    protected $_id = false;
    protected $_nom = "pokemon";
    protected $_atk = 100;
    protected $_hp = 100;
    protected $_maxHp = 100;
    protected $_armor = 10;
    protected $_lvl = 1;
    protected $_sprite = "magikarp.gif";
    protected $_respawn = 0;
    protected $_boss = 0;
    protected $_lastHope = true;

    public function __construct($attributs = false){
        if(!empty($attributs)){
            $this->_id = $attributs['id'];
            $this->_nom = $attributs['nom'];
            $this->_atk = $attributs['atk'];
            $this->_hp = $attributs['hp'];
            $this->_maxHp = $attributs['maxHp'];
            $this->_armor = $attributs['armor'];
            $this->_lvl = $attributs['lvl'];
            $this->_sprite = $attributs['sprite'];
            $this->_respawn = $attributs['respawn'];
            $this->_boss = $attributs['boss'];
        }
    }

    //Fight
    public function hit(Monster $monster){
        $log = "<span class='lineLog lineHero'><img class='avatar' src='".URL_AVATARS_H.$this->_sprite."'>";
        $dmgMax = round($this->_atk/2);
        $cc = rand(0, 20);
        $damage= rand(floor($dmgMax/3), $dmgMax);

        if($cc==0){
            $damage += 10;
            $log .= "<b>Critical hit !</b> ";
        }
        $log .= "<span class='nameHero'>".$this->_nom."</span> deals $damage damage".($damage>1 ? "s" : "").".";
        $log .= $monster->damages($damage);
        $log .= "</span>";

        return $log;
    }
    public function damages($dmg){
        $log = "";
    
        //Mécanique de blocage
        if($dmg > 0){
            $isBlock = round(0, 4);
            if($isBlock == 0){
                $block = rand(0, floor($this->_armor/2)-2);
                if($block>0){
                    $dmg-=$block;
                    $log .= " ($block damage".($block>1 ? "s" : "")." blocked through armor)";
                }
            }

            $this->_hp -= $dmg;
            //Mécanique de last hope
            if($this->_hp <= 0)
                if($this->_lastHope && rand(0, 2) == 0){
                    $this->_lastHope = false;
                    $this->_hp = 1;
                    $log .= " <b>LAST HOPE</b> : Miracle ! <b>$this->_nom</b> should have fainted, but remains up for a last attack !";
                }
                else
                    $this->_hp = 0;
        }
        return $log;
    }
    public function lvlUp(){
        $this->_lvl += 1;
        $log = "<span class='logFinal'>! Level UP ($this->_lvl) !<br/>Stats won : ";
        $hpmax = rand(5, 20);
        $atk = rand(1, 10);
        $armor = rand(5, 20);

        $this->_maxHp += $hpmax;
        $this->_atk += $atk;
        $this->_armor += $armor;

        $log .= "$hpmax HP max, $atk damages, $armor armor.</span>";
        return $log;
    }
    public function heal($heal){
        $this->_hp += $heal;
        if($this->_hp > $this->_maxHp)
            $this->_hp = $this->_maxHp;
    }
    public function respawnPenalties(){
        $this->_maxHp -= floor($this->_maxHp*rand(1,3)/100);
        $this->_hp = $this->_maxHp;
        $this->_armor -= floor($this->_armor*rand(0,3)/100);
        $this->_respawn++;
    }
    //Utils
    public function hpBar(){
        $percent = $this->_hp*100/$this->_maxHp;
        if($percent>100) $percent=100;
        ?>
        <div class="mb-6 h-1 w-full bg-neutral-200 dark:bg-neutral-600">
            <div class="heroHpBar h-3 bg-<?= $percent>=50 ? "green":($percent>=25 ? "yellow" : "red") ?>-500" style="width:  <?= $percent ?>%"></div>
            <div class=""><span class="heroHp"><?= $this->_hp ?></span> / <span class="heroMaxHp"><?= $this->_maxHp ?></span></div>
        </div>
        <?php
    }

    //GETTERS

    public function getId(){
        return $this->_id;
    }
    public function getNom(){
       return $this->_nom;
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
    public function getLvl(){
        return $this->_lvl;
    }
    public function getSprite(){
        return $this->_sprite;
    }
    public function getRespawn(){
        return $this->_respawn;
    }
    public function getBoss(){
        return $this->_boss;
    }

    public function getAllInArray(){
        return array(
            "id" => $this->_id
            ,"nom"=> $this->_nom
            , "atk"=> $this->_atk
            , "hp"=> $this->_hp
            , "maxHp"=> $this->_maxHp
            , "armor"=> $this->_armor
            , "lvl"=> $this->_lvl
            , "sprite"=> $this->_sprite
        );
    }
    
    //SETTERS

    public function setId($id){
        $this->_id = $id;
    }
    public function setNom($nom){
        $this->_nom = $nom;
    }
    public function setAtk($atk){
        $this->_atk = $atk;
    }
    public function setHp($hp){
        if($hp > $this->_maxHp) $hp = $this->_maxHp;
        if($hp < 0) $hp = 0;
        $this->_hp = $hp;
    }
    public function setMaxhp($hp){
        $this->_maxHp = $hp;
    }
    public function setArmor($armor){
        $this->_armor = $armor;
    }
    public function setLvl($lvl){
        $this->_lvl = $lvl;
    }
    public function setSprite($sprite){
        $this->_sprite = $sprite;
    }
    public function setRespawn($rs){
        $this->_respawn = $rs;
    }
    public function setIncrementBoss(){
        $this->_boss++;
    }

}