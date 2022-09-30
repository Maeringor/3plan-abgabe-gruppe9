<?php
require_once '../php_scripts/login-checker.php';
require_once '../php_scripts/db-connect.php';
require_once '../php_scripts/ToDoDTL.php';

if (isset($_GET["id"])) {
    $todo_result = getTodoByToDoIDAndUserID($conn, $_GET["id"], $_SESSION["kuid"]);
    if ($todo_result->num_rows === 1) {
        $todo = $todo_result->fetch_assoc();
    }
} else {
    redirectTo("personal-todo.php");
}

header("Content-Type: application/json");

// fetch created json file
$json = file_get_contents("php://input");

// given path
$path_name = "..";
// dynamic value from user (set by creation of todo list)
$file_name = $todo["JsonLink"];
// final name
$abs_name = $path_name.$file_name;

/* sanity check */
if (json_decode($json) != null)
{
    // opens existing file
    $file = fopen($abs_name,'w+');
    fwrite($file, $json);
    fclose($file);
}