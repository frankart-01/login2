<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>

<div class="container mt-5">
    <div class="row">
        <div class="col-md-6">
            <?php
            // Start a PHP session
            session_start();

            // Check if the user is logged in
            if (!isset($_SESSION['user_id'])) {
                header("Location: login.php");
                exit;
            }

            // Assuming you have a database where you store user information
            // You can fetch the user's name based on the user_id from the session
            require_once 'connect.php'; // Include the database connection file

            $user_id = $_SESSION['user_id'];

            $sql = "SELECT name FROM users WHERE user_id = $user_id";
            $result = $connection->query($sql);

            if ($result->num_rows > 0) {
                $user = $result->fetch_assoc();
                $username = $user['name'];
            }

            // Close the database connection
            $connection->close();
            ?>

            <h2>Welcome, <?php echo $username; ?>!</h2>
            <p>Hello, <?php echo $username; ?>. This is your dashboard.</p>
            <a href="logout.php" class="btn btn-danger">Logout</a>
        </div>
    </div>
</div>

</body>
</html>
