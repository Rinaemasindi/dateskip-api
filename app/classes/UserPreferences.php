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

    function getUserPreferences() {
        $sql = "SELECT * FROM UserPreferences";
        $result = $this->conn-> query($sql);
        $result->fetch_all(MYSQLI_ASSOC);
        return $result->free_result();
    }
    
    // Insert user preferences into the UserPreferences table
    public function updateUserPrefences($userID, $preferredGender, $minAge, $maxAge, $locationRadius)
    {
        $sql = "INSERT INTO UserPreferences (UserID, PreferredGender, MinAge, MaxAge, LocationRadius) VALUES (?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$userID, $preferredGender, $minAge, $maxAge, $locationRadius]);
    }

}