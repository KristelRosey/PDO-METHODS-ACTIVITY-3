<?php
include 'database3.php'; 

// Country list
$countries = [
    "Afghanistan", "Albania", "Algeria", "Andorra", "Angola", "Antigua and Barbuda", "Argentina", "Armenia", "Australia", "Austria", 
    "Azerbaijan", "Bahamas", "Bahrain", "Bangladesh", "Barbados", "Belarus", "Belgium", "Belize", "Benin", "Bhutan", "Bolivia", 
    "Bosnia and Herzegovina", "Botswana", "Brazil", "Brunei", "Bulgaria", "Burkina Faso", "Burundi", "Cabo Verde", "Cambodia", 
    "Cameroon", "Canada", "Central African Republic", "Chad", "Chile", "China", "Colombia", "Comoros", "Congo, Democratic Republic of the", 
    "Congo, Republic of the", "Costa Rica", "Croatia", "Cuba", "Cyprus", "Czech Republic", "Denmark", "Djibouti", "Dominica", 
    "Dominican Republic", "Ecuador", "Egypt", "El Salvador", "Equatorial Guinea", "Eritrea", "Estonia", "Eswatini", "Ethiopia", 
    "Fiji", "Finland", "France", "Gabon", "Gambia", "Georgia", "Germany", "Ghana", "Greece", "Grenada", "Guatemala", "Guinea", 
    "Guinea-Bissau", "Guyana", "Haiti", "Honduras", "Hungary", "Iceland", "India", "Indonesia", "Iran", "Iraq", "Ireland", 
    "Israel", "Italy", "Jamaica", "Japan", "Jordan", "Kazakhstan", "Kenya", "Kiribati", "Korea, North", "Korea, South", "Kosovo", 
    "Kuwait", "Kyrgyzstan", "Laos", "Latvia", "Lebanon", "Lesotho", "Liberia", "Libya", "Liechtenstein", "Lithuania", "Luxembourg", 
    "Madagascar", "Malawi", "Malaysia", "Maldives", "Mali", "Malta", "Marshall Islands", "Mauritania", "Mauritius", "Mexico", 
    "Micronesia", "Moldova", "Monaco", "Mongolia", "Montenegro", "Morocco", "Mozambique", "Myanmar", "Namibia", "Nauru", "Nepal", 
    "Netherlands", "New Zealand", "Nicaragua", "Niger", "Nigeria", "North Macedonia", "Norway", "Oman", "Pakistan", "Palau", 
    "Panama", "Papua New Guinea", "Paraguay", "Peru", "Philippines", "Poland", "Portugal", "Qatar", "Romania", "Russia", "Rwanda", 
    "Saint Kitts and Nevis", "Saint Lucia", "Saint Vincent and the Grenadines", "Samoa", "San Marino", "Sao Tome and Principe", 
    "Saudi Arabia", "Senegal", "Serbia", "Seychelles", "Sierra Leone", "Singapore", "Slovakia", "Slovenia", "Solomon Islands", 
    "Somalia", "South Africa", "South Sudan", "Spain", "Sri Lanka", "Sudan", "Suriname", "Sweden", "Switzerland", "Syria", 
    "Taiwan", "Tajikistan", "Tanzania", "Thailand", "Timor-Leste", "Togo", "Tonga", "Trinidad and Tobago", "Tunisia", "Turkey", 
    "Turkmenistan", "Tuvalu", "Uganda", "Ukraine", "United Arab Emirates", "United Kingdom", "United States", "Uruguay", 
    "Uzbekistan", "Vanuatu", "Vatican City", "Venezuela", "Vietnam", "Yemen", "Zambia", "Zimbabwe"
];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // bind
    $stmt = $conn->prepare("INSERT INTO BOOKING_INFO (FNAME, LNAME, BDATE, CONTACT_NUM, EMAIL, ADDRESS, CITY, REGION, POSTAL, COUNTRY, DEPARTURE_DATE, DEPARTURE_TIME, DEPARTURE_RDATE, DEPARTURE_RTIME, DEPARTURE_COUNTRY, DESTINATION_COUNTRY, FARE) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

    $fare = "ROUND-TRIP"; // Set FARE

    // Bind parameters
    $stmt->bind_param("sssisssssssssssss",
        strtoupper($_POST['fname']),
        strtoupper($_POST['lname']),
        $_POST['bdate'],
        $_POST['contact_num'],
        strtolower($_POST['email']),
        strtoupper($_POST['address']),
        strtoupper($_POST['city']),
        strtoupper($_POST['region']),
        strtoupper($_POST['postal']),
        strtoupper($_POST['country']),
        $_POST['departure_date'],
        $_POST['departure_time'],
        $_POST['departure_rdate'],
        $_POST['departure_rtime'],
        strtoupper($_POST['departure_country']),
        strtoupper($_POST['destination_country']),
        $fare
    );

    if ($stmt->execute()) {
        echo "<script>alert('Booking successful!'); window.location.href='book.php';</script>";
    } else {
        echo "<script>alert('Error: " . $stmt->error . "');</script>";
    }

    $stmt->close();
    $conn->close();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Book a Flight - Zline Airlines</title>
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
            margin-top: 20px;
            font-size: 2em;
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
            font-weight: 600;
            cursor: pointer;
        }
        .back-button:hover {
            background-color: #ff4572;
        }
        .booking-form {
            background-color: rgba(0, 0, 0, 0.8);
            padding: 30px;
            border-radius: 10px;
            max-width: 720px;
            margin: 40px auto;
            color: #fff;
        }
        .booking-form h2 {
            margin-top: 0;
            font-size: 1.8em;
            font-weight: 600;
            text-align: center;
            color: #ff699e;
        }
        .form-group {
            margin-bottom: 15px;
        }
        .form-group label {
            display: block;
            font-weight: 600;
            margin-bottom: 5px;
            color: #ff699e;
        }
        .form-group input, .form-group select {
            width: calc(100% - 16px);
            padding: 10px;
            border-radius: 5px;
            border: none;
            box-sizing: border-box;
            font-size: 1em;
            background-color: #222;
            color: #fff;
            font-family: inherit;
        }
        .form-group input:focus, .form-group select:focus {
            outline: none;
            border: 1px solid #ff699e;
        }
        .form-group button {
            width: 100%;
            padding: 12px;
            border-radius: 5px;
            background-color: #ff699e;
            color: #fff;
            font-size: 1.1em;
            font-weight: 600;
            border: none;
            cursor: pointer;
        }
        .form-group button:hover {
            background-color: #ff4572;
        }
    </style>
    <script>
        function confirmBack() {
            return confirm("Are you sure you want to go back to the main page?");
        }
    </script>
