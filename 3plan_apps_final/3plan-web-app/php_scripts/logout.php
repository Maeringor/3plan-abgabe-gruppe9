<?php
session_start();
require_once 'globale-functions.php';

// exit a session and destroy vars
if(session_destroy()) {
    redirectTo("../index.html");
}else {
    redirectTo("../index.html?error=NoSessionToLogoutFrom");
}