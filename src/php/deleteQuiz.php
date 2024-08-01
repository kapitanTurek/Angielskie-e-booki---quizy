<?php
    include "connectionCredentials.php";
    session_start();

    if($_SESSION['status'] == 0){
        header("Location: adminLogin.php");
        exit();
    }
    
    $connector = new mysqli($serverLocation, $loginName, $passwordToAccess, $databaseName);

    $questionsIDArray = [];
    $questionsIDQuery = "SELECT questionID FROM questionsinquiz WHERE quizID LIKE ".$_GET['id'].";";
    $IDQueryResult = $connector->query($questionsIDQuery);
    if($IDQueryResult->num_rows > 0){
        while($row = $IDQueryResult->fetch_array(MYSQLI_NUM)){
            array_push($questionsIDArray, $row[0]);
        }
    }

    $deleteSQLQueryCombine = "DELETE FROM questionsinquiz WHERE quizID LIKE ".$_GET['id'].";";
    $processQuery = $connector->query($deleteSQLQueryCombine);
    echo "<p>console.log('Usuwam rekordy o ID: ".$_GET['id']."')</p>";

    $deleteSQLQueryCombineCategory = "DELETE FROM quizcategories WHERE quizID LIKE ".$_GET['id'].";";
    $processQueryCat = $connector->query($deleteSQLQueryCombineCategory);
    echo "<p>console.log('Usuwam rekordy o ID: ".$_GET['id']."')</p>";
    
    $deleteFromQuizes = "DELETE FROM quizes WHERE id LIKE ".$_GET['id'].";";
    $processFromQuizes = $connector->query($deleteFromQuizes);
    echo "<p>console.log('Usuwam quiz o ID: ".$_GET['id']."')</p>";


    for($i = 0; $i < sizeof($questionsIDArray); $i += 1){
        $deleteFromQuestions = "DELETE FROM questions WHERE id LIKE ".$questionsIDArray[$i].";";
        $deleteResult = $connector->query($deleteFromQuestions);
        echo "<p>console.log('Usuwam pytanie o ID: ".$questionsIDArray[$i]."')</p>";
    }

    $connector->close();

    header("Location: adminPanelPreview.php?deleted=1");
    exit;
?>