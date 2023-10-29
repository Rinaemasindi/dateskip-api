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

    function userExists($email)
    {
        $sql = "SELECT * FROM Users WHERE Email=?";

        // Create a prepared statement
        if ($stmt = $this->conn->prepare($sql)) {

            $stmt->bind_param("s", $email);

            // Execute the prepared statement
            $stmt->execute();

            // Get the result
            $result = $stmt->get_result();

            return $result->num_rows > 0 ? true : false;
        }
    }

    function getUser($email)
    {
        $sql = "SELECT * FROM Users WHERE Email=?";

        // Create a prepared statement
        if ($stmt = $this->conn->prepare($sql)) {

            $stmt->bind_param("s", $email);

            // Execute the prepared statement
            $stmt->execute();

            // Get the result
            $result = $stmt->get_result();

            return $result;
        }
    }
}