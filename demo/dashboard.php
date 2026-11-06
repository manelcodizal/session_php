<?php
session_start();

// Check kung nakalogin ang user
if (!isset($_SESSION['user_id'])) {
    header("Location: session_demo.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
</head>
<body>

    <h1>
        <?= htmlspecialchars($_SESSION['username']) ?>
    </h1>

    <a href="logout.php">Logout</a>

</body>
</html>
