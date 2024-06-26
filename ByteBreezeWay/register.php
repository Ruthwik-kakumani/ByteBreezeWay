<?php
// Database configuration
$servername = "localhost";
$username = "u411403068_admin"; // Your database username
$password = "your_password"; // Your database password
$dbname = "u411403068_ByteBreezeWay"; // Your database name

// Create a connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $firstname = $conn->real_escape_string($_POST['firstname']);
    $lastname = $conn->real_escape_string($_POST['lastname']);
    $email = $conn->real_escape_string($_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    // Debug: print input values
    echo "First Name: $firstname<br>";
    echo "Last Name: $lastname<br>";
    echo "Email: $email<br>";

    // Insert data into the database
    $sql = "INSERT INTO users (firstname, lastname, email, password) VALUES ('$firstname', '$lastname', '$email', '$password')";

    if ($conn->query($sql) === TRUE) {
        echo "New record created successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
} else {
    echo "No POST data received.";
}

$conn->close();
?>
