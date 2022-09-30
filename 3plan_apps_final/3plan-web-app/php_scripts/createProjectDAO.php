<?php
require_once '../php_scripts/login-checker.php';
require_once 'db-connect.php';
require_once 'ProjektDTL.php';
require_once 'globale-functions.php';

if (isset($_POST["create_prj"])) {
    createProject($conn, $_SESSION["kuid"]);
 
    redirectTo("../main_app/project-manager.php");
}