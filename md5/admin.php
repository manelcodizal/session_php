<?php
session_start();

// Check login
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Check admin role
if (($_SESSION['role'] ?? '') !== 'admin') {
    http_response_code(403);
    exit("Access denied! Admin only.");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>

    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
      rel="stylesheet">
</head>

<body class="bg-light">

<div class="container mt-5">
    <div class="card shadow">
        <div class="card-body p-4">

            <h2>Admin Dashboard</h2>

            <div class="alert alert-success">
                Welcome,
                <?= htmlspecialchars($_SESSION['username']) ?>!
            </div>

            <p>
                Role:
                <strong>
                    <?= htmlspecialchars($_SESSION['role']) ?>
                </strong>
            </p>

            <p>You have Administrator Access.</p>

            <a href="logout.php"
               class="btn btn-danger">
                Logout
            </a>

        </div>
    </div>
</div>

</body>
</html>
