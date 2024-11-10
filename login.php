<?php
$servername = "localhost";
$username = "root";  // Use your MySQL username
$password = "";      // Use your MySQL password
$dbname = "user_auth";

// Create a connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Query to fetch the hashed password from the database based on the username
    $sql = "SELECT id, password FROM users WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->bind_result($id, $hashed_password);
    $stmt->fetch();

    // Check if username exists and password matches
    if ($hashed_password && password_verify($password, $hashed_password)) {
        echo "Login successful!";
        // Redirect or start session here
        // e.g., session_start(); $_SESSION['user_id'] = $id; header("Location: frontend.html");
    } else {
        echo "Invalid username or password.";
    }

    $stmt->close();
    $conn->close();
}
?>
