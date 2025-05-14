<?php 
session_start();
include 'db.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']);
    $age = (int)$_POST['age'];
    $gender = $_POST['gender'];
    $address = trim($_POST['address']);
    $contact_number = trim($_POST['contact_number']);
    $condition = trim($_POST['condition']);  // New field for condition

    if (!empty($name) && !empty($age) && !empty($gender)) {
        $stmt = $conn->prepare("INSERT INTO patients (name, age, gender, address, contact_number, patient_condition) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sissss", $name, $age, $gender, $address, $contact_number, $condition); // Added condition parameter
        $stmt->execute();
        header('Location: index.php');
        exit;
    } else {
        $error = "Please fill in all required fields.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Patient</title>
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
    <h2>Add New Patient</h2>

    <?php if (!empty($error)): ?>
        <p class="error"><?= htmlspecialchars($error) ?></p>
    <?php endif; ?>

    <form method="POST">
        <input type="text" name="name" placeholder="Full Name" required>
        <input type="number" name="age" placeholder="Age" required>
        <select name="gender" required>
            <option value="">Select Gender</option>
            <option value="Male">Male</option>
            <option value="Female">Female</option>
            <option value="Other">Other</option>
        </select>
        <textarea name="address" placeholder="Address"></textarea>
        <input type="text" name="contact_number" placeholder="Contact Number">
        <textarea name="condition" placeholder="Condition/Diagnosis (Optional)"></textarea> <!-- Added field for patient condition -->
        <button type="submit">Save Patient</button>
    </form>

    <a href="index.php" class="back-link">Back to Dashboard</a>
</div>

</body>
</html>
