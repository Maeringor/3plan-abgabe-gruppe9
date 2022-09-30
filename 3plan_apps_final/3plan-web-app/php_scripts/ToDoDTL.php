<?php

function getAllToDoByKUID($conn, $uid) {
    $query = "SELECT * FROM ". TODO_TAB ." WHERE kuid = $uid;";
    $result = $conn->query($query);
    return $result;
}

function getTodoByToDoIDAndUserID($conn, $todo_id, $uid) {
    $query = "SELECT * FROM ". TODO_TAB ." WHERE kuid = $uid and todoid = $todo_id;";
    $result = $conn->query($query);
    return $result;
}

function createToDo($conn, $uid, $json_id) {
    $stmt = $conn->prepare("INSERT INTO ".TODO_TAB ." (KUID, ToDoBeschr, ToDoImage, ToDoTitel, JsonLink) VALUES (?, ?, ?, ?, ?);");
    $default_todo_img = '/blob/todo_images/default_todo_image.png';
    $beschr = "My Description";
    $titel = "My Title";
    $json_link = "/blob/personal-todo-json/".$json_id;
    
    $stmt->bind_param("issss", $uid, $beschr, $default_todo_img, $titel, $json_link);
    $stmt->execute();
}

function deleteToDo($conn, $uid, $todo_id) {
    $query = "DELETE FROM ". TODO_TAB ." WHERE kuid = $uid and todoid = $todo_id;";
    $conn->query($query);
}

function updateToDo($conn, $uid, $todo_id, $todo_beschr, $todo_image, $todo_title, $todo_json) {
    $stmt = $conn->prepare("UPDATE ".TODO_TAB ." SET ToDoBeschr= ?, ToDoImage = ?, ToDoTitel = ?, JsonLink = ? WHERE todoid = $todo_id AND kuid = $uid;");
    
    $stmt->bind_param("ssss", $todo_beschr, $todo_image, $todo_title, $todo_json);
    $stmt->execute();
}

function updateToDoImage($conn, $uid, $todo_id, $todo_image) {
    $stmt = $conn->prepare("UPDATE ".TODO_TAB ." SET ToDoImage = ? WHERE todoid = $todo_id AND kuid = $uid;");
    
    $stmt->bind_param("s", $todo_image);
    $stmt->execute();
}

?>  