<!DOCTYPE html>
<html>
<head>
    <title>Logout</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>

<div class="container mt-5">
    <div class="row">
        <div class="col-md-6">
            <?php
            session_start();

            // Check if the user is logged in
            if (!isset($_SESSION['user_id'])) {
                header("Location: login.php");
                exit;
            }

            if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['confirm_logout'])) {
                // User confirmed the logout, destroy the session
                session_destroy();
                header("Location: login.php");
                exit;
            }
            ?>

            <h2>Logout</h2>
            <p>Are you sure you want to log out?</p>

            <form method="post">
                <button type="submit" name="confirm_logout" class="btn btn-danger">Yes, Log me out</button>
                <a href="dashboard.php" class="btn btn-primary">No, Go back</a>
            </form>
        </div>
    </div>
</div>

</body>
</html>
