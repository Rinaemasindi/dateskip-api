<?php
class UserPreferences extends Database
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

    function getUserPreferences($id) {
        $sql = "SELECT * FROM UserPreferences where UserID = ?";
        return $this->conn->execute_query($sql, [$id])->fetch_assoc();
    }
    
    public function updateUserPrefences($userID, $data)
    {
        $sql = "UPDATE UserPreferences SET PreferredGender = ? , MinAge = ?, MaxAge = ?, LocationRadius = ? WHERE UserID = ?";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([$data['preferredGender'], $data['minAge'], $data['maxAge'], $data['locationRadius'], $userID]);
    }

}