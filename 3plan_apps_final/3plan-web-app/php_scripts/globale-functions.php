<?php
// functions which can be used everywhere


function redirectTo($url) {
    header("location: ".$url);
    exit();
}