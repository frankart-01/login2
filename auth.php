<!DOCTYPE html>
<html>
<head>
    <title>Authentication Page</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>

<div class="container mt-5">
    <div class="row">
        <div class="col-md-6">
            <h2>Authentication</h2>
            <?php
        // Assuming you have a file for database connection (connect.php)
require_once 'connect.php';

session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get user input
    $enteredPin = $_POST['pin'];

    // Establish a database connection
    require_once 'connect.php';

    // Check if the entered PIN is correct
    $checkPinQuery = "SELECT * FROM pins WHERE pin_value = '$enteredPin'";

    if ($connection) {
        $result = $connection->query($checkPinQuery);

        if ($result->num_rows > 0) {
           
            // Redirect to the dashboard
            header("Location: dashboard.php");
            exit;
        } else {
            echo '<div class="alert alert-danger">Invalid PIN. Please try again.</div>';
        }
    } else {
        echo '<div class="alert alert-danger">Database connection error.</div>';
    }
}

            // Fetch the user's mobile number from the database
            $fetchMobileNumberQuery = "SELECT telephone FROM users WHERE user_id = '$_SESSION[user_id]'";
            $mobileNumberResult = $connection->query($fetchMobileNumberQuery);

            if ($mobileNumberResult->num_rows > 0) {
                $user = $mobileNumberResult->fetch_assoc();
                $mobileNumber = $user['telephone'];

                echo '<div class="mb-3">';
                echo '<label for="confirmMobile" class="form-label">Is this your mobile number?</label>';
                echo '<input type="text" class="form-control" id="confirmMobile" value="' . $mobileNumber . '" readonly>';
                echo '</div>';

                echo '<button type="button" class="btn btn-success" id="sendPinBtn">Send PIN</button>';
            } else {
                echo '<div class="alert alert-danger">Error fetching user details.</div>';
            }
            ?>
            <form method="post">
                <div class="mb-3">
                    <label for="pin" class="form-label">Enter PIN</label>
                    <input type="text" autocomplete="off" class="form-control" name="pin" maxlength="6" required>
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>
</div>

<script>
// JavaScript to handle sending PIN when the button is clicked
document.getElementById('sendPinBtn').addEventListener('click', function() {
    var confirmation = confirm("Is the above mobile number correct?");
    if (confirmation) {
        // Fetch the mobile number and send the PIN
        var mobileNumber = document.getElementById('confirmMobile').value;
        sendPinToMobile(mobileNumber);
    } else {
        // Allow the user to edit the mobile number manually
        var newMobileNumber = prompt("Please enter your mobile number:");
        if (newMobileNumber !== null) {
            sendPinToMobile(newMobileNumber);
        }
    }
});

function sendPinToMobile(mobileNumber) {
    // Your PIN-sending code
    // ...

    // For demonstration purposes, let's assume the PIN-sending code is in 'send_pin.php'
    var xhr = new XMLHttpRequest();
    xhr.open("POST", "send_pin.php", true);
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhr.send("mobileNumber=" + mobileNumber + "& message = Your authentication PIN is: 123456"); // Replace '123456' with the actual PIN
}
</script>

</body>
</html>
