<?php

include 'database3.php';

$searchName = '';
$result = [];

if (isset($_POST['search'])) {
    $searchName = $_POST['searchName'];
    list($firstName, $lastName) = explode(' ', $searchName, 2);
    $query = "SELECT * FROM BOOKING_INFO WHERE FNAME LIKE '%$firstName%' AND LNAME LIKE '%$lastName%'";
    $result = $conn->query($query);
} else {
    $result = $conn->query("SELECT * FROM BOOKING_INFO");
}

// cancellation
if (isset($_POST['cancel'])) {
    $customerId = $_POST['customer_id'];
    $deleteQuery = "DELETE FROM BOOKING_INFO WHERE CUSTOMER_ID = ?";
    $stmt = $conn->prepare($deleteQuery);
    $stmt->bind_param("i", $customerId);
    $stmt->execute();
    $stmt->close();
    // Redirect refresh 
    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}

// edits
if (isset($_POST['save'])) {
    $customerId = $_POST['customer_id'];
    $departureDate = $_POST['departure_date'];
    $destination = $_POST['destination'];

    $updateQuery = "UPDATE BOOKING_INFO SET DEPARTURE_DATE = ?, DESTINATION_COUNTRY = ? WHERE CUSTOMER_ID = ?";
    $stmt = $conn->prepare($updateQuery);
    $stmt->bind_param("ssi", $departureDate, $destination, $customerId);
    $stmt->execute();
    $stmt->close();
    // Redirect refresh 
    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ZLINE AIRLINES - Reservations</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <style>
        * {
            box-sizing: border-box;
        }
        body {
            background-image: url('background.png');
            background-size: cover;
            background-repeat: no-repeat;
            background-attachment: fixed;
            font-family: 'Poppins', sans-serif;
            color: #fff;
            margin: 0;
            padding: 0;
            overflow-x: hidden;
        }
        h1 {
            text-align: center;
            margin-top: 40px;
            color: #fff;
        }
        .back-button {
            position: absolute;
            top: 20px;
            right: 20px;
            padding: 10px 20px;
            background-color: #ff699e; 
            border: none;
            border-radius: 5px;
            color: white;
            cursor: pointer;
        }
        .search-container {
            text-align: center;
            margin-top: 20px;
        }
        .search-container input {
            padding: 10px;
            font-size: 16px;
        }
        .search-container button {
            padding: 10px 20px;
            background-color: #ff699e; 
            border: none;
            border-radius: 5px;
            color: white;
            cursor: pointer;
        }
        table {
            width: 80%;
            margin: 40px auto;
            border-collapse: collapse;
            background: rgba(255, 255, 255, 0.1);
        }
        th, td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #fff;
        }
        th {
            background-color: rgba(255, 255, 255, 0.2);
        }
        .button-container {
            text-align: center;
            margin: 20px 0;
        }
        .button-container button,
        .edit-button,
        .cancel-button {
            padding: 5px 10px; /* Smaller size for the buttons */
            background-color: #ff699e; 
            border: none;
            border-radius: 5px;
            color: white;
            cursor: pointer;
            margin: 0 5px; /* Reduced margin */
        }
        .edit-panel {
            display: none;
            text-align: center;
            margin: 20px auto;
            padding: 10px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 5px;
        }
        .edit-panel input {
            padding: 5px;
            margin: 5px;
            border: none;
            border-radius: 5px;
        }
        .edit-panel button {
            padding: 5px 10px; /* Same size as the table buttons */
            background-color: #ff699e; 
            border: none;
            border-radius: 5px;
            color: white;
            cursor: pointer;
            margin: 5px; /* Margin for spacing */
        }
    </style>
</head>
<body>

    <button class="back-button" onclick="window.location.href='main.php'">Back</button>
    <h1>ZLINE AIRLINES</h1>

    <div class="search-container">
        <form method="POST" action="">
            <input type="text" name="searchName" placeholder="Search Name" required value="<?php echo htmlspecialchars($searchName); ?>">
            <button type="submit" name="search">Search</button>
        </form>
    </div>

    <table>
        <thead>
            <tr>
                <th>Customer ID</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Contact Number</th>
                <th>Email</th>
                <th>Departure Date</th>
                <th>Destination</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($result && $result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>
                            <td>{$row['CUSTOMER_ID']}</td>
                            <td>{$row['FNAME']}</td>
                            <td>{$row['LNAME']}</td>
                            <td>{$row['CONTACT_NUM']}</td>
                            <td>{$row['EMAIL']}</td>
                            <td>{$row['DEPARTURE_DATE']}</td>
                            <td>{$row['DESTINATION_COUNTRY']}</td>
                            <td>
                                <button class='edit-button' onclick='showEditPanel({$row['CUSTOMER_ID']}, \"{$row['DEPARTURE_DATE']}\", \"{$row['DESTINATION_COUNTRY']}\")'>Edit</button>
                                <button class='cancel-button' onclick='confirmCancel({$row['CUSTOMER_ID']})'>Cancel</button>
                            </td>
                        </tr>";
                }
            } else {
                echo "<tr><td colspan='8'>No reservations found.</td></tr>";
            }
            ?>
        </tbody>
    </table>

    <div class="edit-panel" id="editPanel">
        <h3>Edit Reservation</h3>
        <form id="editForm" method="POST" action="">
            <input type="hidden" name="customer_id" id="editCustomerId">
            <label for="editDepartureDate">Departure Date:</label>
            <input type="date" name="departure_date" id="editDepartureDate" required>
            <label for="editDestination">Destination:</label>
            <input type="text" name="destination" id="editDestination" required>
            <button type="submit" name="save">Save</button>
            <button type="button" onclick="closeEditPanel()">Cancel</button>
        </form>
    </div>

    <script>
        function showEditPanel(customerId, departureDate, destination) {
            document.getElementById('editCustomerId').value = customerId;
            document.getElementById('editDepartureDate').value = departureDate;
            document.getElementById('editDestination').value = destination;
            document.getElementById('editPanel').style.display = 'block';
        }

        function closeEditPanel() {
            document.getElementById('editPanel').style.display = 'none';
        }

        function confirmCancel(customerId) {
            if (confirm("Are you sure you want to cancel this reservation?")) {
                // Create form cancellation
                const form = document.createElement("form");
                form.method = "POST";
                form.action = "";
                
                const hiddenField = document.createElement("input");
                hiddenField.type = "hidden";
                hiddenField.name = "customer_id";
                hiddenField.value = customerId;

                const cancelField = document.createElement("input");
                cancelField.type = "hidden";
                cancelField.name = "cancel";
                cancelField.value = "true";

                form.appendChild(hiddenField);
                form.appendChild(cancelField);
                document.body.appendChild(form);
                form.submit();
            }
        }
    </script>
</body>
</html>
