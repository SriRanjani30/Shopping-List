<?php
// Replace 'your_password' with the actual root password
$conn = new mysqli('localhost', 'root', 'root@123', 'hackclub');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get the form data
$username = $_POST['username'];
$email = $_POST['email'];
$password = password_hash($_POST['password'], PASSWORD_BCRYPT);

// Insert the user data into the database
$sql = "INSERT INTO signup (Username, Email, Password) VALUES ('$username', '$email', '$password')";
if ($conn->query($sql) === TRUE) {
    echo "Signup successful!";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>
