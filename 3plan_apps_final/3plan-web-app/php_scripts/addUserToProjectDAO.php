<?php
require_once '../php_scripts/login-checker.php';
require_once '../php_scripts/db-connect.php';
require_once '../php_scripts/ProjektUserDTL.php';

if (isset($_POST["prjID"]) && isset($_POST["uid"])) {
    addUserToProject($conn, $_POST["uid"], $_POST["prjID"]);
}