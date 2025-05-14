<?php
session_start();
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = $_POST['password'];

    $query = "SELECT * FROM users WHERE username = '$username'";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();

        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            header('Location: index.php');
            exit;
        } else {
            $error = "Invalid username or password!";
        }
    } else {
        $error = "User not found!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1.0" />
  <title>Login</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;500;700&display=swap" rel="stylesheet">
  <style>
    * {
      box-sizing: border-box;
      margin: 0; padding: 0;
    }
    body {
      font-family: 'Poppins', sans-serif;
      background: url("Assets/medic-patient-looking-human-body-analysis.jpg") no-repeat center center fixed;
      background-size: cover;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
      position: relative;
      color: #ffffff;
    }

    body::before {
      content: "";
      position: absolute;
      top: 0; left: 0;
      right: 0; bottom: 0;
      background: rgba(0,0,0,0.5);
      z-index: 0;
    }

    .form-container {
      position: relative;
      background: rgba(255, 255, 255, 0.15);
      padding: 35px 30px;
      border-radius: 15px;
      backdrop-filter: blur(8px);
      box-shadow: 0 8px 24px rgba(0,0,0,0.25);
      width: 340px;
      max-width: 90%;
      text-align: center;
      z-index: 1;
    }

    .form-container h2 {
      margin-bottom: 20px;
      color: #ffffff;
      font-weight: 700;
      text-shadow: 1px 1px 3px rgba(0, 0, 0, 0.5);
      font-size: 24px;
    }

    .form-container .error {
      margin-bottom: 15px;
      color: #ff6b6b;
      font-size: 14px;
      font-weight: 500;
    }

    .form-container input {
      width: 100%;
      padding: 12px 15px;
      margin: 10px 0;
      border: 1px solid #ffffff;
      border-radius: 8px;
      font-size: 15px;
      background: rgba(255, 255, 255, 0.25);
      color: #ffffff;
      backdrop-filter: blur(5px);
    }

    .form-container input::placeholder {
      color: #f0f0f0;
    }

    .form-container input:focus {
      outline: none;
      border-color: #ffffff;
      background: rgba(255, 255, 255, 0.35);
    }

    .form-container button {
      width: 100%;
      padding: 12px;
      margin-top: 15px;
      background: #6d4c41;
      color: white;
      border: none;
      border-radius: 8px;
      font-size: 16px;
      font-weight: 600;
      cursor: pointer;
      transition: background 0.3s ease;
    }

    .form-container button:hover {
      background: #5d4037;
    }

    .form-container p {
      margin-top: 15px;
      font-size: 14px;
      color: #f1f1f1;
    }

    .form-container a {
      color: #ffffff;
      font-weight: 500;
      text-decoration: underline;
    }

    .form-container a:hover {
      text-decoration: underline;
      color: #ffd700;
    }

    @media (max-width: 400px) {
      .form-container {
        padding: 30px 20px;
      }
    }
  </style>
</head>
<body>

  <div class="form-container">
    <h2>Login</h2>

    <?php if (isset($error)) { echo "<p class='error'>" . htmlspecialchars($error) . "</p>"; } ?>

    <form method="POST" novalidate>
      <input type="text" name="username" placeholder="Username" required>
      <input type="password" name="password" placeholder="Password" required>
      <button type="submit">Login</button>
    </form>

    <p>Don't have an account? <a href="register.php">Register here</a></p>
  </div>

</body>
</html>
