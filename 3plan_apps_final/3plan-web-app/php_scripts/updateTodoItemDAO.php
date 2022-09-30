<?php
require_once '../php_scripts/login-checker.php';
require_once "../php_scripts/db-connect.php";
require_once "../php_scripts/ToDoDTL.php";
require_once 'globale-functions.php';

if (inputsSet()) {
    $todo_result = getTodoByToDoIDAndUserID($conn, $_GET["id"], $_SESSION["kuid"]);
    if ($todo_result->num_rows === 1) {
        $todo = $todo_result->fetch_assoc();
        updateToDo($conn, $_SESSION["kuid"], $_GET["id"], $_POST["td-item-text"], $todo["ToDoImage"], $_POST["td-item-title"], $todo["JsonLink"]);
        
        redirectTo("../main_app/todo-item.php?id=".$_GET["id"]);
    } else {
        redirectTo("../main_app/personal-todo.php?info=noTodoFound");
    }
}

function inputsSet() {
    return isset($_GET["id"]) && isset($_POST["save-td-item"]) && isset($_POST["td-item-title"]) && isset($_POST["td-item-text"]);
}