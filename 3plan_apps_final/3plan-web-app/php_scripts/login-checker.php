<?php
session_start();

require_once "globale-functions.php";

if (!isset($_SESSION["kuid"]) || $_SESSION["enabled"] === 0) {
    redirectTo("../login.html");
}

/*
*   Include this file ontop of every page which has to be
*   checked for either an user being logged in or if a user
*   has been enabled via mail confirmation.
*/