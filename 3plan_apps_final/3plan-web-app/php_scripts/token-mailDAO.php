<?php
// dao to manage the token for mails

// include db conn and DTL
require_once 'db-connect.php';
require_once 'UserDTL.php';
require_once 'TokenDTL.php';
require_once 'globale-functions.php';


// confirm token
if (isConfirmToken()) {
    $user_result = getUserByUsername($conn, $_POST["username"]);
    $user = $user_result->fetch_assoc();
    if (isset($user) && $user["enabled"] === 0) {
        // fetch token
        $token_result = getTokenByUserId($conn, $user["KUID"]);
        $token = $token_result->fetch_assoc();

        if (!isExpiredToken($token["TCreatedAt"])) {
            if ($token["TConfirmed"] === 0) {
                if ($token["Token"] === $_POST["token"]) {
                    updateTokenById($conn, $token["TOID"], $token["Token"] , 1, $token["TSent"]);
                    updateEnable($conn, $user["KUID"], 1);
                    redirectTo("../login.html");
                } else {
                    redirectTo("../mail-confirmation.html?info=wrongToken");
                }
                
            } else {
                redirectTo("../mail-confirmation.html?info=alreadyConfirmed");
            }
        } else {
            redirectTo("../mail-confirmation.html?info=tokenExpired");
        }
        
    } else {
        redirectTo("../mail-confirmation.html?error=noUserFoundOrUserEnabled");
    }
}


// reinit token
if (isResentToken()) {
    $user_result = getUserByUsername($conn, $_POST["username"]);
    $user = $user_result->fetch_assoc();

    if (isset($user)) {

        if ($user["enabled"] === 0) {
            // fetch token
            $token_result = getTokenByUserId($conn, $user["KUID"]);
            if ($token_result->num_rows === 0) {
                
                createToken($conn, $user["KUID"], formToken($user["KName"]));
                redirectTo("../mail-confirmation.html?info=createdToken");

            } else {
                redirectTo("../resend-mail.html?info=tokenExists");
            }
        } else {
            redirectTo("../resend-mail.html?info=userAlreadyActivated");
        }  

    } else {
        redirectTo("../resend-mail.html?error=noUserFound");
    }

}


function isConfirmToken() {
    return isset($_POST["submit-token"]) && !empty($_POST["username"]) && !empty($_POST["token"]);
}

function isExpiredToken($token_timestamp) {
    $date = strtotime($token_timestamp);
    return time() - $date >= 900;
}

function isResentToken() {
    return isset($_POST["submit-resent-token"]) && !empty($_POST["username"]);
}

function formToken($name):string {
    return time()."".$name;
}