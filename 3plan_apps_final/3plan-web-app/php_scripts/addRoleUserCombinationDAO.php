<?php
require_once '../php_scripts/login-checker.php';
require_once 'db-connect.php';
require_once 'RolePrjUserDTL.php';
require_once 'globale-functions.php';

if (isInputsSet()) {
    $result = getSinglePrjRoleUser($conn, $_POST["user"], $_GET["id"], $_POST["roles"]);

    if ($result->num_rows === 0) {
        createRoleUserToProject($conn, $_POST["user"], $_GET["id"], $_POST["roles"]);

        redirectTo("../main_app/project-item.php?id=".$_GET["id"]);
    } else {
        redirectTo("../main_app/project-item.php?id=".$_GET["id"]."&info=combinationExists");
    }

} else {
    redirectTo("../main_app/project-manager.php");
}


function isInputsSet() {
    return isset($_POST["add-role-user-submit"]) && !empty($_POST["user"]) && !empty($_POST["roles"]) && isset($_GET["id"]);
}