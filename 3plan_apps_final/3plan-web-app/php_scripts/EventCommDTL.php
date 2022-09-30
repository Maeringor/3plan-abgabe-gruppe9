<?php

function getAllCommentsByEventID($conn, $eventID){
    $stmt = $conn->prepare("SELECT * FROM ". EVENTCOMM_TAB ." WHERE evid = $eventID;");
    $stmt->execute();
    $result = $stmt->get_result();
    return $result;
}

function createComment($conn, $uid, $evid, $comment){
    $stmt = $conn->prepare("INSERT INTO ".EVENTCOMM_TAB ." (EVID, KUID, Message) VALUES (?, ?, ?);");
    $stmt->bind_param("iis", $evid, $uid, $comment);
    $stmt->execute();
}

?>