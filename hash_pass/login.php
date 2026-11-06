<?php
session_start();
include 'db_connect.php';

// Redirect if already logged in
if (isset($_SESSION['user_id'])) {

    if ($_SESSION['role'] === 'admin') {
        header("Location: admin.php");
    } else {
        header("Location: user.php");
    }
    exit();
}

$error = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    // Retrieve user from database
    $stmt = $conn->prepare(
        "SELECT user_id, username, password, role
         FROM users
         WHERE username = ?"
    );

    $stmt->bind_param("s", $username);
    $stmt->execute();

    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
/*
    // Check username and password
    if ($row && password_verify($password, $row['password'])) {

        // Prevent session fixation
        session_regenerate_id(true);

        // Create session variables
        $_SESSION['user_id'] = $row['user_id'];
        $_SESSION['username'] = $row['username'];
        $_SESSION['role'] = $row['role'];

        // Redirect based on role
        if ($_SESSION['role'] === 'admin') {
            header("Location: admin.php");
        } else {
            header("Location: user.php");
        }

        exit();

    } else {
        $error = "Invalid username or password!";
    }
*/
    if (!$row) {

        // Username does not exist
        $error = "Invalid username!";

    } elseif (!password_verify($password, $row['password'])) {

        // Username exists, but password is incorrect
        $error = "Invalid password!";

/*di daw toh ideal
    } elseif (!$row && !password_verify($password, $row['password'])) {

        // Both username and password are incorrect
        $error = "Invalid username and password!";
*/
    } else {

        // Successful login
        session_regenerate_id(true);

        $_SESSION['user_id'] = $row['user_id'];
        $_SESSION['username'] = $row['username'];
        $_SESSION['role'] = $row['role'];

        if ($_SESSION['role'] === 'admin') {
            header("Location: admin.php");
        } else {
            header("Location: user.php");
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

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
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

                            <input type="text"
                                   name="username"
                                   class="form-control"
                                   required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">
                                Password
                            </label>

                            <input type="password"
                                   name="password"
                                   class="form-control"
                                   required>
                        </div>

                        <button type="submit"
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
