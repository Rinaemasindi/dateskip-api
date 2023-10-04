<?php
class Connections extends Database
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
    // Retrieve user's connections (matches)
    public function getUserConnections($userID)
    {
        $stmt = $this->conn->prepare("SELECT * FROM Connections WHERE (UserID1 = ? OR UserID2 = ?) AND Matched = 1");
        $stmt->execute([$userID, $userID]);
        return $stmt->fetch(); //fetchAll(PDO::FETCH_ASSOC);
    }
    
    // Insert a new connection (match) into the Connections table
    public function createConnection($userID1, $userID2)
    {
        $stmt = $this->conn->prepare("INSERT INTO Connections (UserID1, UserID2, Matched) VALUES (?, ?, 1)");
        $stmt->execute([$userID1, $userID2]);
    }

}