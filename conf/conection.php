<?php

// Data base connaction
$host = 'localhost';
$dbname = 'education_platform';
$username = 'root';
$password = '';

// Create Connection using MYSQLI
$conn = new mysqli($host, $username, $password, $dbname);

// Check Connection
if ($conn->connect_error) {
    die('Connection fialed :' . $conn->connect_error);
}

// Set charset
$conn->set_charset('utf8');

// Success message
// echo "Connected successfully";