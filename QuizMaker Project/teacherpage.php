<?php
if (isset($_GET['type'])) {
    $type = $_GET['type'];

    
    if ($type == 'createquiz') {
        ?>
        <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="design.css">
</head>
<body>


<h1>CHOOSE FROM THESE THREE OPTIONS</h1>
        <form action="Codemaking.php" method="GET">
            <button type="submit" name="quiztype" value="multiple_choice">Multiple Choice</button><br><br>
            <button type="submit" name="quiztype" value="identification">Identification</button><br><br>
            <button type="submit" name="quiztype" value="true_false">True or False</button><br><br>
        </form>

        
        <button onclick="window.location.href='homeselection.php'">Back to Home Selection</button>
    
</body>
</html>

        <?php
    exit;} elseif ($type == 'showquizzes') {
        ?>
        
        <?php
include "database.php"; 


$sql = "SELECT quizzes.id, quizzes.code, quizzes.question, quizzes.answer, 
               quiztypes.name AS quiztype 
        FROM quizzes
        JOIN quiztypes ON quizzes.quiztype_id = quiztypes.id";
$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Show Quizzes</title>
    <link rel="stylesheet" href="design.css">
</head>
<body>
    <h1>All Quizzes</h1>
    
    <form action="teacherpage.php" method="get">
        <button type="submit">Back to Teacher Page</button>
    </form>
    
    <?php
    if ($result->num_rows > 0) {
        echo "<table border='1'>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Quiz Code</th>
                        <th>Question</th>
                        <th>Answer</th>
                        <th>Quiz Type</th>
                    </tr>
                </thead>
                <tbody>";

        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . htmlspecialchars($row['id']) . "</td>";
            echo "<td>" . htmlspecialchars($row['code']) . "</td>";
            echo "<td>" . htmlspecialchars($row['question']) . "</td>";
            echo "<td>" . htmlspecialchars($row['answer']) . "</td>";
            echo "<td>" . htmlspecialchars($row['quiztype']) . "</td>";
            echo "</tr>";
        }

        echo "</tbody></table>";
    } else {
        echo "<h2>No quizzes found.</h2>";
    }
    ?>
</body>
</html>
        <?php
    exit;} elseif ($type == 'showResults') {
        ?>
        <?php

ini_set('display_errors', 1);
error_reporting(E_ALL);


include 'database.php';


    
    $query = "SELECT * FROM quiz_results";
    $result = $conn->query($query);

    ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Show Quizzes</title>
    <link rel="stylesheet" href="design.css">
</head>
<body>
    <h1>All Quizzes</h1>
    
    <form action="teacherpage.php" method="get">
        <button type="submit">Back to Teacher Page</button>
    </form>
    
    <?php

    
    if (!$result) {
        die("Query failed: " . $conn->error); 
    }

    
    if ($result->num_rows > 0) {
        echo "<h1>Quiz Results</h1>";

        
        echo "<table border='1'>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Quiz Code</th>
                        <th>Score</th>
                    </tr>
                </thead>
                <tbody>";

        
        while ($row = $result->fetch_assoc()) {
            echo "<tr>
                    <td>" . $row['id'] . "</td>
                    <td>" . $row['firstname'] . "</td>
                    <td>" . $row['lastname'] . "</td>
                    <td>" . $row['quizcode'] . "</td>
                    <td>" . $row['score'] . "</td>
                  </tr>";
        }

        echo "</tbody></table>";
    } else {
        echo "<p>No results found.</p>";
    }
?>
        <?php
    exit;} 
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="design.css">
</head>
<body>

<form method="GET">
    <h1>CHOOSE FROM THESE 2 OPTIONS</h1>
    <button type="submit" name="type" value="createquiz">Click if you want to Create Quizzes</button><br><br>
    <button type="submit" name="type" value="showquizzes">Click if you want to see all the quizzes made</button><br><br>
    <button type="submit" name="type" value="showResults">Click if you want to see all results</button><br><br>
    
</form>
    <button onclick="window.location.href='homeselection.php'">Back to Home Selection</button>

</body>
</html>
