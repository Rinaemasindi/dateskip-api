-- Create the Users table
CREATE TABLE Users (
    UserID INT PRIMARY KEY AUTO_INCREMENT,
    Username VARCHAR(50) NOT NULL UNIQUE,
    Email VARCHAR(100) NOT NULL UNIQUE,
    Password VARCHAR(255) NOT NULL,
    Gender ENUM('Male', 'Female', 'Other') NOT NULL,
    Age INT NOT NULL,
    Location VARCHAR(100) NOT NULL,
    ProfilePicture VARCHAR(255),
    Bio TEXT,
    RegistrationDate TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Create the UserPreferences table
CREATE TABLE UserPreferences (
    UserID INT PRIMARY KEY,
    PreferredGender ENUM('Male', 'Female', 'Other') NOT NULL,
    MinAge INT NOT NULL,
    MaxAge INT NOT NULL,
    LocationRadius INT NOT NULL,
    FOREIGN KEY (UserID) REFERENCES Users(UserID)
);

-- Create the Connections table to track matches and connections
CREATE TABLE Connections (
    ConnectionID INT PRIMARY KEY AUTO_INCREMENT,
    UserID1 INT NOT NULL,
    UserID2 INT NOT NULL,
    Matched BOOLEAN DEFAULT FALSE,
    ConnectionDate TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (UserID1) REFERENCES Users(UserID),
    FOREIGN KEY (UserID2) REFERENCES Users(UserID)
);

-- Create the Messages table
CREATE TABLE Messages (
    MessageID INT PRIMARY KEY AUTO_INCREMENT,
    SenderID INT NOT NULL,
    ReceiverID INT NOT NULL,
    MessageContent TEXT NOT NULL,
    Timestamp TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (SenderID) REFERENCES Users(UserID),
    FOREIGN KEY (ReceiverID) REFERENCES Users(UserID)
);

-- Create the Notifications table
CREATE TABLE Notifications (
    NotificationID INT PRIMARY KEY AUTO_INCREMENT,
    UserID INT NOT NULL,
    NotificationType ENUM('Like', 'Message', 'Match', 'Other') NOT NULL,
    Content TEXT,
    Timestamp TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (UserID) REFERENCES Users(UserID)
);

-- Create the ReportedUsers table for moderation
CREATE TABLE ReportedUsers (
    ReportID INT PRIMARY KEY AUTO_INCREMENT,
    ReportingUserID INT NOT NULL,
    ReportedUserID INT NOT NULL,
    ReportReason TEXT,
    ReportDate TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (ReportingUserID) REFERENCES Users(UserID),
    FOREIGN KEY (ReportedUserID) REFERENCES Users(UserID)
);
