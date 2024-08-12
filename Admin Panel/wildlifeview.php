<?php
// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

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

// Fetch images from the database
$sql = "SELECT filename FROM wildlifeimages ORDER BY upload_time DESC";
$result = $conn->query($sql);

// Check for errors in the SQL query
if (!$result) {
    die("Error executing query: " . $conn->error);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Uploaded Wildlife Photography Images</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
            text-align: center;
        }
        h2 {
            color: #333;
            margin-bottom: 20px;
        }
        .image-frame {
            width: 80%; /* Width of the frame */
            margin: 0 auto; /* Center the frame */
            padding: 20px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            position: relative;
        }
        .image-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr); /* 4 images per row */
            gap: 10px; /* Space between images */
        }
        .image-grid img {
            width: 100%;
            height: auto;
            object-fit: cover;
            border-radius: 8px;
            transition: transform 0.3s ease;
        }
        .image-grid img:hover {
            transform: scale(1.05);
        }
    </style>
</head>
<body>

<h2> Wildlife Photography Images</h2>

<div class="image-frame">
    <div class="image-grid">
        <?php
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo '<img src="'.$row['filename'].'" alt="Image">';
            }
        } else {
            echo "<p>No images found</p>";
        }
        ?>
    </div>
</div>

</body>
</html>

<?php
$conn->close();
?>
