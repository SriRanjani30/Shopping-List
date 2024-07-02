<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "root@123";
$dbname = "hackclub";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// Process login form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $username = $_POST['username'];
  $password = $_POST['password'];

  // Retrieve hashed password from the database based on the username
  $sql = "SELECT * FROM signup WHERE Username=?";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("s", $username);
  $stmt->execute();
  $result = $stmt->get_result();

  if ($result->num_rows == 1) {
    // Fetch the row and verify the password
    $row = $result->fetch_assoc();
    $hashed_password = $row['Password'];

    // Verify the password using password_verify()
    if (password_verify($password, $hashed_password)) {
      // Valid credentials, redirect to Shopping List.html
      $_SESSION['username'] = $username;
      header("Location: Shopping List - New.html");
      exit();
    } else {
      // Invalid credentials, show an alert
      echo "<script>alert('Invalid credentials');</script>";
    }
  } else {
    // No user found with the given username
    echo "<script>alert('Invalid credentials');</script>";
  }

  // Close statement
  $stmt->close();
}

// Close connection
$conn->close();
?>