</head>
<body>

<h1>Zline Airlines</h1>

<button class="back-button" onclick="if(confirmBack()) { window.location.href='main.php'; }">Back</button>


<button class="back-button" onclick="if(confirmBack()) { window.location.href='main.php'; }">Back</button>

<div class="booking-form">
    <h2>Book a Flight</h2>
    <form method="post" action="">
        <div class="form-group">
            <label for="fname">First Name</label>
            <input type="text" id="fname" name="fname" onkeyup="this.value = this.value.toUpperCase();" required>
        </div>
        
        <div class="form-group">
            <label for="lname">Last Name</label>
            <input type="text" id="lname" name="lname" onkeyup="this.value = this.value.toUpperCase();" required>
        </div>
        
        <div class="form-group">
            <label for="bdate">Birth Date</label>
            <input type="date" id="bdate" name="bdate" required>
        </div>

        <div class="form-group">
            <label for="contact_num">Contact Number</label>
            <input type="text" id="contact_num" name="contact_num" required>
        </div>

        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" id="email" name="email" required>
        </div>

        <div class="form-group">
            <label for="address">Address</label>
            <input type="text" id="address" name="address" onkeyup="this.value = this.value.toUpperCase();" required>
        </div>

        <div class="form-group">
            <label for="city">City</label>
            <input type="text" id="city" name="city" onkeyup="this.value = this.value.toUpperCase();" required>
        </div>

        <div class="form-group">
            <label for="region">Region</label>
            <input type="text" id="region" name="region" onkeyup="this.value = this.value.toUpperCase();" required>
        </div>

        <div class="form-group">
            <label for="postal">Postal Code</label>
            <input type="text" id="postal" name="postal" required>
        </div>

        <div class="form-group">
            <label for="country">Country</label>
            <select id="country" name="country" required>
                <option value="" disabled selected>Select your country</option>
                <?php foreach ($countries as $country) : ?>
                    <option value="<?php echo $country; ?>"><?php echo $country; ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="form-group">
            <label for="departure_date">Departure Date</label>
            <input type="date" id="departure_date" name="departure_date" required>
        </div>

        <div class="form-group">
            <label for="departure_time">Departure Time</label>
            <input type="time" id="departure_time" name="departure_time" required>
        </div>

        <div class="form-group">
            <label for="departure_rdate">Return Date</label>
            <input type="date" id="departure_rdate" name="departure_rdate" required>
        </div>

        <div class="form-group">
            <label for="departure_rtime">Return Time</label>
            <input type="time" id="departure_rtime" name="departure_rtime" required>
        </div>

        <div class="form-group">
            <label for="departure_country">Departure Country</label>
            <select id="departure_country" name="departure_country" required>
                <option value="" disabled selected>Select Departure Country</option>
                <?php foreach ($countries as $country) : ?>
                    <option value="<?php echo $country; ?>"><?php echo $country; ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="form-group">
            <label for="destination_country">Destination Country</label>
            <select id="destination_country" name="destination_country" required>
                <option value="" disabled selected>Select Destination Country</option>
                <?php foreach ($countries as $country) : ?>
                    <option value="<?php echo $country; ?>"><?php echo $country; ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="form-group">
            <button type="submit">Book Flight</button>
        </div>
    </form>
</div>
</body>
</html>
