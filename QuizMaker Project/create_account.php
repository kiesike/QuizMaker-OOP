<?php
include "functions.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $username = $_POST['username'];
    $password = $_POST['password'];

    $user = new User();
    $result = $user->createAccount($name, $username, $password);

    if ($result === true) {
        header("Location: homeselection.php");
        exit();
    } else {
        $error = $result; // Capture error message
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Create Account</title>
</head>
<body>
    <h2>Create an Account</h2>
    <form method="POST">

        <input type="text" name="name" placeholder="Full Name" required><br>
        <input type="text" name="username" placeholder="Username" required><br>
        <input type="password" name="password" placeholder="Password" required><br>
        <button type="submit">Create Account</button>
    </form>
    <?php if (!empty($error)) echo "<p style='color: red;'>$error</p>"; ?>
</body>
</html>