<?php

function getUserAdressByUserID($conn, $uid) {
    $stmt = $conn->prepare("SELECT * FROM ". USERADDR_TAB ." WHERE kuid = $uid;");
    $stmt->execute();
    $result = $stmt->get_result();
    return $result;
}

function createUserAdress($conn, $uid, $streetNr, $cityPLZ, $country){
    $stmt = $conn->prepare("INSERT INTO ".USERADDR_TAB ." (KUID, KuStrasseNr, KuPLZOrt, KuLand) VALUES (?, ?, ?, ?);");
    $stmt->bind_param("isss", $uid, $streetNr, $cityPLZ, $country);
    $stmt->execute();
}

function updateStreetNr($conn, $kuid, $streetNr){
    $stmt = $conn->prepare("UPDATE ".USERADDR_TAB." SET KuStrasseNr= ? WHERE KUID= ?;");
    $stmt->bind_param("si", $streetNr, $kuid);
    $stmt->execute();
}

function updatePLZOrt($conn, $kuid, $plzOrt){
    $stmt = $conn->prepare("UPDATE ".USERADDR_TAB." SET KuPLZOrt= ? WHERE KUID= ?;");
    $stmt->bind_param("si", $plzOrt, $kuid);
    $stmt->execute();
}

function updateCountry($conn, $kuid, $country){
    $stmt = $conn->prepare("UPDATE ".USERADDR_TAB." SET KuLand= ? WHERE KUID= ?;");
    $stmt->bind_param("si", $country, $kuid);
    $stmt->execute();
}



?>