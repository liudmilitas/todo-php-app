<?php

require_once __DIR__ . "/../classes/User.php";
require_once __DIR__ . "/../classes/Database.php";

session_start();

$success = false;

if (isset($_POST["id"])) {

    $db = new Database();

    $success = $db->delete_task($_POST["id"]);
} else {
    echo "Invalid input";
}

if ($success) {
    header("Location: http://localhost/todo-php-app/");
    die();
} else {
    echo "Delete Task Error";
}
