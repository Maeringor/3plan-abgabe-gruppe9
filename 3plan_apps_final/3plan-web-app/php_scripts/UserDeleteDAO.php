<?php
// include db conn and DTL
require_once "login-checker.php";
require_once 'db-connect.php';
require_once 'UserDTL.php';
require_once 'neo4j-connect.php';
require_once 'neo4jDTL.php';
require_once "globale-functions.php";

if(isset($_POST["deleteUserBTN"])){
    // delete node form neo4j
    deleteNode($client, $_SESSION["kuid"]);
    // delete user from mysql
    deleteUserById($conn, $_SESSION["kuid"]);
}

redirectTo("../index.html");