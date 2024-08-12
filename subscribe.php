<?php
session_start();

$servername = "sql107.infinityfree.com";
$username = "if0_37049035"; // default username for XAMPP
$password = "VVMuGUawW0Bl9Q"; // default password for XAMPP is empty
$dbname = "if0_37049035_test"; // ensure this matches your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];

    // Prepare and bind
    $stmt = $conn->prepare("INSERT INTO subscribers (email) VALUES (?)");
    $stmt->bind_param("s", $email);

    if ($stmt->execute()) {
                echo "<script>
                        alert('Subscribe Successful');
                        window.location.href = 'index.html';
                      </script>";
    } else {
        $_SESSION['message'] = "Error: " . $stmt->error;
    }

    $stmt->close();

    // Redirect to the same page to show the message
    header("Location: index.html");
    exit();
}

$conn->close();
?>



<?php
if (isset($_SESSION['message'])) {
    echo '<div class="message">' . $_SESSION['message'] . '</div>';
    unset($_SESSION['message']);
}
?>

