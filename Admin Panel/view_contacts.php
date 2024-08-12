<?php
// Enable error reporting for debugging purposes
error_reporting(E_ALL);
ini_set('display_errors', 1);

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
} else {
    echo "Connected to the database successfully.<br>";
}

// Query to fetch contact messages
$sql = "SELECT id, name, email, message, `timestamp` FROM contacts ORDER BY `timestamp` DESC";
$result = $conn->query($sql);

// Check if the query executed successfully
if (!$result) {
    die("Query failed: " . $conn->error);
} else {
    echo "Query executed successfully.<br>";
}

// Check if there are any records
if ($result->num_rows > 0) {
    echo "<h2>Contact Messages</h2>";
    echo "<table border='1' cellpadding='10' cellspacing='0' style='border-collapse: collapse; width: 100%;'>";
    echo "<tr style='background-color: #f2f2f2;'>
            <th>ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>Message</th>
            <th>Timestamp</th>
          </tr>";

    // Loop through each record and display it in a table row
    while ($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>" . htmlspecialchars($row['id']) . "</td>
                <td>" . htmlspecialchars($row['name']) . "</td>
                <td>" . htmlspecialchars($row['email']) . "</td>
                <td>" . nl2br(htmlspecialchars($row['message'])) . "</td>
                <td>" . htmlspecialchars($row['timestamp']) . "</td>
              </tr>";
    }
    
    echo "</table>";
} else {
    echo "<p>No contact messages found.</p>";
}

// Close the database connection
$conn->close();
?>
