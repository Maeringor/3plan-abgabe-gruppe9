<?php

function getEventByEventId($conn, $id){
    $stmt = $conn->prepare("SELECT * FROM ". EVENT_TAB ." WHERE evid = $id;");
    $stmt->execute();
    $result = $stmt->get_result();
    return $result;
}

function getEventsByOwnerId($conn, $uid) {
    $stmt = $conn->prepare("SELECT * FROM ". EVENT_TAB ." WHERE kuid = $uid;");
    $stmt->execute();
    $result = $stmt->get_result();
    return $result;
}

function deleteEventById($conn, $evid){
    $stmt = $conn->prepare("DELETE FROM ". EVENT_TAB ." WHERE evid = $evid;");
    $stmt->execute();
   
}

function createOnlineEvent($conn, $title, $descr, $ownerID ,$start, $color){
    $stmt = $conn->prepare("INSERT INTO ".EVENT_TAB ." (KUID, EVStart, EvTitle, EvBeschr, EvColor) VALUES (?, ?, ?, ?, ?);");
    $stmt->bind_param("sssss", $ownerID, $start, $title, $descr, $color);
    $stmt->execute();
}

function createLiveEvent($conn, $title, $descr, $ownerID, $street, $address, $country, $start, $color){
    $stmt = $conn->prepare("INSERT INTO ".EVENT_TAB ." (KUID, EVStart, EvStrasseNr, EvPLZOrt, EvLand, EvTitle, EvBeschr, EvColor) VALUES (?, ?, ?, ?, ?, ?, ?, ?);");
    $stmt->bind_param("ssssssss", $ownerID, $start, $street, $address, $country, $title, $descr, $color);
    $stmt->execute();
}


?>