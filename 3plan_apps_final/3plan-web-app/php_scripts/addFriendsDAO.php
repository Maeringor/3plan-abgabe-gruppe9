<?php

require_once "../php_scripts/login-checker.php";
require_once "neo4jDTL.php";
require_once "UserDTL.php";
require_once "neo4j-connect.php";
require_once "db-connect.php";
require_once "globale-functions.php";

if (isset($_POST["addBtn"]) && isset($_POST["username"])) {

    if ($_SESSION["kuname"] != $_POST["username"]) {
        $user_result = getUserByUsername($conn, $_POST["username"]);

        if ($user_result->num_rows == 1) {
            $user = $user_result->fetch_assoc();
            createRelationship($client, $_SESSION["kuid"], $user["KUID"]);

            redirectTo("../main_app/friendlist.php");
        } else {
            redirectTo("../main_app/friendlist.php?error=NoUserFound");
        }
    } else {
        redirectTo("../main_app/friendlist.php?info=EqualUsernames");
    }
} else {
    redirectTo("../main_app/dashboard.php?error=FatalError");
}