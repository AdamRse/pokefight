function loader(){
    document.querySelector("#divLoader").classList.add("hidden");
    // setTimeout(() => {
    //     document.querySelector("#divLoader").classList.add("hidden");
    // }, 1000)
}
async function getScriptPromise(phpScript, rq = "") {
    if(rq!="" && rq[0]!="?") rq = "?"+rq;
    const JsonResp = await fetch("./ajax/"+phpScript+".php"+rq);
    const tabResp = await JsonResp.json();
    return tabResp;
}