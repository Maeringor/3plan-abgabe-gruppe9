<?php
require_once '../php_scripts/login-checker.php';
require_once "../php_scripts/db-connect.php";
require_once "../php_scripts/ToDoDTL.php";
require_once 'globale-functions.php';
// TODO default image + länge in db anpassen

if (isset($_POST["create-todo"])) {
    $uid = $_SESSION["kuid"];
    $json_id = time()."_".$uid.".json";

    createToDo($conn, $uid, $json_id);
    createToDoItemJson($json_id);

    redirectTo("../main_app/personal-todo.php");
}

function createToDoItemJson($json_id) {
    // given path
    $path_name = "../blob/personal-todo-json/";
    $myfile = fopen($path_name.$json_id, "w+");
    fclose($myfile);
}