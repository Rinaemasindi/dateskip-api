<?php
class Messages extends Database
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
    // Insert a new message into the Messages table
    public function createMessage($senderID, $receiverID, $messageContent)
    {
        $stmt = $this->conn->prepare("INSERT INTO Messages (SenderID, ReceiverID, MessageContent) VALUES (?, ?, ?)");
        $stmt->execute([$senderID, $receiverID, $messageContent]);
    }

}