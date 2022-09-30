<?php
// dao to login an user

// include db conn and DTL
require_once 'db-connect.php';
require_once 'UserDTL.php';
require_once 'UserAdressDTL.php';
require_once 'globale-functions.php';

// check inputs are set
if (allInputsSet()) {
    $user = getUserByUsername($conn, $_POST["username"]);
    if ($user->num_rows === 1) {
        while ($row = $user->fetch_assoc()) {
            if (password_verify($_POST["password"], $row["Kpassword"])) {
                session_start();
                // add session vars
                $_SESSION["kuid"] = $row["KUID"];
                $_SESSION["kuname"] = $row["KUname"];
                $_SESSION["kname"] = $row["KName"];
                $_SESSION["kprofileimage"] = $row["KProfileImage"];
                $_SESSION["kmail"] = $row["Kmail"];
                $_SESSION["enabled"] = $row["enabled"];

                redirectTo("../main_app/dashboard.php");
            } else {
                redirectTo("../login.html?error=wrongPassword");
            }
        }
    } else {
        redirectTo("../login.html?error=noUserFound");
    }
} else {
    redirectTo("../login.html?error=invalidInput");
}

function allInputsSet()
{
    return isset($_POST["username"]) && isset($_POST["password"]) && isset($_POST["submit"]);
}