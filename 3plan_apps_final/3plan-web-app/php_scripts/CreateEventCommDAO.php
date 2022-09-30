<?php
require_once "login-checker.php";
require_once "EventCommDTL.php";
require_once "db-connect.php";
require_once "globale-functions.php";

if(isset($_POST["createCommBTN"]) && !empty($_POST["co-text"]) && !ctype_space($_POST["co-text"])){
    createComment($conn, $_SESSION["kuid"], $_POST["evid"], $_POST["co-text"]);
    redirectTo("../main_app/event-item.php?id=".$_POST["evid"]);

}else{
    redirectTo("../main_app/event-item.php?info=noValidInput&id=".$_POST["evid"]);
}

?>