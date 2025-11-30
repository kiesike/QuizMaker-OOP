<?php
$allowedQuizTypes = ['identification', 'multiple_choice', 'true_false'];
$condition = isset($_GET['quiztype']) && in_array($_GET['quiztype'],
             $allowedQuizTypes) ? $_GET['quiztype'] : null;
$code = $_POST['code'] ?? $_GET['code'] ?? null;

?>

<?php

if ($condition === 'identification') {
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Question Form</title>
    <link rel="stylesheet" href="desigbn.css"> 

    </head>

    <h1>Add, Delete, Update or View Questions</h1>
<form action="options.php" method="POST">
<link rel="stylesheet" href="design.css">

<input type="hidden" name="quiztype" value= "identification">
<input type="hidden" name="code" value="<?= htmlspecialchars($code) ?>">

    <label>Enter Question:</label><br>
    <input style = "text-transform: lowercase" type="text" name="question" placeholder="Enter question"><br><br>

    <label>Enter Answer:</label><br>
    <input style = "text-transform: lowercase" type="text" name="answer" placeholder="Enter answer" required ><br><br>

    <label>Question ID (for delete OR update):</label><br>
    <input style = "text-transform: lowercase" type="text" name="id" placeholder="Enter ID"><br><br>

    <button type="submit" name="status" value="add">Add Question</button>
    <button type="submit" name="status" value="delete">Delete Question</button>
    <button type="submit" name="status" value="update">Update Question</button>
    <button type="submit" name="status" value="show">Show All Questions</button>
    <button type="submit" name="status" value="enter">Done</button>
</form>



<?php

} elseif ($condition === 'multiple_choice') {

    ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Question Form</title>
    <link rel="stylesheet" href="design.css"> <!-- Link to the CSS file -->

    </head>
    <h1>Add, Delete, Update or View Questions</h1>
<form action="options.php" method="POST">

<input type="hidden" name="quiztype" value= "multiple_choice">
<input type="hidden" name="code" value="<?= htmlspecialchars($code) ?>">

    <label>Enter Question:</label><br>
    <input type="text" name="question" placeholder="Enter question"><br><br>

    <label for="radio_value1">Enter value for Radio Button 1:</label>
    <input style = "text-transform: lowercase" type="text" name="choice[]"><br><br>

    <label for="radio_value2">Enter value for Radio Button 2:</label>
    <input style = "text-transform: lowercase" type="text" name="choice[]"><br><br>

    <label for="radio_value3">Enter value for Radio Button 3:</label>
    <input style = "text-transform: lowercase" type="text" name="choice[]"><br><br>

    <label for="radio_value4">Enter value for Radio Button 4:</label>
    <input style = "text-transform: lowercase" type="text" name="choice[]"><br><br>

    <label>Question ID (for delete OR update):</label><br>
    <input style = "text-transform: lowercase" type="text" name="id" placeholder="Enter ID"><br><br>

    <input style = "text-transform: lowercase" type="text" name="answer" placeholder="Enter answer" required><br><br>


    <button type="submit" name="status" value="add">Add Question</button>
    <button type="submit" name="status" value="delete">Delete Question</button>
    <button type="submit" name="status" value="update">Update Question</button>
    <button type="submit" name="status" value="show">Show All Questions</button>
    <button type="submit" name="status" value="enter">Done</button>
</form>
<?php



} elseif ($condition === 'true_false') {

    ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Question Form</title>
    <link rel="stylesheet" href="design.css"> 

    <head>

    <h1>Add, Delete, Update or View Questions</h1>
<form action="options.php" method="POST">

<input type="hidden" name="quiztype" value= "true_false">
<input type="hidden" name="code" value="<?= htmlspecialchars($code) ?>">

    <label>Enter Question:</label><br>
    <input style = "text-transform: lowercase" type="text" name="question" placeholder="Enter question"><br><br>

    <label>Enter Answer: true or false only</label><br>
    <input style = "text-transform: lowercase" type="text" name="answer" placeholder="Enter answer" required ><br><br>

    

    <label>Question ID (for delete OR update):</label><br>
    <input style = "text-transform: lowercase" type="text" name="id" placeholder="Enter ID"><br><br>


    <button type="submit" name="status" value="add">Add Question</button>
    <button type="submit" name="status" value="delete">Delete Question</button>
    <button type="submit" name="status" value="update">Update Question</button>
    <button type="submit" name="status" value="show">Show All Questions</button>
    <button type="submit" name="status" value="enter">Done</button>
</form>
<?php

?>

</body>
</html>

<?php
} 

?>

</body>
</html>

<?php

?>