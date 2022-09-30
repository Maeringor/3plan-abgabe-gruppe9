<?php
require_once '../php_scripts/login-checker.php';
require_once "../php_scripts/db-connect.php";
require_once "../php_scripts/ProjektDTL.php";
require_once 'globale-functions.php';

if (inputsSet()) {
    $prj_result = getProjectByIdAndOwnerId($conn, $_GET["id"], $_SESSION["kuid"]);
    if ($prj_result->num_rows === 1) {
        $project = $prj_result->fetch_assoc();

        updateProject($conn, $_SESSION["kuid"], $_GET["id"], $_POST["prj-item-title"], $_POST["prj-item-text"], $project["PrImage"]);
    
        redirectTo("../main_app/project-item.php?id=".$_GET["id"]);
    }
} {
    redirectTo("../main_app/project-manager.php");
}

function inputsSet() {
    return isset($_GET["id"]) && isset($_POST["save-prj-item"]) && isset($_POST["prj-item-title"]) && isset($_POST["prj-item-text"]);
}