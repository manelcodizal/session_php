<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Check if user is admin
if (($_SESSION['role'] ?? '') !== 'admin') {
    header("Location: user.php");
    exit();
}

$username = $_SESSION['username'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Admin Dashboard</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
          rel="stylesheet">
</head>

<body class="bg-light">

<div class="container mt-5">

    <div class="card shadow">
        <div class="card-body p-4">

            <h2>Admin Dashboard</h2>

            <div class="alert alert-success">
                Welcome,
                <?= htmlspecialchars($username) ?>!
            </div>

            <p>
                Role:
                <strong>
                    <?= htmlspecialchars($_SESSION['role']) ?>
                </strong>
            </p>

            <p>You have admin access.</p>

            <a href="logout.php"
               class="btn btn-danger">
                Logout
            </a>

        </div>
    </div>

</div>

</body>
</html>
