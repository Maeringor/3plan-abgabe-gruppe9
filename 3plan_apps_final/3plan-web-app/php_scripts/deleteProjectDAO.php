<?php
require_once '../php_scripts/login-checker.php';
require_once "../php_scripts/db-connect.php";
require_once "../php_scripts/ProjektDTL.php";
require_once 'globale-functions.php';

if (isset($_POST["delete-prj"]) && isset($_POST["id"])) {
    $prj_result = getProjectByIdAndOwnerId($conn, $_POST["id"], $_SESSION["kuid"]);
    $project = $prj_result->fetch_assoc();

    if ($prj_result->num_rows === 1) {
        deleteProject($conn, $_POST["id"], $_SESSION["kuid"]);

        // delete image from blob
        if (strcmp($project["PrImage"], "/blob/project_images/default_project_image.png") !== 0) {
            unlink("..".$project["PrImage"]);
        }

        redirectTo("../main_app/project-manager.php");
    } else {
        redirectTo("../main_app/project-manager.php?info=noProjectFound");
    }
} else {
    redirectTo("../main_app/project-manager.php");
}