<?php
include 'database.php';
include "functions.php";

$Quiz = new Quiz($conn);
$sanitizer = new InputSanitizer($conn);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    $firstname = $sanitizer->sanitizeInput($_POST['firstname']);
    $lastname = $sanitizer->sanitizeInput($_POST['lastname']);
    $quizcode = $sanitizer->sanitizeInput($_POST['quizcode']);

    $quiz = new Quiz($conn);
    $questions = $quiz->getQuizQuestions($quizcode);

    if ($questions->num_rows > 0) {
        
        echo "<!DOCTYPE html>";
        echo "<html lang='en'>";
        echo "<head>";
        echo "<meta charset='UTF-8'>";
        echo "<meta name='viewport' content='width=device-width, initial-scale=1.0'>";
        echo "<title>Quiz Form</title>";

        
        echo "<link rel='stylesheet' href='quizdesign.css'>";

        
        echo "</head>";
        echo "<body>";

    
        echo "<form method='POST' action='submission.php'>";
        echo "<input type='hidden' name='firstname' value='$firstname'>";
        echo "<input type='hidden' name='lastname' value='$lastname'>";
        echo "<input type='hidden' name='quizcode' value='$quizcode'>";

        while ($question = $questions->fetch_assoc()) {
            echo "<div><h3>" . $question['question'] . "</h3>";
            
            
            $choices = $quiz->getChoices($question['id']);
            $quiztype_id = $question['quiztype_id'];
            
            if ($quiztype_id == 1) { 
                while ($choice = $choices->fetch_assoc()) {
                    echo "<input type='radio' name='question_" . $question['id'] . "' value='" . htmlspecialchars($choice['choice']) . "'>" . htmlspecialchars($choice['choice']) . "<br>";
                    
                }
            } else if ($quiztype_id == 2) { 
                echo "<input type='radio' name='question_" . $question['id'] . "' value='true'>True<br>";
                echo "<input type='radio' name='question_" . $question['id'] . "' value='false'>False<br>";

                
            } else if ($quiztype_id == 3) { 
                echo "<input type='text' name='question_" . $question['id'] . "' placeholder='Type your answer here'><br>";
            }

            echo "</div>";
        }

        echo "<input type='submit' name='submit_quiz' value='Submit Quiz'>";
        echo "</form>";

        
        echo "</body>";
        echo "</html>";
    } else {
        echo "Quiz code not found.";
    }
}
?>
