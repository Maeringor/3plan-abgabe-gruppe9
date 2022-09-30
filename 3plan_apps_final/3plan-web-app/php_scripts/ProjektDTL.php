<?php

function getProjectsByOwnerId($conn, $uid) {
    $stmt = $conn->prepare("SELECT * FROM ". PRJ_TAB ." WHERE kuid = $uid;");
    $stmt->execute();
    $result = $stmt->get_result();
    return $result;
}

function getProjectById($conn, $prj_id) {
    $stmt = $conn->prepare("SELECT * FROM ". PRJ_TAB ." WHERE prid = $prj_id;");
    $stmt->execute();
    $result = $stmt->get_result();
    return $result;
}

function getProjectByIdAndOwnerId($conn, $prj_id, $uid) {
    $stmt = $conn->prepare("SELECT * FROM ". PRJ_TAB ." WHERE prid = $prj_id AND kuid = $uid;");
    $stmt->execute();
    $result = $stmt->get_result();
    return $result;
}

function createProject($conn, $uid) {
    $stmt = $conn->prepare("INSERT INTO ". PRJ_TAB ." (KUID, PrBeschr, PrTitel, PrImage) VALUES (?, ?, ?, ?);");
    $default_prj_img = '/blob/project_images/default_project_image.png';
    $beschr = "My Description...";
    $titel = "My Project";

    $stmt->bind_param("isss", $uid, $beschr, $titel, $default_prj_img);
    $stmt->execute();
}

function deleteProject($conn, $prj_id, $uid) {
    $query = "DELETE FROM ". PRJ_TAB ." WHERE kuid = $uid and prid = $prj_id;";
    $conn->query($query);
}

function updateProjectImage($conn, $uid, $prj_id, $prj_image) {
    $stmt = $conn->prepare("UPDATE ". PRJ_TAB ." SET PrImage = ? WHERE prid = $prj_id AND kuid = $uid;");
    
    $stmt->bind_param("s", $prj_image);
    $stmt->execute();
}

function updateProject($conn, $uid, $prj_id, $titel, $beschr, $image) {
    $stmt = $conn->prepare("UPDATE ". PRJ_TAB ." SET PrBeschr = ?, PrTitel = ?, PrImage = ? WHERE prid = $prj_id AND kuid = $uid;");
    
    $stmt->bind_param("sss", $beschr, $titel, $image);
    $stmt->execute();
}