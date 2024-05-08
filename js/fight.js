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
            if(rt.monsterHp <= 0 || rt.hero <= 0)
                endFight = true;
            executeLogs(rt);
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
async function executeLogs(allLogs){
    let logArray = allLogs.logs;
    if(logArray[0]!=undefined){
        displaying=true;// on affiche quelque chose, donc on le signale pour pas que le bouton d'action se réaffiche

        //On execute l'action
        if(logArray[0].action == 1){
            changeHpBar(newHp, hero = true)
        }

        //On affiche la ligne à l'user
        displayLogs(logArray[0].logLine);

        //On reture la ligne de log qu'on vient d'executer et on recommance pour la ligne suivante s'il y en a une
        logArray.shift();
        setTimeout(() => { executeLogs(logArray) }, tempoDisplayLogs);
    }
    else{
        displaying=false;
        enableButton();
    }
}
function displayLogs(txt){
    displayFight.innerHTML += "<p>"+txt+"</p>";
    displayFight.scrollTo(0, displayFight.scrollHeight);
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
        if(endFight){
            btPlayAgain.classList.remove('hidden');
            document.querySelector("audio").src="/audio/victory.m4a";
        }
        else
            btAttack.style.display="inline-block";
    }
}