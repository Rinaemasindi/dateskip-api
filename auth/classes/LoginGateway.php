<?php

class LoginGateway extends Database
{
    protected $conn;
    protected $database;

    public function __construct()
    {
        $db = Database::instance();
        $this->conn = $db->connect();

        $db_name = $db->name();
        $this->database = $db_name;
    }

    function userExists($username,$email)
    {
        $sql = "SELECT * FROM users WHERE username=? OR email=?";

        // Create a prepared statement
        if ($stmt = $this->conn->prepare($sql)) {

            $stmt->bind_param("ss", $username, $email);

            // Execute the prepared statement
            $stmt->execute();

            // Get the result
            $result = $stmt->get_result();

            return $result->num_rows > 0 ? true : false;
        }
    }

    function getUser($username,$email)
    {
        $sql = "SELECT * FROM users WHERE username=? OR email=?";

        // Create a prepared statement
        if ($stmt = $this->conn->prepare($sql)) {

            $stmt->bind_param("ss", $username, $email);

            // Execute the prepared statement
            $stmt->execute();

            // Get the result
            $result = $stmt->get_result();

            return $result;
        }
    }
}