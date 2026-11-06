<?php
session_start();

session_unset();
session_destroy();

header("Location: session_demo.php");
exit();
?>
