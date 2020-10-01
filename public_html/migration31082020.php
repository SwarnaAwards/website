<?php
require('db.php');

$userTableSql = "CREATE TABLE IF NOT EXISTS userregistration (
    UserName VARCHAR(45) NOT NULL,
    UserMobile VARCHAR(45) NOT NULL, 
    UserEmail VARCHAR(45) NOT NULL,
    UserLocation VARCHAR(45) NOT NULL, 
    AwardCategory VARCHAR(45) NOT NULL,
    UserVideos VARCHAR(700) NOT NULL, 
    UserVideoFileId VARCHAR(50),
    CreateDate DATETIME NOT NULL
    )";

$fileTableSql = "CREATE TABLE IF NOT EXISTS files (
    fileId VARCHAR(50) NOT NULL,
    originalName VARCHAR(500) NOT NULL, 
    filePath VARCHAR(700) NOT NULL,
    createdAt DATETIME NOT NULL, 
    updatedAt DATETIME NOT NULL,
    inUse TINYINT(4) NOT NULL,
    UNIQUE KEY `files_fileId_IDX` (`fileId`) USING BTREE
    )";

$addColumnSql = "ALTER TABLE sline.userregistration ADD COLUMN IF NOT EXISTS UserVideoFileId varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL;";

$updateColumnSql = "alter table sline.userregistration change column UserVideos UserVideos VARCHAR(700)";

if ($conn->query($userTableSql) !== TRUE) {
    die("Error creating table: " . $conn->error);
}

if ($conn->query($fileTableSql) !== TRUE) {
    die("Error creating table: " . $conn->error);
}

if ($conn->query($addColumnSql) !== TRUE) {
    die("Error altering the table" . $conn->error);
}

if ($conn->query($updateColumnSql) !== TRUE) {
    die("Error altering the table" . $conn->error);
}

print("Migration done successfully");

?>
