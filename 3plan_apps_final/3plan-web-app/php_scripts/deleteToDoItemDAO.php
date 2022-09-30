<?php
require_once '../php_scripts/login-checker.php';
require_once "../php_scripts/db-connect.php";
require_once "../php_scripts/ToDoDTL.php";
require_once 'globale-functions.php';

if (isset($_POST["delete-todo"]) && isset($_POST["id"])) {
    $uid = $_SESSION["kuid"];
    $todo_result = getTodoByToDoIDAndUserID($conn, $_POST["id"], $uid);
    $todo = $todo_result->fetch_assoc();

    deleteToDo($conn, $uid, $todo["ToDoID"]);
    deleteJsonFile("..".$todo["JsonLink"]);

    // delete image from blob
    if (strcmp($todo["ToDoImage"], "/blob/todo_images/default_todo_image.png") !== 0) {
        unlink("..".$todo["ToDoImage"]);
    }

    redirectTo("../main_app/personal-todo.php");
} else {
    redirectTo("../main_app/personal-todo.php");
}

function deleteJsonFile($json_filepath) {
    unlink($json_filepath);
}