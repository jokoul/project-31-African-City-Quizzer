<?php 
session_start();
include 'database.php';

//Check to see if score is set_error_handler
if(!isset($_SESSION['score'])){
    $_SESSION['score'] = 0;//iniialize a session
}

if(isset($_POST['submit'])){
    $number = $_POST['number'];
    $selected_choice = $_POST['choices'];
    $next = $number+1;

    /**
     * Get Total questions  
     */    
    $query = "SELECT * FROM questions";
    //Get results
    $results = $mysqli->query($query) or die($mysqli->error . __LINE__);
    $total = $results->num_rows;

    /**
     * Get Correct choice
     */
    $query = "SELECT * FROM choices WHERE question_number='$number' AND is_correct='1'";
    //Get result
    $result = $mysqli->query($query) or die($mysqli->error . __LINE__);

    //Get row
    $row = $result->fetch_assoc();

    //Set correct choices
    $correct_choice = $row['id'];

    //Compare
    if($correct_choice == $selected_choice){
        //Answer is correct
        $_SESSION['score'] = $_SESSION['score'] + 1;
    }

    //Check if it's last question
    if($number == $total){
        header('Location: final.php');
        exit();
    }else{
        header("Location: question.php?n=" . $next);
    }
}