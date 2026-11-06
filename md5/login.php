<?php
session_start();
include 'db_connect.php';

// If already logged in, redirect by role
if (isset($_SESSION['user_id'])) {

    if ($_SESSION['role'] === 'admin') {
        header("Location: admin.php");
    } elseif ($_SESSION['role'] === 'staff') {
        header("Location: staff.php");
    } elseif ($_SESSION['role'] === 'user') {
        header("Location: user.php");
    } else {
        $_SESSION = [];
        session_destroy();
        exit("Invalid session role.");
    }

    exit();
}

$error = "";

// When login form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $username = trim($_POST['username'] ?? '');
    $password = md5($_POST['password'] ?? '');

    // Get account from database
    $stmt = $conn->prepare(
        "SELECT user_id, username, password, role
         FROM users WHERE username = ?"
    );

    $stmt->bind_param("s", $username);
    $stmt->execute();

    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    // Validate account
    if (!$row) {

        $error = "Invalid username!";

    } elseif (!hash_equals($row['password'], $password)) {

        $error = "Invalid password!";

    } else {

        // Successful authentication
        session_regenerate_id(true);

        $_SESSION['user_id'] = $row['user_id'];
        $_SESSION['username'] = $row['username'];
        $_SESSION['role'] = $row['role'];

        // Role-based redirection
        if ($_SESSION['role'] === 'admin') {
            header("Location: admin.php");

        } elseif ($_SESSION['role'] === 'staff') {
            header("Location: staff.php");

        } elseif ($_SESSION['role'] === 'user') {
            header("Location: user.php");

        } else {
            $_SESSION = [];
            session_destroy();
            exit("Invalid account role.");
        }

        exit();
    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Login System</title>

    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
      rel="stylesheet">
</head>

<body class="bg-light">

<div class="container mt-5">

    <div class="row justify-content-center">
        <div class="col-md-5">

            <div class="card shadow">
                <div class="card-body p-4">

                    <h3 class="text-center mb-4">
                        Login Form
                    </h3>

                    <?php if ($error): ?>
                        <div class="alert alert-danger">
                            <?= htmlspecialchars($error) ?>
                        </div>
                    <?php endif; ?>

                    <form method="POST">

                        <div class="mb-3">
                            <label class="form-label">
                                Username
                            </label>

                            <input
                              type="text"
                              name="username"
                              class="form-control"
                              required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">
                                Password
                            </label>

                            <input
                              type="password"
                              name="password"
                              class="form-control"
                              required>
                        </div>

                        <button
                          type="submit"
                          class="btn btn-primary w-100">
                            Login
                        </button>

                    </form>

                </div>
            </div>

        </div>
    </div>

</div>

</body>
</html>
