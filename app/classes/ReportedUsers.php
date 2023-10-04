<?php
class ReportedUsers extends Database
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
    // Insert a new report into the ReportedUsers table
    public function createReport($reportingUserID, $reportedUserID, $reportReason)
    {
        $stmt = $this->conn->prepare("INSERT INTO ReportedUsers (ReportingUserID, ReportedUserID, ReportReason) VALUES (?, ?, ?)");
        $stmt->execute([$reportingUserID, $reportedUserID, $reportReason]);
    }

}