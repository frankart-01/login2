<!DOCTYPE html>
<html>
<head>
    <title>Login Page</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>

<div class="container mt-5">
    <div class="row">
        <div class="col-md-6">
            <h2>Login</h2>
            <?php
            // Start a PHP session
            session_start();
            
            // Establish a database connection
            require_once 'connect.php';

            // Check if the user is already logged in
            if (isset($_SESSION['user_id'])) {
                header("Location:auth.php");
                exit;
            }

            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                // Check if the necessary keys are set in the $_POST array
                if (isset($_POST['email']) && isset($_POST['password']) && isset($_POST['telephone'])) {
                    // Get user input
                    $email = $_POST['email'];
                    $password = $_POST['password'];
                    $telephone = $_POST['telephone'];

                    // Validate and sanitize user input to prevent SQL injection
                    $email = mysqli_real_escape_string($connection, $email);
                    $password = mysqli_real_escape_string($connection, $password);
                    $telephone = mysqli_real_escape_string($connection, $telephone);

                    $sql = "SELECT * FROM users WHERE email = '$email' AND password = '$password' AND telephone = '$telephone'";
                    $result = $connection->query($sql);

                    if ($result->num_rows > 0) {
                        // Valid login, start a session
                        $user = $result->fetch_assoc();
                        $_SESSION['user_id'] = $user['user_id'];
                        header("Location: auth.php");
                        exit;
                    } else {
                        echo '<div class="alert alert-danger">Invalid credentials. Please try again.</div>';
                    }
                } else {
                    echo '<div class="alert alert-danger" id="error-msg">Incomplete form submission. Please fill in all fields.</div>';
                    echo '<script>
                            setTimeout(function(){
                                document.getElementById("error-msg").style.display = "none";
                            }, 2000);
                          </script>';
                }

                // Close the database connection after use
                $connection->close();
            }
            ?>
            <form method="post">
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" name="email" required>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" name="password" required>
                </div>
                <div class="mb-3">
                    <label for="telephone" class="form-label">Telephone</label>
                    <input type="tel" class="form-control" name="telephone" required>
                </div>
                <button type="submit" class="btn btn-primary">Login</button>
            </form>
            <p class="mt-3">Don't have an account? <a href="signup.php">Sign up</a></p>
        </div>
    </div>
</div>

</body>
</html>
