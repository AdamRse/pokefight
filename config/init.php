<?php
//parametres
session_start();
ob_start();

//Pretty errors
ini_set("html_errors", "1");
ini_set("error_prepend_string", "<pre style='color: #333; font-family:monospace; white-space: pre-wrap;font-size: 17px;color:#880808'>");
ini_set("error_append_string ", "</pre>");

//modules
require "fct.php";
require "autoloader.php";
require "db.php";
require "connectManager.php";
require "const.php";

//init
//if(!empty($_SESSION['fight'])) unset($_SESSION['fight']);