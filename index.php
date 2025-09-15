<?php
include('includes/mongodb_api.php');
session_start();

$error_message = ""; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form inputs
    $username = isset($_POST['username']) ? trim($_POST['username']) : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';

    if (!empty($username) && !empty($password)) {
        try {
            $api = getMongoDBAPI();
            $response = $api->login($username, $password);
            
            if ($response['status'] === 200) {
                $data = $response['data'];
                
                // Store user data in session
                $_SESSION['user_id'] = $data['user']['id'];
                $_SESSION['username'] = $data['user']['username'];
                $_SESSION['user_name'] = $data['user']['name'];
                $_SESSION['user_role'] = $data['user']['role'];
                $_SESSION['token'] = $data['token'];

                // Redirect to homepage
                if ($data['user']['role'] === 'admin') {
                    header("Location: admin.html");
                } else {
                    header("Location: homepage.php");
                }
                exit();
            } else {
                $error_message = $response['data']['error'] ?? "❌ Login failed. Please try again.";
            }
        } catch (Exception $e) {
            $error_message = "❌ " . $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Travel Booking</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <!-- Navbar -->
    <nav>
        <div class="logo">Travel Booking</div>
    </nav>

    <!-- Login Form -->
    <form action="" method="post">
        <div>

            <h1>Login</h1>
            <br>

            <input type="text" placeholder="Username" id="username" name="username" required>
            <br>   <br>

            <input type="password" placeholder="Password" id="password" name="password" required>
            <br>  <br>

            <input type="checkbox" name="remember_me"> Remember me
            <br> <br>

            <input type="submit" value="Login" id="submit">
            <br> <br>

            <p>Don't have an account? <a href="register.php" target="_main">Register</a></p>
            <?php if (!empty($error_message)): ?>
                <p class="error-message"><?= htmlspecialchars($error_message); ?></p>
            <?php endif; ?>

        </div>
    </form>

</body>
</html>
