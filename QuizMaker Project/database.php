<?php

     $db_server = "localhost";
     $db_user = "root";
     $db_pass = "";
     $db_name = "quiz_system";
     global $conn;

     try {
        $conn = new mysqli ($db_server,
                         $db_user,
                         $db_pass,
                         $db_name,);
            
         
     }
     catch (mysqli_sql_exception){
        echo"Could not connect! <br>";
     }


// http://localhost/QuizMaker%20Project/homeselection.php
?>


