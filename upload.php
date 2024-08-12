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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $firstName = $_POST['first_name'];
    $lastName = $_POST['last_name'];
    $email = $_POST['email'];
    $contact = $_POST['contact'];
    $details = $_POST['details'];
    $paymentId = $_POST['payment_id'];
    $uploadingTime = date("YmdHis");
    $targetDir = "Admin Panel/uploads/";
    $imageFileType = strtolower(pathinfo($_FILES["fileToUpload"]["name"], PATHINFO_EXTENSION));
    $newFileName = $firstName . "_" . $lastName . "_" . $paymentId . "_" . $uploadingTime . "." . $imageFileType;
    $targetFile = $targetDir . $newFileName;
    $uploadOk = 1;

    // Check if file is an image
    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
    if ($check !== false) {
        echo "File is an image - " . $check["mime"] . ".";
        $uploadOk = 1;
    } else {
        echo "<script>
        alert('File is not an image.');
        window.location.href = 'uploadreceipt.html';
      </script>";
    }

    // Check if file already exists
    if (file_exists($targetFile)) {
        echo "<script>
        alert('Sorry, file already exists.');
        window.location.href = 'uploadreceipt.html';
      </script>";
    }

    // Check file size
    if ($_FILES["fileToUpload"]["size"] > 500000) {
        echo "<script>
        alert('Sorry, your file is too large.');
        window.location.href = 'uploadreceipt.html';
      </script>";
    }

    // Allow certain file formats
    if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
        echo "<script>
        alert('Sorry, only JPG, JPEG, PNG & GIF files are allowed.');
        window.location.href = 'uploadreceipt.html';
      </script>";
    }

    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        echo "<script>
        alert('Sorry, your file was not uploaded');
        window.location.href = 'uploadreceipt.html';
      </script>";
    } else {
        // Check for duplicate entry
        $stmt = $conn->prepare("SELECT * FROM receipts WHERE first_name = ? AND last_name = ? AND email = ? AND contact = ? AND details = ? AND payment_id = ?");
        $stmt->bind_param("ssssss", $firstName, $lastName, $email, $contact, $details, $paymentId);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            echo "<script>
            alert('Sorry, a record with the same details already exists..');
            window.location.href = 'uploadreceipt.html';
          </script>";
        } else {
            // if everything is ok, try to upload file
            if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $targetFile)) {
                echo "The file " . htmlspecialchars(basename($newFileName)) . " has been uploaded.";

                // Insert data into database
                $stmt = $conn->prepare("INSERT INTO receipts (first_name, last_name, email, contact, details, payment_id, file_path) VALUES (?, ?, ?, ?, ?, ?, ?)");
                $stmt->bind_param("sssssss", $firstName, $lastName, $email, $contact, $details, $paymentId, $targetFile);

                if ($stmt->execute()) {
                    echo "<script>
                    alert('Record inserted successfully.');
                    window.location.href = 'pricing.html';
                  </script>";
            exit();
                } else {
                    echo "Error: " . $stmt->error;
                }

                $stmt->close();
            } else {
                echo "<script>
                alert('Sorry, there was an error uploading your file.');
                window.location.href = 'uploadreceipt.html';
              </script>";
            }
        }
    }
}

$conn->close();
?>
