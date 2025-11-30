<?php
include "functions.php"; 


$CRUDS = new CRUDS($conn);

$status = $_POST['status'] ?? null;
$quiztype = $_POST['quiztype'] ?? null;
$question = $_POST['question'] ?? null;
$choices = isset($_POST['choice']) ? $_POST['choice'] : []; 
$answer = $_POST['answer'] ?? null;
$code = $_POST['code'] ?? null;
$id = $_POST['id'] ?? null;

$allowedQuizTypes = ['identification', 'multiple_choice', 'true_false'];
if (!in_array($quiztype, $allowedQuizTypes)) {
    echo "Invalid Quiz Type";
    exit;
}

switch ($status) {
    case 'add':
        
        if ($quiztype === 'multiple_choice' && !empty($choices)) {
            
            $CRUDS->addQuestion($code, $quiztype, $question, $answer, $choices);
        } else {
            
            $CRUDS->addQuestion($code, $quiztype, $question, $answer);
        }

        
        header("Location: questions.php?quiztype=$quiztype&code=" . urlencode($code));
        exit;

    case 'enter':
         
         header("Location: homepage.php?type=teacher");
         exit;

    case 'delete':
        
        $CRUDS->deleteQuestion($id);
        header("Location: questions.php?quiztype=$quiztype&code=" . urlencode($code));
        exit;

    case 'update':
        
        $CRUDS->updateQuestion($id, $question, $answer, $quiztype, $choices);
        echo "Question updated successfully.";
        header("Location: questions.php?quiztype=$quiztype&code=" . urlencode($code));
        exit;

    case 'show':
        
        $CRUDS->showAllQuestions($code, $quiztype); 
        echo '<button onclick="goBack()">Back</button>';
        
        echo '<script>
            function goBack() {
                window.location.href = "questions.php?quiztype=' . urlencode($quiztype) . '&code=' . urlencode($code) . '";
            }
            </script>'; 
        break;

    default:
        echo "Invalid action.";
        break;
}

$conn->close();
?>