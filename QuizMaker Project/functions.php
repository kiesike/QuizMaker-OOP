<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="design.css">
    <title>Document</title>
</head>
<body>
    
</body>
</html>
<?php
include "database.php";
$quiztype = $_POST['quiztype'] ?? null;

class InputSanitizer {
    private $conn;
    public function __construct($conn) {
        if ($conn === null) {
            die("Database connection is not established.");
        }
        $this->conn = $conn;
    }
    public function sanitizeInput($data) {
        $data = trim($data);
        $data = $this -> conn->real_escape_string($data);
        
        return $data;
    }
}

class CRUDS {
    private $conn;
    private $sanitizer;

    
    public function __construct($conn) {
        $this->conn = $conn;
        $this->sanitizer = new InputSanitizer($conn);
    }

    function sanitizeInput($data ) {
        return $this->sanitizer->sanitizeInput($data);
    }


    private function getQuizTypeId($quiztype) {
        $quiztype = $this->sanitizeInput($quiztype);
        $sql = "SELECT id FROM quiztypes WHERE name = '$quiztype'";
        $result = $this->conn->query($sql);
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            return $row['id'];
        } else {
            return null;
        }
    }

    public function addQuestion($code, $quiztype, $question, $answer, $choices = []) {
        
        if (!$this->conn) {
            die("Error: Database connection failed.");
        }
    
        
        $code = $this-> sanitizeInput($code);
        $quiztype = $this-> sanitizeInput($quiztype);
        $question = $this-> sanitizeInput($question);
        $answer = strtolower(str_replace(' ', '', $this->sanitizeInput($answer)));

    
        
        $quiztype_id = $this->getQuizTypeId($quiztype);
        if (!$quiztype_id) {
            die("Error: Invalid quiz type provided.");
        }
    
        
        $insertQuizQuery = "INSERT INTO quizzes (code, quiztype_id, question, answer) 
                            VALUES ('$code', $quiztype_id, '$question', '$answer')";
        if (!$this->conn->query($insertQuizQuery)) {
            die("Error inserting question: " . $this->conn->error);
        }
    
        
        $quiz_id = $this->conn->insert_id;
        if (!$quiz_id) {
            die("Error: Unable to retrieve quiz ID.");
        }
    
        echo "Question added successfully with ID: $quiz_id<br>";
    
        
        if ($quiztype === 'multiple_choice' && !empty($choices)) {
            foreach ($choices as $choice) {
                $choice = $this ->sanitizeInput($choice);
                $insertChoiceQuery = "INSERT INTO choices (quiz_id, choice) VALUES ($quiz_id, '$choice')";
                if (!$this->conn->query($insertChoiceQuery)) {
                    echo "Error adding choice '$choice': " . $this->conn->error . "<br>";
                } else {
                    echo "Choice added successfully: $choice<br>";
                }
            }
        } else {
            echo "No choices added or quiz type is not multiple choice.<br>";
        }
    }
    
    public function deleteQuestion($quiz_id) {
        
        $quiz_id = (int) $quiz_id;

        
        $sql_choices = "DELETE FROM choices WHERE quiz_id = $quiz_id";
        if ($this->conn->query($sql_choices) === TRUE) {
            echo "Choices deleted successfully.<br>";
        } else {
            echo "Error deleting choices: " . $this->conn->error . "<br>";
        }

        
        $sql_quiz = "DELETE FROM quizzes WHERE id = $quiz_id";
        if ($this->conn->query($sql_quiz) === TRUE) {
            echo "Quiz deleted successfully.";
        } else {
            echo "Error deleting quiz: " . $this->conn->error;
        }
    }

    public function updateQuestion($quiz_id, $question, $answer, $quiztype, $choices = []) {
        
        $quiz_id = (int)$quiz_id;
        $question = $this-> sanitizeInput($question);
        $answer = $this-> sanitizeInput($answer);
    
        
        $quiztype_id = $this->getQuizTypeId($quiztype);
        if ($quiztype_id === null) {
            echo "Error: Invalid quiz type provided.";
            return;
        }
    
        
        $sql_quiz = "UPDATE quizzes 
                     SET question = '$question', answer = '$answer', quiztype_id = $quiztype_id 
                     WHERE id = $quiz_id";
    
        if ($this->conn->query($sql_quiz) === TRUE) {
            echo "Quiz updated successfully.<br>";
    
            
            if ($quiztype === 'multiple_choice') {
                
                $sql_delete_choices = "DELETE FROM choices WHERE quiz_id = $quiz_id";
                $this->conn->query($sql_delete_choices);
    
                
                foreach ($choices as $choice) {
                    $choice = $this-> sanitizeInput($choice);
                    $sql_choice = "INSERT INTO choices (quiz_id, choice) VALUES ($quiz_id, '$choice')";
                    $this->conn->query($sql_choice);
                }
            }
        } else {
            echo "Error updating quiz: " . $this->conn->error;
        }
    }

    function showAllQuestions($input_code = null, $input_quiztype = null) {
        global $conn;
    
        
        $input_code = strtolower(str_replace(' ', '', $input_code));
        $input_quiztype = strtolower($input_quiztype); 
    
    
        $sql_quiz = "SELECT quizzes.id, quizzes.question, quizzes.answer, quizzes.code, quiztypes.name AS quiztype 
                     FROM quizzes 
                     JOIN quiztypes ON quizzes.quiztype_id = quiztypes.id";
        
        
        if ($input_code) {
            $sql_quiz .= " WHERE LOWER(REPLACE(quizzes.code, ' ', '')) = '$input_code'"; 
        }
        if ($input_quiztype) {
            if ($input_code) {
                $sql_quiz .= " AND LOWER(quiztypes.name) = '$input_quiztype'"; 
            } else {
                $sql_quiz .= " WHERE LOWER(quiztypes.name) = '$input_quiztype'"; 
            }
        }
    
        
        $result = $conn->query($sql_quiz);
    
        if ($result->num_rows > 0) {
            echo "<h2>All Questions:</h2>";
            echo "<table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Question</th>
                            <th>Answer</th>
                            <th>Quiz Code</th>
                            <th>Quiz Type</th>
                            <th>Choices</th>
                        </tr>
                    </thead>
                    <tbody>";
    
            while ($row = $result->fetch_assoc()) {
                
                echo "<tr>";
                echo "<td>" . stripslashes($this->sanitizeInput($row['id'])) . "</td>";
                echo "<td>" . stripslashes($this->sanitizeInput($row['question'])) . "</td>";
                echo "<td>" . stripslashes($this->sanitizeInput($row['answer'])) . "</td>";
                echo "<td>" . stripslashes($this->sanitizeInput($row['code'])) . "</td>";
                echo "<td>" . stripslashes($this->sanitizeInput($row['quiztype'])) . "</td>";
    
                
                if ($row['quiztype'] === 'multiple_choice') {
                    $sql_choices = "SELECT choice FROM choices WHERE quiz_id = " . $row['id'];
                    $choices_result = $conn->query($sql_choices);
                    if ($choices_result->num_rows > 0) {
                        $choices = [];
                        while ($choice = $choices_result->fetch_assoc()) {
                            $choices[] = htmlspecialchars($choice['choice']);
                        }
                        echo "<td>" . implode(", ", $choices) . "</td>";
                    } else {
                        echo "<td>No choices available</td>";
                    }
                } else {
                    echo "<td>N/A</td>";
                }
                echo "</tr>";
            }
    
            echo "</tbody></table>";
        } else {
            echo "<p>No questions found.</p>";
        }
    }
    
    
}

