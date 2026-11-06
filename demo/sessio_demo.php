<?php
// initialize session
session_start();

// if nakalogin na, ireredirect ka sa dashboard.php section
if (isset($_SESSION['user_id'])) {
    header("Location: dashboard.php");
    exit;
}

// ito yung data na kunware ay kinuha sa database
// since wala pa tayong setup ng database
$correct_username = "admin";
$correct_password = md5("password");

// mag hahawak ng error
$error = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // ito naman yung ang user mismo ang mag iinput
    // at imamatch mamaya dun sa nakaset natin na credentials
    $username = $_POST['username'];
    $password = md5($_POST['password']);

    // condition to check if match ang input na data
    // sa naka set na data
    if ($username === $correct_username && $password === $correct_password) {

        // para security check
        session_regenerate_id(true);

        // setting up the session name with assigned value
        $_SESSION['user_id'] = 1;
        $_SESSION['username'] = $username;

        header("Location: dashboard.php");
        exit;

    } else {
        $error = "Invalid username or password";
    }
}

// so yan ang backend natin
// ininternal ko nalang para madali pero pwede nyo yan
// gawin na nakahiwalay na file para mas malinis ang code base nyo!
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Session Demo</title>
</head>
<body>

    <h1>Login Form</h1>

    <!-- condition if may error -->
    <?php if ($error): ?>
        <p style="color: red;">
            <?= htmlspecialchars($error) ?>
        </p>
    <?php endif; ?>

    <!-- form -->
    <form method="POST">

        <label>Username:</label><br>
        <input type="text" name="username" required><br>

        <label>Password:</label><br>
        <input type="password" name="password" required><br>

        <button type="submit">Login</button>

    </form>

</body>
</html>
