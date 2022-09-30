<?php
// Data Transfer Logic

// methods to get/delete/update an user
function getAllUser($conn) {
    $query = "SELECT * FROM ". USER_TAB .";";
    $result = $conn->query($query);
    return $result;
}

function getUserById($conn, $uid) {
    // id anpassen und es würde noch bind params fehlen
    // https://www.php.net/manual/de/mysqli.quickstart.prepared-statements.php
    $stmt = $conn->prepare("SELECT * FROM ". USER_TAB ." WHERE kuid = $uid;");
    $stmt->execute();
    $result = $stmt->get_result();
    return $result;
}

function getUserByUsername($conn, $uname){
    $stmt = $conn->prepare("SELECT * FROM ". USER_TAB ." WHERE KUname= '$uname';");
    $stmt->execute();
    $result = $stmt->get_result();
    return $result;
}

function getUserByEmail($conn, $email){
    $stmt = $conn->prepare("SELECT * FROM ". USER_TAB ." WHERE kmail = '$email';");
    $stmt->execute();
    $result = $stmt->get_result();
    return $result;
}

function createUser($conn, $uname, $fullname, $email, $password){
    $stmt = $conn->prepare("INSERT INTO ".USER_TAB ." (KUname, KName, KProfileImage, Kmail, Kpassword) VALUES (?, ?, ?, ?, ?);");
    $default_profile_img = '/blob/profile_images/default_profile_image.png';
    $stmt->bind_param("sssss", $uname, $fullname, $default_profile_img, $email, $password);
    $stmt->execute();
}

function updateUsername($conn, $kuid, $kuname){
    $stmt = $conn->prepare("UPDATE ".USER_TAB." SET KUname= ? WHERE KUID= ?;");
    $stmt->bind_param("si", $kuname, $kuid);
    $stmt->execute();
}

function updateFullname($conn, $kuid, $fullname){
    $stmt = $conn->prepare("UPDATE ".USER_TAB." SET KName= ? WHERE KUID= ?;");
    $stmt->bind_param("si", $fullname, $kuid);
    $stmt->execute();
}

function updateImage($conn, $kuid, $image){
    $stmt = $conn->prepare("UPDATE ".USER_TAB." SET KProfileImage= ? WHERE KUID= ?;");
    $stmt->bind_param("si", $image, $kuid);
    $stmt->execute();
}

function updateEnable($conn, $kuid, $enabled){
    $stmt = $conn->prepare("UPDATE ".USER_TAB." SET enabled= ? WHERE KUID= ?;");
    $stmt->bind_param("ii", $enabled, $kuid);
    $stmt->execute();
}

function deleteUserById($conn, $kuid){
    $stmt = $conn->prepare("DELETE FROM ".USER_TAB." WHERE KUID= '$kuid';");
    $stmt->execute();
}


?>