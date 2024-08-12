<?php
// Database connection details
$serverName = "sql107.infinityfree.com";
$username = "if0_37049035";
$password = "VVMuGUawW0Bl9Q";
$database = "if0_37049035_test";

// Establish the connection
$conn = new mysqli($serverName, $username, $password, $database);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data and trim whitespace
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $message = trim($_POST['message']);

    // Validate the form data
    if (empty($name) || empty($email) || empty($message)) {
        die("Please fill in all fields.");
    }

    // Further validation (e.g., email format)
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        die("Invalid email format.");
    }

    // Prepare the SQL query to insert the data
    $stmt = $conn->prepare("INSERT INTO contacts (name, email, message) VALUES (?, ?, ?)");

    if ($stmt === false) {
        die("Prepare failed: " . $conn->error);
    }

    // Bind the parameters
    $stmt->bind_param("sss", $name, $email, $message);

    // Execute the query and check if it was successful
    if ($stmt->execute()) {
                 echo "<script>
                        alert('Thank you for your message! We will get back to you shortly.');
                        window.location.href = 'enquiry.html';
                      </script>";
    } else {
        echo "Error: " . $stmt->error;
    }

    // Free the statement and close the connection
    $stmt->close();
    $conn->close();
}
?>
