<?php

if(isset($_GET['devmod'])){
    if($_GET['devmod']==1)
        $_SESSION['devmod']=true;
    else
        $_SESSION['devmod']=false;
}
if(isset($_REQUEST['dc'])){
    session_destroy();
}