<?php
include("config.php");

$errors = [];

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['login'])) {
    $username = trim($_POST['username']); // Match the input name in the form
    $password = $_POST['password'];

    // Check if the username exists in the store_managers table first
    $stmt = $conn->prepare("SELECT id, password_hash FROM store_managers WHERE LOWER(username) = LOWER(?)");
    if (!$stmt) {
        die("Error in SQL statement: " . $conn->error);
    }

    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        // Admin found, verify password
        $stmt->bind_result($id, $db_password);
        $stmt->fetch();

        if (password_verify($password, $db_password)) { // Secure password verification
            $_SESSION['id'] = $id;
            $_SESSION['role'] = 'admin';
            header("Location: dashboard.php");
            exit();
        } else {
            $errors[] = "Incorrect username or password.";
        }
    } else {
        // If not an admin, check in the users table
        $stmt->close(); // Close previous statement

        $stmt = $conn->prepare("SELECT userID, userPass FROM users WHERE LOWER(userName) = LOWER(?)");
        if (!$stmt) {
            die("Error in SQL statement: " . $conn->error);
        }

        $stmt->bind_param("s", $username);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            // User found, verify password
            $stmt->bind_result($user_id, $hashed_password);
            $stmt->fetch();

            if (password_verify($password, $hashed_password)) { // Secure password check
                $_SESSION['userID'] = $user_id;
                $_SESSION['role'] = 'user';
                header("Location: index_user.php");
                exit();
            } else {
                $errors[] = "Incorrect username or password.";
            }
        } else {
            $errors[] = "Username not found.";
        }
    }

    $stmt->close();
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - DRIZZLE</title>
    <link rel="stylesheet" href="css/login-register.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Raleway:wght@500;900&display=swap" rel="stylesheet">  
</head>
<body>
    <div class="container">
        <div class="illustration">
            <img src="img/logo.png">
        </div>

        <div class="form-container">
            <h3>Login</h3>

            <?php if (!empty($errors)) : ?>
                <div class="error-messages">
                    <?php foreach ($errors as $error) : ?>
                        <p class="error-msg"><?php echo $error; ?></p>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

            <form action="" method="post">
                <label for="username">Username</label>
                <input type="text" name="username" id="username" required placeholder="Enter your username">

                <label for="password">Password</label>
                <div class="password-container">
                    <input type="password" name="password" id="password" required placeholder="Enter your password">
                    <span class="toggle-password" onclick="togglePassword()">Show</span>
                </div>

                <p class="forgot-password"><a href="forgot_password.php">Forgot Password?</a></p>
                <input type="submit" name="login" value="Login" class="form-btn">
                <p class="register-now">Don't have an account? <a href="register.php">Register now</a></p>
            </form>
        </div>
    </div>

    <script>
        function togglePassword() {
            var passwordField = document.getElementById('password');
            var toggleBtn = document.querySelector('.toggle-password');
            if (passwordField.type === 'password') {
                passwordField.type = 'text';
                toggleBtn.textContent = 'Hide';
            } else {
                passwordField.type = 'password';
                toggleBtn.textContent = 'Show';
            }
        }
    </script>

</body>
</html>
