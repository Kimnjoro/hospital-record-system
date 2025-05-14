<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$result = $conn->query("SELECT * FROM patients ORDER BY created_at DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Hospital Dashboard</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
  <style>
    * {
      box-sizing: border-box;
      margin: 0;
      padding: 0;
    }
    body {
      font-family: 'Poppins', sans-serif;
      background: url("Assets/closeup-african-american-practitioner-doctor-hand-analyzing-disease-expertise-writing-medical-treatment-clipboard-therapist-man-working-medicine-prescription-hospital-office.jpg") no-repeat center center fixed;
      background-size: cover;
      min-height: 100vh;
      position: relative;
      padding: 50px 20px;
    }
    /* Dark overlay */
    body::after {
      content: "";
      position: absolute;
      top: 0; left: 0;
      width: 100%; height: 100%;
      background: rgba(0,0,0,0.4);
      z-index: 1;
    }
    .container {
      position: relative;
      z-index: 2;
      background: rgba(255, 255, 255, 0.2);
      border: 1px solid rgba(255, 255, 255, 0.3);
      border-radius: 20px;
      max-width: 1200px;
      margin: 0 auto;
      padding: 40px;
      backdrop-filter: blur(10px);
      box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.3);
    }
    h1 {
      text-align: center;
      font-size: 38px;
      margin-bottom: 30px;
      color: #ffffff;
      font-weight: 700;
      text-shadow: 2px 2px 8px rgba(0,0,0,0.7);
    }
    .button {
      display: inline-block;
      padding: 12px 25px;
      margin: 10px 10px 20px 0;
      font-size: 16px;
      background: rgba(0, 150, 136, 0.85);
      color: #ffffff;
      text-decoration: none;
      border-radius: 10px;
      font-weight: 600;
      box-shadow: 0 4px 10px rgba(0,0,0,0.3);
      transition: background 0.3s;
    }
    .button:hover {
      background: rgba(0, 121, 107, 0.9);
    }
    .logout-btn {
      background: rgba(229, 57, 53, 0.85);
    }
    .logout-btn:hover {
      background: rgba(183, 28, 28, 0.9);
    }
    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 30px;
      border-radius: 12px;
      overflow: hidden;
      background: rgba(255,255,255,0.1);
      box-shadow: 0 4px 12px rgba(0,0,0,0.3);
    }
    th, td {
      padding: 16px 12px;
      text-align: center;
      color: #ffffff;
      font-weight: 600;
      font-size: 17px;
      text-shadow: 1px 1px 4px rgba(0,0,0,0.8);
    }
    th {
      background: rgba(0, 150, 136, 0.8);
    }
    tr:nth-child(even) td {
      background: rgba(255, 255, 255, 0.1);
    }
    a.action-link {
      color: #00e676;
      font-weight: 700;
      text-decoration: none;
      margin: 0 5px;
      text-shadow: 1px 1px 2px rgba(0,0,0,0.7);
      transition: color 0.3s;
    }
    a.action-link:hover {
      color: #00c853;
      text-decoration: underline;
    }
    @media (max-width: 768px) {
      .container {
        padding: 20px;
      }
      table, th, td {
        font-size: 14px;
      }
      h1 {
        font-size: 30px;
      }
    }
  </style>
</head>
<body>

<div class="container">
  <h1>Welcome, <?= htmlspecialchars($_SESSION['username']) ?></h1>

  <a href="add_patient.php" class="button">Add New Patient</a>
  <a href="logout.php" class="button logout-btn">Logout</a>

  <table>
    <thead>
      <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Age</th>
        <th>Gender</th>
        <th>Contact</th>
        <th>Actions</th>
      </tr>
    </thead>
    <tbody>
      <?php while($patient = $result->fetch_assoc()): ?>
        <tr>
          <td><?= $patient['id'] ?></td>
          <td><?= htmlspecialchars($patient['name']) ?></td>
          <td><?= $patient['age'] ?></td>
          <td><?= $patient['gender'] ?></td>
          <td><?= htmlspecialchars($patient['contact_number']) ?></td>
          <td>
            <a href="view_patient.php?id=<?= $patient['id'] ?>" class="action-link">View</a> |
            <a href="edit_patient.php?id=<?= $patient['id'] ?>" class="action-link">Edit</a> | <!-- Added Edit Link -->
            <a href="delete_patient.php?id=<?= $patient['id'] ?>" class="action-link" onclick="return confirm('Are you sure?')">Delete</a>
          </td>
        </tr>
      <?php endwhile; ?>
    </tbody>
  </table>
</div>

</body>
</html>
