<?php 
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Initialize error message
$error_message = "";

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $email = trim($_POST['email']);
    $password = trim($_POST['password']); // Password can be any value for now

    // Validate email ends with .vsu.edu
    if (!preg_match("/@.+\.vsu\.edu$/", $email)) {
        $error_message = "Invalid email. Please use a .vsu.edu email address.";
    } else {
        // If valid, redirect to the status page
        header("Location: status.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Trojan Marketplace - Log In</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background-color: #f5f5f5;
      margin: 0;
      padding: 0;
    }

    .container {
      max-width: 400px;
      margin: 50px auto;
      background: #fff;
      padding: 20px;
      border-radius: 8px;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
      text-align: center;
    }

    h1 {
      font-size: 24px;
      color: #333;
      margin-bottom: 15px;
    }

    p {
      font-size: 14px;
      color: #666;
      margin-bottom: 20px;
    }

    form label {
      display: block;
      text-align: left;
      font-size: 14px;
      margin-bottom: 5px;
      color: #555;
    }

    form input {
      width: 100%;
      padding: 10px;
      margin-bottom: 15px;
      border: 1px solid #ccc;
      border-radius: 5px;
      font-size: 14px;
      box-sizing: border-box;
    }

    form button {
      width: 100%;
      padding: 10px;
      background-color: #e67c00;
      color: #fff;
      border: none;
      border-radius: 5px;
      font-size: 16px;
      cursor: pointer;
      transition: background-color 0.3s ease;
    }

    form button:hover {
      background-color: #0056b3;
    }

    .message {
      font-size: 14px;
      margin-top: 15px;
      color: red;
    }
  </style>
</head>
<body>
  <div class="container">
    <h1>Log In to Trojan Marketplace</h1>
    <p>Please enter your email and password to log in.</p>
    <form action="login.php" method="POST">
      <label for="email">Email</label>
      <input type="email" id="email" name="email" placeholder="you@company.com" required>

      <label for="password">Password</label>
      <input type="password" id="password" name="password" placeholder="Password" required>

      <button type="submit">Log In</button>
    </form>

    <!-- Display error message -->
    <?php if (!empty($error_message)) : ?>
      <p class="message"><?php echo $error_message; ?></p>
    <?php endif; ?>
  </div>
</body>
</html>