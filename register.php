<?php
require 'config.php';
$errors = [];

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['register'])) {
    $fname = trim($_POST['fname']);
    $lname = trim($_POST['lname']);
    $username = trim($_POST['username']);
    $phone = trim($_POST['phone']);
    $birthday = trim($_POST['birthday']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Calculate age
    $birthDate = new DateTime($birthday);
    $today = new DateTime();
    $age = $today->diff($birthDate)->y;

    if ($age < 21) {
        $errors[] = "You must be at least 21 years old to register.";
    }

    // Check if username or phone already exists
    $stmt = $conn->prepare("SELECT userID FROM users WHERE userName = ? OR userPhoneNum = ?");
    $stmt->bind_param("ss", $username, $phone);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $errors[] = "Username or phone number already exists.";
    }

    // Password validation
    if (strlen($password) < 8 || 
        !preg_match('/[A-Z]/', $password) || 
        !preg_match('/[0-9]/', $password) || 
        !preg_match('/[!@#$%^&*(),.?":{}|<>]/', $password)) {
        $errors[] = "Password must be at least 8 characters long, contain an uppercase letter, a number, and a special character.";
    }

    if ($password !== $confirm_password) {
        $errors[] = "Passwords do not match.";
    }

    if (empty($errors)) {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    
        $stmt = $conn->prepare("INSERT INTO users (userFName, userLName, userName, userPhoneNum, userBirthday, userPass) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssss", $fname, $lname, $username, $phone, $birthday, $hashed_password);
    
        if ($stmt->execute()) {
            $stmt->close();
            $conn->close();
            header("Location: index_user.php");
            exit(); // Ensure script stops executing after redirect
        } else {
            $errors[] = "Registration failed: " . $conn->error;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - DRIZZLE</title>
    <link rel="stylesheet" href="css/login-register.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Raleway:wght@500;900&display=swap" rel="stylesheet">
</head>
<body>

    <h1>Register</h1>

    <div class="container">
        <!-- Left side (Illustration) -->
        <div class="illustration"></div>

        <!-- Right side (Form) -->
        <div class="form-container">
            <h3>Create Your Account</h3>
            
            <?php if (!empty($errors)) : ?>
                <div class="error-messages">
                    <?php foreach ($errors as $error) : ?>
                        <p class="error"><?php echo $error; ?></p>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
            
            <form action="register.php" method="post">
                <label for="fname">First Name</label>
                <input type="text" name="fname" id="fname" required>

                <label for="lname">Last Name</label>
                <input type="text" name="lname" id="lname" required>

                <label for="username">Username</label>
                <input type="text" name="username" id="username" required>

                <label for="phone">Phone Number</label>
                <input type="tel" name="phone" id="phone" required pattern="[0-9]{10}" title="Enter a valid 10-digit phone number">

                <label for="birthday">Date of Birth</label>
                <input type="date" name="birthday" id="birthday" required>
                <p id="age-warning" style="color: red; display: none;">You must be at least 21 years old to register.</p>

                <label for="password">Password</label>
                <div class="password-container">
                    <input type="password" name="password" id="password" required>
                    <span class="toggle-password" onclick="togglePassword('password', this)">Show</span>
                </div>
                <p id="password-requirements">Password must be at least 8 characters long, contain an uppercase letter, a number, and a special character.</p>

                <label for="confirm_password">Confirm Password</label>
                <div class="password-container">
                    <input type="password" name="confirm_password" id="confirm_password" required>
                    <span class="toggle-password" onclick="togglePassword('confirm_password', this)">Show</span>
                </div>
                <p id="password-match" style="color: red; display: none;">Passwords do not match.</p>

                <input type="submit" class="form-btn" name="register" value="Register">

                <div class="register-now">
                    <p>Already have an account? <a href="login.php">Login here</a></p>
                </div>
            </form>
        </div>
    </div>

    <script>
        function togglePassword(inputId, toggleBtn) {
            var passwordField = document.getElementById(inputId);
            if (passwordField.type === 'password') {
                passwordField.type = 'text';
                toggleBtn.textContent = 'Hide';
            } else {
                passwordField.type = 'password';
                toggleBtn.textContent = 'Show';
            }
        }

        document.getElementById('password').addEventListener('input', function() {
            let password = this.value;
            let requirements = document.getElementById('password-requirements');
            let regex = /^(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#$%^&*(),.?":{}|<>]).{8,}$/;
            
            if (regex.test(password)) {
                requirements.style.color = 'green';
            } else {
                requirements.style.color = 'red';
            }
        });

        document.getElementById('confirm_password').addEventListener('input', function() {
            let password = document.getElementById('password').value;
            let confirmPassword = this.value;
            let matchText = document.getElementById('password-match');
            
            matchText.style.display = (password !== confirmPassword) ? 'block' : 'none';
        });

        document.getElementById('birthday').addEventListener('change', function() {
            let birthday = new Date(this.value);
            let today = new Date();
            let age = today.getFullYear() - birthday.getFullYear();
            let monthDiff = today.getMonth() - birthday.getMonth();
            if (monthDiff < 0 || (monthDiff === 0 && today.getDate() < birthday.getDate())) {
                age--;
            }
            let warning = document.getElementById('age-warning');
            warning.style.display = (age < 21) ? 'block' : 'none';
        });
    </script>

</body>
</html>

