//window.onload=function(){
//    document.getElementById("audioBattle").play();
//}
let tempoDisplayLogs = 2000;
let tempoMinorHp = 10;
let displaying = false;
let animBar = false;
let endFight = false;
let displayFight = document.querySelector("#displayLogsMatch");
let btAttack = document.querySelector("#buttonattack");
let btPlayAgain = document.querySelector('#playAgain');

btAttack.addEventListener("click", function(){
    btAttack.style.display="none";
    getScriptPromise("fightHit", "at").then((rt) => {
        if(rt.status == 1){// Combat lancé en cours
            if(rt.monsterHp <= 0 || rt.hero <= 0) endFight = true;
            displaylogs(rt.logs);
            setTimeout(() => {
                changeHpBar(rt.monsterHp, false);
                setTimeout(() => {
                    changeHpBar(rt.heroHp);
                }, tempoDisplayLogs)
            }, 500);
        }
        else if(rt.status == 10){
            displayFight.innerHTML = "<p class='text-red-500'>"+rt.err+"</p>";
        }
        else{
            displayFight.innerHTML = "<p class='text-red-500'>Résultat non prévu par le script js</p>";
        }
        btAttack.disabled=false;
    })
});
function displaylogs(logArray){
    if(logArray[0]!=undefined){
        displaying=true;
        displayFight.innerHTML += "<p>"+logArray[0]+"</p>";
        displayFight.scrollTo(0, displayFight.scrollHeight);
        logArray.shift();
        setTimeout(() => { displaylogs(logArray) }, tempoDisplayLogs);
    }
    else{
        displaying=false;
        enableButton();
    }
}
function changeHpBar(newHp, hero = true){
    let character = hero ? "hero" : "monster";
    let elemHp = document.querySelector("."+character+"Hp");
    let hpBar = document.querySelector("."+character+"HpBar");
    let maxHp = parseInt(document.querySelector("."+character+"MaxHp").innerHTML);
    let hp = parseInt(elemHp.innerHTML);

    if(hp > newHp){
        animBar = true;
        hp--;
        let percent = hp*100/maxHp;
        console.log(percent, hp, maxHp, hpBar);
        elemHp.innerHTML = hp;
        hpBar.style.width = percent+"%";
        if(percent<25){
            hpBar.classList.remove("bg-yellow-500");
            hpBar.classList.remove("bg-green-500");
            hpBar.classList.add("bg-red-500");
        }
        else if(percent<50){
            hpBar.classList.remove("bg-green-500");
            hpBar.classList.add("bg-yellow-500");
        }
        setTimeout(() => { changeHpBar(newHp, hero) }, tempoMinorHp);
    }
    else{
        animBar = false;
        enableButton();
    }
}
function enableButton(){
    if(!animBar && !displaying){
        if(endFight)
            btPlayAgain.classList.remove('hidden');
        else
            btAttack.style.display="inline-block";
    }
}