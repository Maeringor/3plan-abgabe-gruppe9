<?php

function getUserRolesByProjectId($conn, $proj_id) {
    $query = "SELECT * FROM ". ROLE_PRJ_USER_TAB ." WHERE prid = $proj_id;";
    $result = $conn->query($query);
    return $result;
}

function getSinglePrjRoleUser($conn, $uid, $prj_id, $role_id) {
    $query = "SELECT * FROM ". ROLE_PRJ_USER_TAB ." WHERE prid = $prj_id AND kuid = $uid AND roleid = $role_id;";
    $result = $conn->query($query);
    return $result;
}

function deleteRolePrjUser($conn, $uid, $prj_id, $role_id) {
    $query = "DELETE FROM ". ROLE_PRJ_USER_TAB ." WHERE kuid = $uid and prid = $prj_id AND roleid = $role_id;";
    $conn->query($query);
}

function createRoleUserToProject($conn, $uid, $prj_id, $role_id) {
    $stmt = $conn->prepare("INSERT INTO ". ROLE_PRJ_USER_TAB ." (KUID, ROLEID, PRID) VALUES (?, ?, ?);");

    $stmt->bind_param("iii", $uid, $role_id, $prj_id);
    $stmt->execute();
}

?>