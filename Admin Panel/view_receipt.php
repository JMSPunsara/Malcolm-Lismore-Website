<?php
// Directory path to your uploads folder
$uploads_dir = 'uploads';

// Check if the directory exists
if (is_dir($uploads_dir)) {
    // Create an array to hold image files
    $images = [];

    // Open the directory
    if ($handle = opendir($uploads_dir)) {
        // Loop through the directory to get all files
        while (false !== ($file = readdir($handle))) {
            // Skip the current and parent directory references
            if ($file != "." && $file != "..") {
                $file_path = $uploads_dir . '/' . $file;

                // Check if the file is an image
                if (in_array(mime_content_type($file_path), ['image/jpeg', 'image/png', 'image/gif'])) {
                    // Add the image to the array
                    $images[] = [
                        'name' => $file,
                        'path' => $file_path,
                        'time' => filemtime($file_path) // Get the file's last modified time (upload time)
                    ];
                }
            }
        }

        // Sort images by name in ascending order
        usort($images, function($a, $b) {
            return strcmp($a['name'], $b['name']);
        });

        echo "<h1>Uploaded Images</h1>";
        echo "<table border='1' cellpadding='10' style='width: 100%; border-collapse: collapse;'>";
        echo "<tr style='background-color: #f2f2f2;'><th>No.</th><th>Image</th><th>Image Name</th><th>Upload Time</th></tr>";

        // Loop through sorted images and display them in the table
        $count = 1;
        foreach ($images as $image) {
            $file_id = md5($image['name']); // Unique ID based on filename
            $upload_time = date("F d Y, H:i:s", $image['time']); // Format the upload time

            echo "<tr>";
            echo "<td>" . $count++ . "</td>";
            echo "<td><a href='{$image['path']}' target='_blank'><img src='{$image['path']}' alt='{$image['name']}' style='max-width: 100px; height: auto; border-radius: 5px;'></a></td>";
            echo "<td style='cursor: pointer; color: blue;'><a href='{$image['path']}' target='_blank'>{$image['name']}</a></td>";
            echo "<td>$upload_time</td>";
            echo "</tr>";
        }

        echo "</table>";
        // Close the directory
        closedir($handle);
    }
} else {
    echo "<p>The uploads directory does not exist.</p>";
}
?>

<style>
    body {
        font-family: Arial, sans-serif;
        background-color: #f4f4f4;
        color: #333;
        margin: 0;
        padding: 20px;
    }

    h1 {
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
    }

    a:hover {
        text-decoration: underline;
    }

    img {
        transition: transform 0.2s ease;
    }

    img:hover {
        transform: scale(1.1);
    }
</style>
