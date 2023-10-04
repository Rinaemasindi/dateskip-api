<?php
class Notifications extends Database
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

    // Insert a new notification into the Notifications table
    public function createNotification($userID, $notificationType, $content)
    {
        $stmt = $this->conn->prepare("INSERT INTO Notifications (UserID, NotificationType, Content) VALUES (?, ?, ?)");
        $stmt->execute([$userID, $notificationType, $content]);
    }
}