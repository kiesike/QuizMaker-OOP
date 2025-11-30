<?php
$quiztype = $_GET['quiztype'] ?? 'multiple_choice';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Enter Code</title>
    <link rel="stylesheet" href="design.css"> 
       
</head>
<body>
    <form action="questions.php" method="GET">
        <input type="hidden" name="quiztype" value="<?= htmlspecialchars($quiztype) ?>">
        <label>Enter Desired Code:</label><br>
        <input style="text-transform: lowercase" type="text" name="code" placeholder="Enter Code" required><br><br>
        <button type="submit">Submit Code</button>
    </form>
</body>
</html>
