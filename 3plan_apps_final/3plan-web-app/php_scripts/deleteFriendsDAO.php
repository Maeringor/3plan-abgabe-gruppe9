<?php

require_once "../php_scripts/login-checker.php";
require_once "neo4jDTL.php";
require_once "UserDTL.php";
require_once "neo4j-connect.php";
require_once "db-connect.php";
require_once "globale-functions.php";

if (isset($_POST["deleteBtn"]) && isset($_POST["id"])) {
    $all_Friends = getFriends($client, $_SESSION["kuid"]);

    if (in_array($_POST["id"], $all_Friends)) {
        deleteRelationship($client, $_SESSION["kuid"], $_POST["id"]);
        redirectTo("../main_app/friendlist.php");
    } else {
        redirectTo("../main_app/dashboard.php?error=UserIdNotInCurrentFriendlist");
    }
} else {
    redirectTo("../main_app/dashboard.php?error=FatalError");
}