<?php
require_once "login-checker.php";
require_once "UserDTL.php";
require_once "../php_scripts/UserAdressDTL.php";
require_once "db-connect.php";  
require_once "globale-functions.php";

$kuAdress = getUserAdressByUserID($conn, $_SESSION["kuid"])->fetch_assoc();

if(isset($_POST["changeUsernameBTN"]) && !empty($_POST["username"]) && $_POST["username"] !== $_SESSION["kuname"] && getUserByUsername($conn, $_POST["username"])->num_rows == 0){
    $newUsername = $_POST["username"];
    $userID = $_SESSION["kuid"];

    updateUsername($conn, $userID, $newUsername);
    $_SESSION["kuname"] = $_POST["username"];

    redirectTo("../main_app/profile.php");
    exit();
}else if(isset($_POST["changeNameBTN"]) && !empty($_POST["fullname"]) && $_POST["fullname"] !== $_SESSION["kname"]){
    $newFullname = $_POST["fullname"];
    $userID = $_SESSION["kuid"];

    updateFullname($conn, $userID, $newFullname);
    $_SESSION["kname"] = $_POST["fullname"];

    redirectTo("../main_app/profile.php");
    exit();
}else if(isset($_POST["changeStreetBTN"]) && $_POST["street"] !== $kuAdress["KuStraßeNr"]){
    $newStreet = $_POST["street"];
    $userID = $_SESSION["kuid"];

    updateStreetNr($conn, $userID, $newStreet);

    redirectTo("../main_app/profile.php");
    exit();
}else if(isset($_POST["changeAddressBTN"]) && $_POST["address"] !== $kuAdress["KuPLZOrt"]){
    $newAddress = $_POST["address"];
    $userID = $_SESSION["kuid"];

    updatePLZOrt($conn, $userID, $newAddress);

    redirectTo("../main_app/profile.php");
    exit();
}else if(isset($_POST["changeCountryBTN"]) && $_POST["country"] !== $kuAdress["KuLand"]){
    $newCountry = $_POST["country"];
    $userID = $_SESSION["kuid"];

    updateCountry($conn, $userID, $newCountry);

    redirectTo("../main_app/profile.php");
    exit();
}else{
    redirectTo("../main_app/profile.php?error=NoValidInput");
    exit();
}

?>