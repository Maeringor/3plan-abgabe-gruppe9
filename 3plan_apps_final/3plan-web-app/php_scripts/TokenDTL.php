<?php

function createToken($conn, $uid, $token){
    $stmt = $conn->prepare("INSERT INTO ".TOKEN_TAB ." (KUID, Token) VALUES (?, ?);");
    $stmt->bind_param("ss", $uid, $token);
    $stmt->execute();
}

function getTokenByUserId($conn, $uid) {
    $stmt = $conn->prepare("SELECT * FROM ".TOKEN_TAB ." WHERE kuid=?;");
    $stmt->bind_param("s", $uid); 
    $stmt->execute();
    $result = $stmt->get_result();
    return $result;
}

function updateTokenById($conn, $token_id, $token, $confirmed, $sent) {
    $stmt = $conn->prepare("UPDATE ".TOKEN_TAB ." SET Token= '$token', TConfirmed= $confirmed, TSent= $sent WHERE toid=?;");
    $stmt->bind_param("i", $token_id); 
    $stmt->execute();
}

?>