<?php
include "functions.php";

$Quiz = new Quiz($conn);
$sanitizer = new InputSanitizer($conn);

if (isset($_POST['submit_quiz'])) {
    
    $firstname = $sanitizer->sanitizeInput($_POST['firstname']);
    $lastname = $sanitizer->sanitizeInput($_POST['lastname']);
    $quizcode = $sanitizer->sanitizeInput($_POST['quizcode']);
    
    $quiz = new Quiz($conn);
    $questions = $quiz->getQuizQuestions($quizcode);
    $score = 0;

    while ($question = $questions->fetch_assoc()) {
        $user_answer = $_POST['question_' . $question['id']];
        
        
        if ($question['answer'] == $user_answer) {
            $score++;
        }
    }

    
    $quiz->saveQuizResult($firstname, $lastname, $quizcode, $score);

    
    echo "<!DOCTYPE html>";
    echo "<html lang='en'>";
    echo "<head>";
    echo "<meta charset='UTF-8'>";
    echo "<meta name='viewport' content='width=device-width, initial-scale=1.0'>";
    echo "<title>Quiz Results</title>";
    echo "<link rel='stylesheet' href='design.css'>";
    echo "</head>";
    echo "<body>";
    echo "<div class='result-container'>";
    echo "<h1>Hello, " . htmlspecialchars($firstname) . "!</h1>";
    echo "<p>Your score is: <strong>" . $score . "</strong></p>";
    echo "User answer: " . htmlspecialchars($user_answer) . "<br>";
    echo "<button onclick=\"window.location.href='homeselection.php'\">Back to Home</button>";
    echo "</div>";
    echo "</body>";
    echo "</html>";
}
?>