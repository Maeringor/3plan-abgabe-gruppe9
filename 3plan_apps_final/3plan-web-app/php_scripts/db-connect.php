<?php
    // infos für die devs zu objektorientierter msqyli version
    // https://www.php.net/manual/de/mysqli.query.php

    $host = "";
    $db_username = "";
    $db_password = "";
    $db_name = "k134277_3plan_production_db";
    

    // table names
    define('USER_TAB', "kundentabelle");
    define('EVENTCOMM_TAB', "eventcommenttabelle");
    define('EVENT_USER_TAB', "eventkundentabelle");
    define('EVENT_TAB', "eventtabelle");
    define('USERADDR_TAB', "kundenadresstabelle");
    define('PRJ_USER_TAB', "projektkundentabelle");
    define('PRJ_TAB', "projekttabelle");
    define('ROLE_PRJ_USER_TAB', "roleprojku");
    define('ROLE_TAB', "rollentabelle");
    define('TODO_TAB', "todotabelle");
    define('TOKEN_TAB', "tokentabelle");

    $conn = new mysqli($host, $db_username, $db_password, $db_name, 3306);
    

    if ($conn->connect_error) {
        die("Connection to database failed: " . $conn->connect_error);
    }

    define('conn_globale', $conn);
    
