<?php
session_start();

// Check login
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Check user role
if (($_SESSION['role'] ?? '') !== 'user') {
    http_response_code(403);
    exit("Access denied! Users only.");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>User Dashboard</title>

    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
      rel="stylesheet">
</head>

<body class="bg-light">

<div class="container mt-5">
    <div class="card shadow">
        <div class="card-body p-4">

            <h2>User Dashboard</h2>

            <div class="alert alert-info">
                Welcome,
                <?= htmlspecialchars($_SESSION['username']) ?>!
            </div>

            <p>
                Role:
                <strong>
                    <?= htmlspecialchars($_SESSION['role']) ?>
                </strong>
            </p>

            <p>You have Regular User Access.</p>

            <a href="logout.php"
               class="btn btn-danger">
                Logout
            </a>

        </div>
    </div>
</div>

</body>
</html>
