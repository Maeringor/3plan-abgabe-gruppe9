<?php
require_once '../php_scripts/login-checker.php';
require_once "../php_scripts/db-connect.php";
require_once "../php_scripts/ProjektUserDTL.php";
require_once 'globale-functions.php';

if (isset($_POST["leave-prj"]) && isset($_POST["id"])) {
    $user_prj_result = getSingleProject($conn, $_POST["id"], $_SESSION["kuid"]);

    if ($user_prj_result->num_rows === 1) {
        deleteUserFromProject($conn, $_POST["id"], $_SESSION["kuid"]);

        redirectTo("../main_app/project-manager.php");
    } else {
        redirectTo("../main_app/project-manager.php?error=notPartOfTheProject");
    }
} else {
    redirectTo("../main_app/project-manager.php");
}