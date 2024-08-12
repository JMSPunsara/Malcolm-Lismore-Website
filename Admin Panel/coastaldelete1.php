<div class="gallery">
    <?php
    // Database connection
    $servername = "sql107.infinityfree.com";
    $username = "if0_37049035";
    $password = "VVMuGUawW0Bl9Q";
    $dbname = "if0_37049035_test";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Display images from the database
    $sql = "SELECT id, filename FROM coastalimages";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $imagePath = htmlspecialchars($row['filename']); // Sanitize the image path
            echo '<div class="gallery-item">';
            echo '<img src="' . $imagePath . '" alt="Uploaded Image" class="image-item" data-caption="Image ' . $row["id"] . '">';
            echo '<form action="coastaldelete.php" method="post">';
            echo '<input type="hidden" name="image_id" value="' . $row["id"] . '">';
            echo '<input type="hidden" name="image_path" value="' . $imagePath . '">';
            echo '<input type="submit" value="Delete" class="delete-btn">';
            echo '</form>';
            echo '</div>';
        }
    } else {
        echo "<p>No images found.</p>";
    }

    $conn->close();
    ?>
</div>

<style>
    .gallery {
        display: flex;
        flex-wrap: wrap;
        gap: 10px; /* Space between images */
        justify-content: space-between;
    }

    .gallery-item {
        width: calc(25% - 10px); /* 25% width for 4 images per row minus gap space */
        box-sizing: border-box;
        position: relative;
    }

    .image-item {
        width: 100%;
        height: auto;
        object-fit: cover; /* Ensure the image covers the entire area */
        border-radius: 8px;
    }

    .delete-btn {
        position: absolute;
        bottom: 5px;
        right: 5px;
        background-color: red;
        color: white;
        border: none;
        padding: 5px 10px;
        cursor: pointer;
        border-radius: 4px;
    }

    .delete-btn:hover {
        background-color: darkred;
    }
</style>
