<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

// Check if patient ID is provided in the URL
if (isset($_GET['id'])) {
    $patient_id = (int)$_GET['id'];

    // Prepare and execute the delete query
    $stmt = $conn->prepare("DELETE FROM patients WHERE id = ?");
    $stmt->bind_param("i", $patient_id);

    if ($stmt->execute()) {
        header('Location: index.php'); // Redirect to the dashboard after successful deletion
        exit;
    } else {
        $error = "Failed to delete the patient record.";
    }
} else {
    $error = "No patient ID provided.";
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Delete Patient</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;500;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Poppins', sans-serif; background: #f0f2f5; padding: 20px; }
        .form-container { background: white; padding: 20px; border-radius: 8px; max-width: 500px; margin: auto; }
        button { background: #6d4c41; color: white; border: none; padding: 12px; width: 100%; border-radius: 8px; }
        button:hover { background: #5d4037; }
        .error { color: red; margin-bottom: 10px; }
    </style>
</head>
<body>

<div class="form-container">
    <h2>Delete Patient</h2>

    <?php if (!empty($error)): ?>
        <p class="error"><?= htmlspecialchars($error) ?></p>
    <?php else: ?>
        <p>Are you sure you want to delete this patient record?</p>
        <form method="POST">
            <button type="submit">Yes, Delete</button>
        </form>
    <?php endif; ?>

    <a href="index.php" style="display: block; text-align: center; margin-top: 15px;">Back to Dashboard</a>
</div>

</body>
</html>
