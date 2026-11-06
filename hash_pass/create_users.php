<?php
include 'db_connect.php';

// Sample accounts
$accounts = [
    ['admin', 'admin123', 'admin'],
    ['student', 'user123', 'user']
];

foreach ($accounts as $account) {

    $username = $account[0];
    $password = password_hash(
        $account[1],
        PASSWORD_DEFAULT
    );
    $role = $account[2];

    $stmt = $conn->prepare(
        "INSERT INTO users (username, password, role)
         VALUES (?, ?, ?)"
    );

    $stmt->bind_param(
        "sss",
        $username,
        $password,
        $role
    );

    if ($stmt->execute()) {
        echo "Account created: " .
             htmlspecialchars($username) . "<br>";
    } else {
        echo "Unable to create account: " .
             htmlspecialchars($username) . "<br>";
    }

    $stmt->close();
}

$conn->close();
?>

