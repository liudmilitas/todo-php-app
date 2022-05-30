<?php

require_once __DIR__ . "/Todo.php";
require_once __DIR__ . "/User.php";


class Database
{
    private $host = "localhost";
    private $user = "root";
    private $password = "1234";
    private $db = "todos-db";

    private $conn;

    public function __construct()
    {

        $this->conn = mysqli_connect($this->host, $this->user, $this->password, $this->db);

        if (!$this->conn) {
            die("Error connection to db!");
        }
    }

    // CREATE TASK

    public function save_task(Todo $todo)
    {
        $query = "INSERT INTO todos (`user_id`, `title`, `date`) VALUES (?, ?, ?)";

        $stmt = mysqli_prepare($this->conn, $query);

        $stmt->bind_param("iss", $todo->user_id, $todo->title, $todo->date);

        $success = $stmt->execute();

        return $success;
    }

    // SHOW ALL TASKS

    public function get_tasks($user_id)
    {
        $query = "SELECT * FROM todos WHERE `user_id`= ?";

        $stmt = mysqli_prepare($this->conn, $query);

        $stmt->bind_param("i", $user_id);

        $stmt->execute();

        $result = $stmt->get_result();

        $db_todos = mysqli_fetch_all($result, MYSQLI_ASSOC);

        $todos = array();

        // Looping through associative array

        foreach ($db_todos as $db_todo) {

            $title = $db_todo["title"];
            $date = $db_todo["date"];
            $user_id = $db_todo["user_id"];
            $id = $db_todo["id"];

            $temp = new Todo($title, $date, $user_id, $id);
            $todos[] = $temp;
        }

        return $todos;
    }

    // SHOW SINGLE TASK

    public function get_task_by_id($id)
    {
        $query = "SELECT * FROM todos WHERE id = ?";

        $stmt = mysqli_prepare($this->conn, $query);

        $stmt->bind_param("i", $id);

        $stmt->execute();

        $result = $stmt->get_result();

        $db_todo = mysqli_fetch_assoc($result);

        $todo = null;

        if ($db_todo) {
            $todo = new Todo($db_todo["title"], $db_todo["date"], $db_todo["user_id"], $id);
        }

        return $todo;
    }

    // EDIT TASK

    public function edit_task(Todo $todo)
    {
        $query = "UPDATE todos SET title = ?, `date` = ? WHERE id = ?";

        $stmt = mysqli_prepare($this->conn, $query);

        $stmt->bind_param("ssi", $todo->title, $todo->date, $todo->id);

        $success = $stmt->execute();

        return $success;
    }

    // DELETE TASK

    public function delete_task($id)
    {
        $query = "DELETE FROM todos WHERE id = ?";

        $stmt = mysqli_prepare($this->conn, $query);

        $stmt->bind_param("i", $id);

        $success = $stmt->execute();

        return $success;
    }

    // CREATE USER

    public function save_user(User $user)
    {
        $query = "INSERT INTO users (username, password_hash) VALUES (?, ?)";

        $stmt = mysqli_prepare($this->conn, $query);

        $username = $user->username;
        // Hashing the password for so we don't keep the actual password in the db
        $password_hash = $user->get_password_hash();

        $stmt->bind_param("ss", $username, $password_hash);

        $success = $stmt->execute();

        return $success;
    }

    // GET USER

    public function get_user_by_username($username)
    {
        $query = "SELECT * FROM users WHERE username = ?";

        $stmt = mysqli_prepare($this->conn, $query);

        $stmt->bind_param("s", $username);

        $stmt->execute();

        $result = $stmt->get_result();

        $db_user = mysqli_fetch_assoc($result);

        $user = null;

        if ($db_user) {
            $user = new User($username, $db_user["id"]);
            $user->set_password_hash($db_user["password_hash"]);
        }

        return $user;
    }
}
