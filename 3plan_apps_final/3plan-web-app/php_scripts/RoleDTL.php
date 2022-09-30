<?php

function getRoles($conn) {
    $query = "SELECT * FROM ". ROLE_TAB .";";
    $result = $conn->query($query);
    return $result;
}

function getRoleById($conn, $role_id) {
    $query = "SELECT * FROM ". ROLE_TAB ." WHERE roleid = $role_id;";
    $result = $conn->query($query);
    return $result;
}

?>