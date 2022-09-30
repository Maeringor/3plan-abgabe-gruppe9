<?php
require_once '../php_scripts/login-checker.php';
require_once '../php_scripts/db-connect.php';
require_once '../php_scripts/neo4jDTL.php';
require_once '../php_scripts/UserDTL.php';
require_once 'globale-functions.php';

    function fetchNotAddedFriends($client, $conn, array $participent_list, int $owner_id) {
        $assoc_list = [];
        $friend_list = getFriends($client, $_SESSION["kuid"]);

        foreach ($friend_list as $friend) {
            if(!in_array($friend, $participent_list) && $friend != $owner_id) {
                $user_result = getUserById($conn, $friend);
                $user = $user_result->fetch_assoc();
                $assoc_list += [$friend => $user["KUname"]];
            }
        }

        return $assoc_list;
    }

?>