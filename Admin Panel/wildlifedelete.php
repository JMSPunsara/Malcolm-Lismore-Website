<?php
// Database connection
$servername = "sql107.infinityfree.com";
$username = "if0_37049035";
$password = "VVMuGUawW0Bl9Q";
$dbname = "if0_37049035_test";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $image_id = $_POST["image_id"];
    $image_path = $_POST["image_path"];

    // Delete the file from the server
    if (file_exists($image_path)) {
        unlink($image_path);
    }

    // Delete the image record from the database
    $stmt = $conn->prepare("DELETE FROM wildlifeimages WHERE id = ?");
    $stmt->bind_param("i", $image_id);
    $stmt->execute();
    $stmt->close();
}

// Redirect back to the index page after deletion
header("Location: wildlifeindex.php");

$conn->close();
?>
