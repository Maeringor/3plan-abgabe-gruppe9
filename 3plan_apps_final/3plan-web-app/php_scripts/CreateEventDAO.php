<?php
require_once "login-checker.php";
require_once "globale-functions.php";
require_once "db-connect.php";
require_once "EventDTL.php";

if(isset($_POST["createEventBTN"]) && !empty($_POST["title"]) && !empty($_POST["descr"]) && !empty($_POST["time"]) && !empty($_POST["date"])){

    $start = $_POST["date"] . " " . $_POST["time"].":00";

    if(isset($_POST["online_cbx"])){

        createOnlineEvent($conn, $_POST["title"], $_POST["descr"], $_SESSION["kuid"], $start, $_POST["colors"]);
        
    }else{

        createLiveEvent($conn, $_POST["title"], $_POST["descr"], $_SESSION["kuid"], $_POST["street-number"], $_POST["addr-city"], $_POST["country"], $start, $_POST["colors"]);
        
    }

    redirectTo("../main_app/events-planner.php");

}else{
    redirectTo("../main_app/events-planner.php?info=noValidInput");
}

?>