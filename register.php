<?php
session_start();

$host = 'localhost';
$dbname = 'tea_store';
$user = 'root';
$pass = '';

$conn = new mysqli($host, $user, $pass, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$registration_error_message = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $first_name = $conn->real_escape_string($_POST['first_name']);
    $last_name = $conn->real_escape_string($_POST['last_name']);
    $email = $conn->real_escape_string($_POST['email']);
    $password = $_POST['password']; // Storing the password as plain text
    $confirm_password = $_POST['confirm_password'];

    if ($password !== $confirm_password) {
        $registration_error_message = "Passwords do not match.";
    } else {
        $stmt = $conn->prepare("INSERT INTO users (first_name, last_name, email, password, member_type) VALUES (?, ?, ?, ?, 'Member')");
        $stmt->bind_param("ssss", $first_name, $last_name, $email, $password); // Storing the password as plain text
        if ($stmt->execute()) {
            header("Location: login.php");
            exit();
        } else {
            $registration_error_message = "An account with this email already exists or other registration error.";
        }
        $stmt->close();
    }
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .login-container {
            background: #fff;
            padding: 2rem;
            border-radius: 0.5rem;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        form {
            display: flex;
            flex-direction: column;
        }
        input[type=text],
        input[type=email],
        input[type=password] {
            padding: 0.5rem;
            margin-bottom: 1rem;
            border: 1px solid #ddd;
            border-radius: 0.3rem;
        }
        button {
            padding: 0.5rem;
            background-color: #5cb85c;
            color: white;
            border: none;
            border-radius: 0.3rem;
            cursor: pointer;
        }
        button:hover {
            background-color: #4cae4c;
        }
        a {
            margin-top: 1rem;
            display: inline-block;
            color: #333;
            text-decoration: none;
        }
        .popup {
            display: none; /* Hide the popup by default */
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .popup-content {
            background: #fff;
            padding: 2rem;
            border-radius: 0.5rem;
            text-align: center;
            width: 30%;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .close-btn {
            padding: 0.5rem 1rem;
            background-color: #d9534f;
            color: white;
            border: none;
            border-radius: 0.3rem;
            cursor: pointer;
            margin-top: 1rem;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <form action="register.php" method="post">
            <h2>Register</h2>
            <form action="register.php" method="post">
                <h2>Register</h2>
                <div>
                    <label for="first_name">First Name:</label>
                    <input type="text" id="first_name" name="first_name" required>
                </div>
                <div>   
                    <label for="last_name">Last Name:</label>
                    <input type="text" id="last_name" name="last_name" required>
                </div>
                <div>
                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" required>
                </div>
                <div>
                    <label for="password">Password:</label>
                    <input type="password" id="password" name="password" required>
                </div>
                <div>
                    <label for="confirm_password">Confirm Password:</label>
                    <input type="password" id="confirm_password" name="confirm_password" required>
                </div>
                <button type="submit">Register</button>
                <a href="login.php">Already have an account? Login</a>
            </form>
        </form>
    </div>
    <?php if ($registration_error_message): ?>
    <div class="popup" id="errorPopup">
        <div class="popup-content">
            <p><?php echo $registration_error_message; ?></p>
            <button class="close-btn" onclick="document.getElementById('errorPopup').style.display='none'">Close</button>
        </div>
    </div>
    <script>
        // Show the popup if there is a message
        document.getElementById('errorPopup').style.display = '<?php echo $registration_error_message ? "flex" : "none"; ?>';
    </script>
    <?php endif; ?>
</body>
</html>
