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

$sql = "SELECT id, username, email, reg_date FROM users ORDER BY reg_date DESC";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "<h2>User List</h2>";
    echo "<input type='text' id='searchInput' onkeyup='searchTable()' placeholder='Search for names or emails...' style='margin-bottom: 20px; padding: 10px; width: 100%; border-radius: 5px;'>";
    echo "<table border='1' cellpadding='10' style='width: 100%; border-collapse: collapse;' id='usersTable'>
            <tr style='background-color: #f2f2f2;'>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Timestamp</th>
            </tr>";
    while($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>" . htmlspecialchars($row["id"]) . "</td>
                <td>" . htmlspecialchars($row["username"]) . "</td>
                <td>" . htmlspecialchars($row["email"]) . "</td>
                <td>" . date("F d Y, H:i:s", strtotime($row["reg_date"])) . "</td>
            </tr>";
    }
    echo "</table>";
} else {
    echo "<p>No users found.</p>";
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

    #searchInput {
        margin-bottom: 20px;
        padding: 10px;
        width: 100%;
        border-radius: 5px;
        border: 1px solid #ccc;
    }

    td[title] {
        position: relative;
        cursor: pointer;
    }

    td[title]:hover::after {
        content: attr(title);
        position: absolute;
        bottom: -1.5em;
        left: 0;
        background-color: #333;
        color: #fff;
        padding: 5px;
        border-radius: 5px;
        white-space: nowrap;
        font-size: 0.8em;
    }
</style>

<script>
    function searchTable() {
        var input, filter, table, tr, td, i, txtValue;
        input = document.getElementById("searchInput");
        filter = input.value.toLowerCase();
        table = document.getElementById("usersTable");
        tr = table.getElementsByTagName("tr");

        for (i = 1; i < tr.length; i++) {
            td = tr[i].getElementsByTagName("td")[1];
            if (td) {
                txtValue = td.textContent || td.innerText;
                if (txtValue.toLowerCase().indexOf(filter) > -1) {
                    tr[i].style.display = "";
                } else {
                    td = tr[i].getElementsByTagName("td")[2]; // Search in email column
                    if (td) {
                        txtValue = td.textContent || td.innerText;
                        if (txtValue.toLowerCase().indexOf(filter) > -1) {
                            tr[i].style.display = "";
                        } else {
                            tr[i].style.display = "none";
                        }
                    }
                }
            }
        }
    }
</script>
