<?php
// dao to register an user and add to database

// include db conn and DTL
require_once 'db-connect.php';
require_once 'neo4j-connect.php';
require_once 'neo4jDTL.php';
require_once 'UserDTL.php';
require_once 'UserAdressDTL.php';
require_once 'TokenDTL.php';
require_once 'globale-functions.php';

// check if all inputs are set
if (allInputsSet() && isset($_POST["submit"])) {

    // check if email valid regex
    if (mailValid($_POST["email"])) {
        // check pw and pw repeat are the same
        if (isSamePW($_POST["password"], $_POST["password-repeat"])) {
            // check uname and mail doesnt exist
            if (!userExists($conn, $_POST["username"], $_POST["email"])) {
                // add user
                $hashed_password = password_hash($_POST["password"], PASSWORD_DEFAULT);
                createUser($conn, $_POST["username"], $_POST["fullname"], $_POST["email"], $hashed_password, "");

                // select user id
                $created_user = getUserByUsername($conn, $_POST["username"]);

                $kuid;
                // add user infos to address
                while ($row = $created_user->fetch_assoc()) {
                    $kuid = $row["KUID"];
                }
                createUserAdress($conn, $kuid, $_POST["strnum"], $_POST["addcit"], $_POST["country"]);
                // token anlegen
                $token = formToken($_POST["fullname"]);
                createToken($conn, $kuid, $token);

                // add node with user id to graph db
                createNode($client, $kuid);

                redirectTo("../mail-confirmation.html");
            } else {
                redirectTo("../registration.html?info=userExists");
            }
        } else {
            redirectTo("../registration.html?info=passwordUnequal");
        }
    } else {
        redirectTo("../registration.html?info=invalidMail");
    }
} else {
    redirectTo("../index.html");
}

function allInputsSet()
{
    return isset($_POST["username"]) && !empty($_POST["username"]) && isset($_POST["email"]) && isset($_POST["password"]) && isset($_POST["password-repeat"]) && isset($_POST["fullname"]) && !ctype_space($_POST["fullname"]);
}

function mailValid($email)
{
    return filter_var($email, FILTER_VALIDATE_EMAIL);
}

function isSamePW($pw1, $pw2)
{
    return $pw1 === $pw2;
}

function userExists($conn, $uname, $email)
{
    $result_set_by_uname = getUserByUsername($conn, $uname);
    $result_set_by_email = getUserByEmail($conn, $email);

    return $result_set_by_uname->num_rows !== 0 || $result_set_by_email->num_rows !== 0;
}

function formToken($name): string
{
    return time() . "" . $name;
}