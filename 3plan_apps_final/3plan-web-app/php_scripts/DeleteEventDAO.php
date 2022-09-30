<?php
require_once "login-checker.php";
require_once "db-connect.php";
require_once "EventDTL.php";
require_once "globale-functions.php";

if(isset($_POST["deleteEventBTN"])){
    
    if(isset($_POST["evid"])){
    deleteEventById($conn, $_POST["evid"]);
    }else if($_GET["id"]){
        deleteEventById($conn, $_GET["id"]);

    }
    redirectTo("../main_app/events-planner.php");
    exit();
}

?>