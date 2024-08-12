<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Landscape Image Gallery Upload</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #fafafa;
            margin: 0;
            padding: 20px;
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        h2 {
            color: #444;
            font-size: 24px;
            margin-bottom: 20px;
            text-align: center;
        }
        .upload-container {
            background-color: #fff;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
            max-width: 400px;
            width: 100%;
            text-align: center;
            margin-bottom: 40px;
            border: 3px dashed #007BFF;
        }
        input[type="file"] {
            margin-bottom: 20px;
            font-size: 16px;
            border: none;
            background-color: #f7f7f7;
            padding: 10px;
            width: 100%;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }
        input[type="file"]:hover {
            background-color: #e0e0e0;
        }
        input[type="submit"], button {
            background-color: #007BFF;
            color: white;
            border: none;
            padding: 12px 24px;
            cursor: pointer;
            font-size: 16px;
            border-radius: 5px;
            transition: background-color 0.3s ease;
            width: 100%;
            margin-top: 10px;
        }
        input[type="submit"]:hover, button:hover {
            background-color: #0056b3;
        }
        button a {
            color: white;
            text-decoration: none;
        }
        .gallery {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 15px;
            width: 100%;
            max-width: 1200px;
        }
        .gallery-item {
            position: relative;
            overflow: hidden;
            border-radius: 12px;
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1);
            cursor: pointer;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .gallery-item img {
            width: 100%;
            height: 150px;
            object-fit: cover;
            border-radius: 12px;
            display: block;
            transition: transform 0.3s ease;
        }
        .gallery-item:hover {
            transform: translateY(-5px);
            box-shadow: 0 12px 24px rgba(0, 0, 0, 0.2);
        }
        .gallery-item:hover img {
            transform: scale(1.05);
        }
        .delete-btn {
            position: absolute;
            top: 10px;
            right: 10px;
            background-color: rgba(163, 15, 39);
            color: white;
            border: none;
            padding: 8px 12px;
            cursor: pointer;
            border-radius: 5px;
            font-size: 14px;
            transition: background-color 0.3s ease;
        }
        .delete-btn:hover {
            background-color: rgba(163, 15, 39);
        }
        /* Modal Styles */
        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.8);
            padding-top: 60px;
        }
        .modal-content {
            margin: auto;
            display: block;
            width: 80%;
            max-width: 700px;
        }
        .modal-content img {
            width: 100%;
            height: auto;
            border-radius: 10px;
        }
        .modal-caption {
            margin: 10px auto;
            text-align: center;
            color: #ccc;
            font-size: 18px;
        }
        .close {
            position: absolute;
            top: 15px;
            right: 35px;
            color: #f1f1f1;
            font-size: 40px;
            font-weight: bold;
            transition: 0.3s;
        }
        .close:hover,
        .close:focus {
            color: #bbb;
            text-decoration: none;
            cursor: pointer;
        }
    </style>
</head>
<body>

<h2>Upload Image</h2>
<div class="upload-container">
    <form action="wildlifeupload.php" method="post" enctype="multipart/form-data">
        <label for="imageToUpload">Select image to upload:</label><br>
        <input type="file" name="imageToUpload" id="imageToUpload"><br>
        <input type="submit" value="Upload Image" name="submit">
        <button type="button" onclick="window.location.href='wildlifeview.php';">View Images</button>
        <button type="button" onclick="window.location.href='wildlifedelete1.php';">Delete Images</button>
    </form>
</div>

<h2>Gallery</h2>
<div class="gallery">
    <?php
    // Database connection
    $servername = "sql107.infinityfree.com";
    $username = "if0_37049035";
    $password = "VVMuGUawW0Bl9QVVMuGUawW0Bl9Q";
    $dbname = "if0_37049035_test";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Display images from the database
    $sql = "SELECT id, filename FROM wildlifeimages";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            echo '<div class="gallery-item">';
            echo '<img src="'.$row["filename"].'" alt="Uploaded Image" class="image-item" data-caption="Image '.$row["id"].'">';
            echo '<form action="wildlifedelete.php" method="post">';
            echo '<input type="hidden" name="image_id" value="'.$row["id"].'">';
            echo '<input type="hidden" name="image_path" value="'.$row["filename"].'">';
            echo '<input type="submit" value="Delete" class="delete-btn">';
            echo '</form>';
            echo '</div>';
        }
    } else {
        echo "No images found.";
    }

    $conn->close();
    ?>
</div>

<!-- The Modal -->
<div id="myModal" class="modal">
    <span class="close">&times;</span>
    <div class="modal-content">
        <img id="modal-image" alt="">
    </div>
    <div id="caption" class="modal-caption"></div>
</div>

<script>
    // Modal script
    const modal = document.getElementById('myModal');
    const modalImg = document.getElementById('modal-image');
    const captionText = document.getElementById('caption');

    document.querySelectorAll('.image-item').forEach(item => {
        item.addEventListener('click', function() {
            modal.style.display = 'block';
            modalImg.src = this.src;
            captionText.innerHTML = this.dataset.caption;
        });
    });

    // Close the modal
    const span = document.getElementsByClassName('close')[0];
    span.onclick = function() {
        modal.style.display = 'none';
    }
</script>

</body>
</html>
