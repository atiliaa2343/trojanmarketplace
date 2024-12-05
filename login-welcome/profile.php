<?php
// Redirect to success page after form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Redirect to the success page
    header("Location: ../home.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Trojan Marketplace</title>
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
      background-color: #cf6700;
    }
  </style>
</head>
<body>
  <div class="container">
    <h1>Welcome to Trojan Marketplace</h1>
    <p>Fill in the rest of your profile below.</p>
    <form method="POST" action="profile.php">
      <label for="email">Email</label>
      <input type="email" id="email" name="email" placeholder="you@company.com" required>

      <label for="username">Username</label>
      <input type="text" id="username" name="username" placeholder="Username" required>

      <label for="password">Password</label>
      <input type="password" id="password" name="password" placeholder="Password" required>

      <button type="submit">Get Started</button>
    </form>
  </div>
</body>
</html>