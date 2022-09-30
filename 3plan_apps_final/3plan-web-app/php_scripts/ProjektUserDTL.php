<?php

function getProjectsByUserId($conn, $uid) {
    $stmt = $conn->prepare("SELECT * FROM ". PRJ_USER_TAB ." WHERE kuid = $uid;");
    $stmt->execute();
    $result = $stmt->get_result();
    return $result;
}

function getUserByProjectId($conn, $prj_id) {
    $stmt = $conn->prepare("SELECT * FROM ". PRJ_USER_TAB ." WHERE prid = $prj_id;");
    $stmt->execute();
    $result = $stmt->get_result();
    return $result;
}

function getSingleProject($conn, $prj_id, $uid) {
    $stmt = $conn->prepare("SELECT * FROM ". PRJ_USER_TAB ." WHERE prid = $prj_id AND kuid = $uid;");
    $stmt->execute();
    $result = $stmt->get_result();
    return $result;
}

function addUserToProject($conn, $add_user_id, $project_id) {
    $stmt = $conn->prepare("INSERT INTO ". PRJ_USER_TAB ." (KUID, PRID) VALUES (?, ?);");
    $stmt->bind_param("ii", $add_user_id, $project_id);
    $stmt->execute();
}

function deleteUserFromProject($conn, $prj_id, $uid) {
    $query = "DELETE FROM ". PRJ_USER_TAB ." WHERE kuid = $uid and prid = $prj_id;";
    $conn->query($query);
}

?>