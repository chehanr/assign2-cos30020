<?php
include_once "app.php";

$db = new DB();
$auth = new Auth($db);
$auth->logout();

if (!$auth->isAuthenticated()) {
    destroySession();
    header('Location: index.php');
} else {
    echo "Error logging out!";
}
?>