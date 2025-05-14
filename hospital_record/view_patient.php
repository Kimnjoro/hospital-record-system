<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    // If no valid ID is provided in the URL, redirect to dashboard or another page.
    header('Location: index.php');
    exit;
}

$patient_id = $_GET['id'];

// Prepare the query to get patient details by ID
$stmt = $conn->prepare("SELECT * FROM patients WHERE id = ?");
$stmt->bind_param("i", $patient_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    // If no patient is found with the given ID
    echo "Patient not found!";
    exit;
}

$patient = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>View Patient</title>
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
      max-width: 800px;
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
    .patient-details {
      font-size: 18px;
      margin-bottom: 20px;
      color: #ffffff;
      text-align: left;
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
    @media (max-width: 768px) {
      .container {
        padding: 20px;
      }
      h1 {
        font-size: 30px;
      }
      .patient-details {
        font-size: 16px;
      }
    }
  </style>
</head>
<body>

<div class="container">
  <h1>Patient Details</h1>
  <div class="patient-details">
    <strong>ID:</strong> <?= $patient['id'] ?><br>
    <strong>Name:</strong> <?= htmlspecialchars($patient['name']) ?><br>
    <strong>Age:</strong> <?= $patient['age'] ?><br>
    <strong>Gender:</strong> <?= $patient['gender'] ?><br>
    <strong>Contact:</strong> <?= htmlspecialchars($patient['contact_number']) ?><br>
    <strong>Address:</strong> <?= htmlspecialchars($patient['address']) ?><br>
    <strong>patientcondition:</strong> <?= htmlspecialchars($patient['patient_condition']) ?><br>
    <strong>Created At:</strong> <?= $patient['created_at'] ?><br>
  </div>
  <a href="index.php" class="button">Back to Dashboard</a>
</div>

</body>
</html>
