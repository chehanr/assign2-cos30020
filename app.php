<?php
if (!isset($_SESSION)) {
    session_start();
}

include_once "db.php";
include_once "auth.php";
include_once "account.php";
include_once "friends.php";
include_once "utils.php";

function destroySession(){
    if (!isset($_SESSION)) {
        session_destroy();
    }
}
?>
