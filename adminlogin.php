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
    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM admins WHERE username='$username'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if (password_verify($password, $row['password'])) {
            echo "<script>
            alert('Login Successfully.');
            window.location.href = 'Admin Panel/adminpanel.html';
          </script>";
            // Redirect to admin dashboard or other secured page
        } else {
            echo "<script>
            alert('Incorrect password!');
            window.location.href = 'adminlogin.html';
          </script>";
        }
    } else {
        echo "<script>
        alert('No user found with this username!');
        window.location.href = 'adminlogin.html';
      </script>";
    }

    $conn->close();
}
?>
