<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ZLINE AIRLINES</title>
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
            text-align: center;
            color: #fff;
            margin: 0;
            padding: 0;
            overflow-x: hidden;
        }

        h1 {
            font-size: 56px;
            margin-top: 80px;
            color: #fff;
        }

        p.subtitle {
            font-size: 22px;
            font-style: italic;
            color: #fff;
        }

        .button {
            display: inline-block;
            font-size: 24px;
            padding: 15px 30px;
            margin: 20px;
            border: 2px solid #fff;
            border-radius: 50px;
            text-decoration: none;
            color: #fff;
            transition: background-color 0.3s ease, color 0.3s ease;
        }

        .button:hover {
            background-color: #ff699e;
            color: #fff;
        }

        .button-container {
            margin-top: 100px;
        }

        .top-links {
            position: absolute;
            top: 20px;
            width: 100%;
            display: flex;
            justify-content: space-between;
            padding: 0 20px;
            font-size: 18px;
            color: #fff;
        }

        .top-links a {
            color: #fff;
            text-decoration: none;
            cursor: pointer;
        }

        .top-links a:hover {
            text-decoration: underline;
        }

        /* Pop-up and blur effect */
        .popup-bg {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            backdrop-filter: blur(10px);
            justify-content: center;
            align-items: center;
            z-index: 10;
        }

        .popup-content {
            background: #fff;
            color: #333;
            padding: 30px;
            border-radius: 10px;
            width: 80%;
            max-width: 500px;
            text-align: left;
        }

        .popup-content h2 {
            font-size: 28px;
            margin-top: 0;
            color: #ff699e;
        }

        .popup-content p {
            font-size: 16px;
            line-height: 1.6;
        }

        .close-popup {
            cursor: pointer;
            color: #ff699e;
            font-weight: bold;
            font-size: 18px;
        }
    </style>
</head>
<body>

    <!-- Top navigation links -->
    <div class="top-links">
        <a id="aboutLink">About Us</a>
        <a id="contactLink" style="padding-right: 20px;">Contact Us</a>
    </div>

    <!-- Main content -->
    <h1>ZLINE AIRLINES</h1>
    <p class="subtitle">Let's take a <span style="font-weight: bold; font-style: normal;">ZOOM</span> up in the sky</p>

    <!-- Buttons -->
    <div class="button-container">
        <a href="book.php" class="button">Book A Flight</a>
        <a href="reservation.php" class="button">View Reservation</a>
    </div>

    <!-- Pop-up background and content -->
    <div id="popupBg" class="popup-bg">
        <div class="popup-content">
            <span class="close-popup" onclick="closePopup()">×</span>
            <h2 id="popupTitle">About Us</h2>
            <p id="popupText"></p>
        </div>
    </div>

    <script>
        // elements
        const popupBg = document.getElementById('popupBg');
        const popupTitle = document.getElementById('popupTitle');
        const popupText = document.getElementById('popupText');

        // About Us
        document.getElementById('aboutLink').onclick = function() {
            popupTitle.innerText = "About Us";
            popupText.innerHTML = "ZLINE Airlines is dedicated to providing exceptional flight experiences. Our mission is to take you to new heights with comfort and style, ensuring a memorable journey every time.";
            openPopup();
        };

        // Contact Us
        document.getElementById('contactLink').onclick = function() {
            popupTitle.innerText = "Contact Us";
            popupText.innerHTML = `
                <strong>Facebook:</strong> <a href="https://facebook.com/ZLINEAirlines" target="_blank">facebook.com/ZLINEAirlines</a><br>
                <strong>Instagram:</strong> <a href="https://instagram.com/ZLINEAirlines" target="_blank">instagram.com/ZLINEAirlines</a><br>
                <strong>Twitter:</strong> <a href="https://twitter.com/ZLINEAirlines" target="_blank">twitter.com/ZLINEAirlines</a><br>
                <strong>Hotline:</strong> 1-800-ZLINE-00<br>
                <strong>Email:</strong> contact@zlineairlines.com
            `;
            openPopup();
        };

        // blur 
        function openPopup() {
            popupBg.style.display = 'flex';
        }

        // Close 
        function closePopup() {
            popupBg.style.display = 'none';
        }

        // Close outside 
        popupBg.onclick = function(event) {
            if (event.target === popupBg) {
                closePopup();
            }
        };
    </script>
</body>
</html>
