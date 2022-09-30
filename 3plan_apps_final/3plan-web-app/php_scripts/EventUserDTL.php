<?php

function getEventsByUserId($conn, $uid) {
    $stmt = $conn->prepare("SELECT * FROM ". EVENT_USER_TAB ." WHERE kuid = $uid;");
    $stmt->execute();
    $result = $stmt->get_result();
    return $result;
}

function getUserByEventId($conn, $evid) {
    $stmt = $conn->prepare("SELECT * FROM ". EVENT_USER_TAB ." WHERE evid = $evid;");
    $stmt->execute();
    $result = $stmt->get_result();
    return $result;
}

function deleteUserFromEventByUserId($conn, $uid, $evid){
    $stmt = $conn->prepare("DELETE FROM ". EVENT_USER_TAB ." WHERE kuid = $uid and evid = $evid;");
    $stmt->execute();
}

function addUserToEvent($conn, $uid, $evid){
    $stmt = $conn->prepare("INSERT INTO ". EVENT_USER_TAB ." (KUID, EVID) VALUES (?, ?);");
    $stmt->bind_param("ii", $uid, $evid);
    $stmt->execute();
}

?>