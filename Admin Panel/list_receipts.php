<?php
$servername = "sql107.infinityfree.com";
$username = "if0_37049035";
$password = "VVMuGUawW0Bl9Q";
$dbname = "if0_37049035_test";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch all receipts
$sql = "SELECT first_name, last_name, email, contact, details, payment_id FROM receipts";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "<h2>Receipt List</h2>";
    echo "<table border='1' cellpadding='10' style='width: 100%; border-collapse: collapse;'>";
    echo "<tr style='background-color: #f2f2f2;'><th>No.</th><th>Name</th><th>Email</th><th>Contact</th><th>Details</th><th>Action</th></tr>";

    $count = 1;
    while($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $count++ . "</td>";
        echo "<td><strong>" . htmlspecialchars($row['first_name']) . " " . htmlspecialchars($row['last_name']) . "</strong></td>";
        echo "<td>" . htmlspecialchars($row['email']) . "</td>";
        echo "<td>" . htmlspecialchars($row['contact']) . "</td>";
        echo "<td>" . htmlspecialchars($row['details']) . "</td>";
        echo "<td><a href='view_receipt.php?payment_id=" . htmlspecialchars($row['payment_id']) . "' title='View detailed receipt information' style='color: blue; text-decoration: underline;'>View Details</a></td>";
        echo "</tr>";
    }

    echo "</table>";
} else {
    echo "<p>No receipts found.</p>";
}

$conn->close();
?>

<style>
    body {
        font-family: Arial, sans-serif;
        background-color: #f4f4f4;
        color: #333;
        margin: 0;
        padding: 20px;
    }

    h2 {
        color: #333;
    }

    table {
        background-color: white;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

    table th, table td {
        padding: 15px;
        text-align: left;
    }

    table tr:hover {
        background-color: #f9f9f9;
    }

    a {
        text-decoration: none;
        color: blue;
        transition: color 0.3s ease;
    }

    a:hover {
        color: darkblue;
    }
</style>
