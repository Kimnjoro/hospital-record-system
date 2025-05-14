<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

if (!isset($_GET['id'])) {
    header('Location: view_patient.php');
    exit;
}

$id = intval($_GET['id']);
$result = $conn->query("SELECT * FROM patients WHERE id = $id");

if ($result->num_rows === 0) {
    header('Location: view_patient.php');
    exit;
}

$patient = $result->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name    = trim($_POST['name']);
    $age     = intval($_POST['age']);
    $gender  = $_POST['gender'];
    $contact = trim($_POST['contact']);
    $address = trim($_POST['address']);
    $patient_condition = trim($_POST['patient_condition']);

    if (empty($name) || empty($age) || empty($gender) || empty($contact) || empty($patient_condition)) {
        $error = "All fields except address are required.";
    } else {
        $stmt = $conn->prepare("UPDATE patients SET name = ?, age = ?, gender = ?, contact = ?, address = ?, patient_condition = ? WHERE id = ?");
        $stmt->bind_param("sissssi", $name, $age, $gender, $contact, $address, $patient_condition, $id);

        if ($stmt->execute()) {
            $_SESSION['success_message'] = 'Patient Updated Successfully!';
            header('Location: view_patient.php');
            exit;
        } else {
            $error = "Database error: " . $conn->error;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Patient</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;500;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: url("Assets/closeup-african-american-practitioner-doctor-hand-analyzing-disease-expertise-writing-medical-treatment-clipboard-therapist-man-working-medicine-prescription-hospital-office.jpg") no-repeat center center fixed;
            background-size: cover;
            margin: 0;
            padding: 0;
            height: 100vh;
            color: #fff;
        }
        .overlay {
            position: absolute;
            top: 0; left: 0; right: 0; bottom: 0;
            background: rgba(0,0,0,0.6);
            z-index: -1;
        }
        .container {
            background: rgba(255, 255, 255, 0.95);
            max-width: 500px;
            margin: 80px auto;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 6px 20px rgba(0,0,0,0.3);
            animation: fadeSlideIn 1s ease forwards;
            color: #333;
        }
        h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #6d4c41;
            font-weight: 700;
            text-shadow: 1px 1px 2px rgba(0,0,0,0.2);
        }
        input, textarea, select {
            width: 100%;
            padding: 12px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 8px;
            font-size: 14px;
            color: #333;
        }
        button {
            background: #6d4c41;
            color: white;
            border: none;
            padding: 12px;
            width: 100%;
            border-radius: 8px;
            font-size: 16px;
            margin-top: 10px;
            cursor: pointer;
            transition: background 0.3s ease;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
        }
        button:hover {
            background: #5d4037;
        }
        .error {
            color: #d32f2f;
            text-align: center;
            margin-bottom: 15px;
            font-size: 14px;
        }
        .success {
            color: #388e3c;
            text-align: center;
            margin-bottom: 15px;
            font-size: 14px;
        }
        a.back-link {
            display: block;
            text-align: center;
            margin-top: 20px;
            color: #6d4c41;
            text-decoration: none;
            font-weight: 500;
        }
        a.back-link:hover {
            text-decoration: underline;
        }
        @keyframes fadeSlideIn {
            0% {
                opacity: 0;
                transform: translateY(20px);
            }
            100% {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</head>
<body>

<div class="overlay"></div>

<div class="container">
    <h2>Edit Patient Details</h2>

    <?php if (!empty($error)): ?>
        <p class="error"><?= htmlspecialchars($error) ?></p>
    <?php endif; ?>

    <?php if (isset($_SESSION['success_message'])): ?>
        <p class="success"><?= htmlspecialchars($_SESSION['success_message']) ?></p>
        <?php unset($_SESSION['success_message']); ?>
    <?php endif; ?>

    <form method="POST" novalidate>
        <input type="text" name="name" value="<?= htmlspecialchars($patient['name']) ?>" placeholder="Patient Name" required>
        <input type="number" name="age" value="<?= $patient['age'] ?>" placeholder="Age" required>
        <select name="gender" required>
            <option value="Male" <?= $patient['gender'] === 'Male' ? 'selected' : '' ?>>Male</option>
            <option value="Female" <?= $patient['gender'] === 'Female' ? 'selected' : '' ?>>Female</option>
            <option value="Other" <?= $patient['gender'] === 'Other' ? 'selected' : '' ?>>Other</option>
        </select>
        <input type="text" name="contact" value="<?= htmlspecialchars($patient['contact']) ?>" placeholder="Contact Number" required>
        <textarea name="address" placeholder="Address"><?= htmlspecialchars($patient['address']) ?></textarea>
        <textarea name="patient_condition" placeholder="Patient Condition" required><?= htmlspecialchars($patient['patient_condition'] ?? '') ?></textarea>
        <button type="submit">Update Patient</button>
    </form>

    <a href="view_patient.php" class="back-link">Back to Patient List</a>
</div>

</body>
</html>
