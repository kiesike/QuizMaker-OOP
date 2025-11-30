<?php
session_start();
include "functions.php";

$CRUDS = new CRUDS($conn);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    $user = new User();
    $loggedInUser = $user->login($username, $password);

    if ($loggedInUser) {
        $_SESSION['user'] = $loggedInUser['username'];
        header("Location: teacherpage.php");
        exit();
    } else {
        $error = "Invalid username or password.";
    }
}


$type = $_GET['type'] ?? null; // Get the type of user (teacher or student)

if ($type === 'teacher') {
    $view = 'teacher';
} elseif ($type === 'student') {
    $view = 'student';
} else {
    $view = null;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Selection Handler</title>
    <link rel="stylesheet" href="design.css">
</head>
<body>
    <?php if ($view === 'teacher'): ?>

    <form method="POST">
        <h2>Teacher Login</h2>
        <input type="text" name="username" placeholder="Username" required><br>
        <input type="password" name="password" placeholder="Password" required><br>
        <button type="submit">Login</button>

        <?php if (!empty($error)) echo "<p style='color: red;'>$error</p>"; ?>
        <p>Don't have an account? <a href="create_account.php">Create one here</a></p>
    </form>


    
    <?php elseif ($view === 'student'): ?>

        <h2>Enter Your Information</h2>
    <form action="quizform.php" method="POST">
        <label for="firstname">First Name:</label>
        <input type="text" name="firstname" required><br><br>

        <label for="lastname">Last Name:</label>
        <input type="text" name="lastname" required><br><br>

        <label for="quizcode">Quiz Code:</label>
        <input type="text" name="quizcode" required><br><br>

        <button type="submit">Start Quiz</button>
    </form>

    <?php else: ?>
        <h1>Error: Invalid Access</h1>
        <p>Please select your role from the previous page.</p>

    <?php endif; ?>

    <button onclick="window.location.href='homeselection.php';">Back to Home</button>
</body>
</html>