<?php 
require_once '../php_scripts/login-checker.php';
require_once "../php_scripts/db-connect.php";
require_once "../php_scripts/RolePrjUserDTL.php";
require_once "../php_scripts/ProjektUserDTL.php";
require_once "../php_scripts/ProjektDTL.php";
require_once 'globale-functions.php';

if (isParameterSet()) {
    if (isRequstUserInProject($conn, $_SESSION["kuid"])) {
        deleteRolePrjUser($conn, $_GET["usr"], $_GET["prj"], $_GET["rol"]);
        
        redirectTo("../main_app/project-item.php?id=".$_GET["prj"]);
    }
} else {
    redirectTo("../main_app/project-manager.php");
}


function isParameterSet() {
    return isset($_GET["prj"]) && isset($_GET["usr"]) && isset($_GET["rol"]);
}

function isRequstUserInProject($conn, $uid) {
    $projec_result = getProjectById($conn, $_GET["prj"]);
    $project = $projec_result->fetch_assoc();

    if ($project["KUID"] === $uid) {
        return true;
    }

    $user_in_prj_result = getProjectsByUserId($conn, $uid);
    while ($row = $user_in_prj_result->fetch_assoc()) {
        if ($row["PRID"] === $_GET["prj"]) {
            return true;
        }
    }

    return false;
}