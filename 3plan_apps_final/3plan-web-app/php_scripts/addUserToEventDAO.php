<?php
require_once '../php_scripts/login-checker.php';
require_once '../php_scripts/db-connect.php';
require_once '../php_scripts/EventUserDTL.php';

if (isset($_POST["evID"]) && isset($_POST["uid"])) {
    addUserToEvent($conn, $_POST["uid"], $_POST["evID"]);
}