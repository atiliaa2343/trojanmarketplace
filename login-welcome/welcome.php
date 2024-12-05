<?php
// Initialize error and success messages
$error_message = "";
$success_message = "";

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $firstName = trim($_POST['firstName']);
    $lastName = trim($_POST['lastName']);
    $studentId = trim($_POST['studentId']);

    // Validate fields
    if (empty($firstName)) {
        $error_message = "First name is required.";
    } elseif (empty($lastName)) {
        $error_message = "Last name is required.";
    } elseif (empty($studentId)) {
        $error_message = "Student ID is required.";
    } elseif (!preg_match("/^V\d{8}$/", $studentId)) {
        $error_message = "Invalid Student ID format. Use 'V' followed by 8 digits.";
    } else {
        $success_message = "Sign-up successful! Redirecting...";
        // Redirect to the profile page
        header("Location: profile.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Trojan Marketplace - Welcome</title>
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

    .login {
      display: block;
      margin-top: 15px;
      font-size: 14px;
      color: #007bff;
      text-decoration: none;
    }

    .login:hover {
      text-decoration: underline;
      color: #0056b3;
    }

    .message {
      font-size: 14px;
      margin-top: 15px;
    }

    .message.error {
      color: red;
    }

    .message.success {
      color: green;
    }
  </style>
</head>
<body>
  <div class="container">
    <h1>Welcome to Trojan Marketplace</h1>
    <p>We are student-led and trying to provide VSU students with a way to sell their used goods and services.</p>
    <form method="POST" action="welcome.php">
      <label for="firstName">First Name</label>
      <input type="text" id="firstName" name="firstName" placeholder="Your first name" value="<?php echo isset($firstName) ? htmlspecialchars($firstName) : ''; ?>" required>

      <label for="lastName">Last Name</label>
      <input type="text" id="lastName" name="lastName" placeholder="Your last name" value="<?php echo isset($lastName) ? htmlspecialchars($lastName) : ''; ?>" required>

      <label for="studentId">Student ID</label>
      <input type="text" id="studentId" name="studentId" placeholder="V00639485" value="<?php echo isset($studentId) ? htmlspecialchars($studentId) : ''; ?>" required>

      <button type="submit">Sign Up</button>
    </form>

    <!-- Display error or success messages -->
    <?php if (!empty($error_message)) : ?>
      <p class="message error"><?php echo $error_message; ?></p>
    <?php endif; ?>
    <?php if (!empty($success_message)) : ?>
      <p class="message success"><?php echo $success_message; ?></p>
    <?php endif; ?>

    <a href="login.php" class="login">Already have an account? Login</a>
  </div>
</body>
</html>