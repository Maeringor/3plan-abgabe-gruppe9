<?php
require_once "login-checker.php";
require_once "db-connect.php";
require_once "EventUserDTL.php";
require_once "globale-functions.php";

if(isset($_POST["leaveEventBTN"])){
    deleteUserFromEventByUserId($conn, $_SESSION["kuid"], $_POST["evid"]);

    redirectTo("../main_app/events-planner.php");
    exit();
}

?>