class User {
    private $conn;

    public function __construct() {
        global $conn; 
        $this->conn = $conn;
    }

    public function createAccount($name, $username, $password) {
        try {
            
            $query = "INSERT INTO users (name, username, password) VALUES ('$name', '$username', '$password')";
            if ($this->conn->query($query)) {
                return true;
            }
            return "Error creating account: " . $this->conn->error;
        } catch (mysqli_sql_exception $e) {
            
            if ($e->getCode() === 1062) {
                return "There is a similar username or password, please choose another one.";
            }
            return "An unexpected error occurred: ";
        }
    }
    
    public function login($username, $password) {
        
        $query = "SELECT * FROM users WHERE username = '$username'";
        $result = $this->conn->query($query);
    
        if ($result && $result->num_rows > 0) {
            $user = $result->fetch_assoc();
            
            if ($password === $user['password']) {
                return $user;
            }
        }
        return null;
    }

    
}

class Quiz {
    private $conn;
    private$sanitizer;
    
    public function __construct($conn) {
        $this->conn = $conn;
        $this->sanitizer = new InputSanitizer($conn);
    }
    function sanitizeInput($data ) {
        return $this->sanitizer->sanitizeInput($data);
    }

    public function getQuizQuestions($quizcode) {
        $quizcode = $this->sanitizeInput($quizcode);
        $query = "SELECT * FROM quizzes WHERE code = '$quizcode'";
        return $this->conn->query($query);
    }

    public function getChoices($quiz_id) {
        $quiz_id = $this->sanitizeInput($quiz_id);
        $query = "SELECT * FROM choices WHERE quiz_id = '$quiz_id'";
        return $this->conn->query($query);
    }

    public function saveQuizResult($firstname, $lastname, $quizcode, $score) {
        $firstname = $this->sanitizeInput($firstname);
        $lastname = $this->sanitizeInput($lastname);
        $quizcode = $this->sanitizeInput($quizcode);
        $query = "INSERT INTO quiz_results (firstname, lastname, quizcode, score) 
                  VALUES ('$firstname', '$lastname', '$quizcode', '$score')";
        $this->conn->query($query);
    }
}


?>