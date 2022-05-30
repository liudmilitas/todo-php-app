<?php
session_start();

require_once __DIR__ . "/../classes/Database.php";

$success = false;

if (isset($_POST["username"]) && isset($_POST["password"])) {

    $username = $_POST["username"];
    $password = $_POST["password"];

    $db = new Database();

    $user = $db->get_user_by_username($username);

    if ($user) {
        $success = $user->test_password($password);

        // Check if the password is correct

        if ($success) {
            $_SESSION["logged_in"] = true;
            $_SESSION["user"] = $user;
        }
    }
} else {
    echo "Invalid input";
    var_dump($_POST);
    die();
}


if ($success) {
    header("Location: /todo-php-app");
} else {
    echo "Login failed";
}
