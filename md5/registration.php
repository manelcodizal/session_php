<?php
include 'db_connect.php';

$error = "";
$success = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';

    // Public registrations are regular users
    $role = "user";

    // Validate form
    if ($username === '' || $password === '' || $confirm_password === '') {

        $error = "All fields are required!";

    } elseif ($password !== $confirm_password) {

        $error = "Passwords do not match!";

    } else {

        // Check if username already exists
        $stmt = $conn->prepare(
            "SELECT user_id FROM users WHERE username = ?"
        );

        $stmt->bind_param("s", $username);
        $stmt->execute();

        $result = $stmt->get_result();

        if ($result->num_rows > 0) {

            $error = "Username already exists!";

        } else {

            // MD5 for classroom demonstration only
            $hashed_password = md5($password);

            /*if hash password naman
            $hashed_password = password_hash(
                $password,
                PASSWORD_DEFAULT
            );*/

            // Insert new account
            $insert = $conn->prepare(
                "INSERT INTO users (username, password, role)
                 VALUES (?, ?, ?)"
            );

            $insert->bind_param(
                "sss",
                $username,
                $hashed_password,
                $role
            );

            if ($insert->execute()) {
                $success = "Account registered successfully!";
            } else {
                $error = "Registration failed!";
            }

            $insert->close();
        }

        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Registration</title>

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
                        Register Account
                    </h3>

                    <?php if ($error): ?>
                        <div class="alert alert-danger">
                            <?= htmlspecialchars($error) ?>
                        </div>
                    <?php endif; ?>

                    <?php if ($success): ?>
                        <div class="alert alert-success">
                            <?= htmlspecialchars($success) ?>
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
                              maxlength="50"
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

                        <div class="mb-3">
                            <label class="form-label">
                                Confirm Password
                            </label>

                            <input
                              type="password"
                              name="confirm_password"
                              class="form-control"
                              required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">
                                Role
                            </label>

                            <input
                              type="text"
                              class="form-control"
                              value="User"
                              disabled>
                        </div>

                        <button
                          type="submit"
                          class="btn btn-success w-100">
                            Register
                        </button>

                    </form>

                    <p class="text-center mt-3">
                        Already have an account?
                        <a href="login.php">Login here</a>
                    </p>

                </div>
            </div>

        </div>
    </div>
</div>

</body>
</html>
