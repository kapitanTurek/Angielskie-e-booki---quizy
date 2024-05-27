<?php
    include "connectionCredentials.php";
    session_start();

    if($_SESSION['status'] == 0){
        header("Location: adminLogin.php");
        exit();
    }
    
    $connector = new mysqli($serverLocation, $loginName, $passwordToAccess, $databaseName);

    $quantityOfQuestions = $_GET['quantity'];
    $editedQuizID = $_GET['quizID'];
    $numberOfBoxes = $_POST['hiddenValue'];
    
    $indexesToSkip = $_POST['hiddenRemoved'];
    $indexesToSkipArray = explode(',', $indexesToSkip);

    $quizTitle = mysqli_real_escape_string($connector, $_POST['quizTitle']);
    $quizCategory = mysqli_real_escape_string($connector, $_POST['quizCategory']);
    
    $questionsIDsArray = [];

    $questionsIDsQuery = " SELECT questionID FROM questionsinquiz WHERE quizID LIKE ".$editedQuizID.";";
    $questionsIDsResult = $connector -> query($questionsIDsQuery);

    if($questionsIDsResult -> num_rows > 0){
        while($reachedRecords = $questionsIDsResult->fetch_array(MYSQLI_NUM)){
            array_push($questionsIDsArray, $reachedRecords[0]);
        }
    }

    $k = 0;

    $alterQuizNameQuery = "UPDATE quizes SET quizName = '".$quizTitle."' WHERE id LIKE ".$editedQuizID.";";
    $renamesQuiz = $connector->query($alterQuizNameQuery);

    $newCategoryIDQuery = "SELECT DISTINCT(categories.id) AS id FROM categories INNER JOIN quizcategories ON categories.id = quizcategories.categoryID WHERE categories.name LIKE '".$quizCategory."';";
    $newCategoryIDResult = $connector->query($newCategoryIDQuery);
    $newCategoryFetched = $newCategoryIDResult->fetch_array(MYSQLI_NUM);
    $newCategory = $newCategoryFetched[0];
    
    $alterQuizCategory = "UPDATE quizcategories SET categoryID = ".$newCategory." WHERE quizID LIKE ".$editedQuizID.";";
    $recategorisedQuiz = $connector->query($alterQuizCategory);

    for($j = 0; $j < sizeof($indexesToSkipArray); $j += 1){
        echo "<script>console.log('Value to skip: ".$indexesToSkipArray[$j]."');</script>";
    }

    for($i = 0; $i < $numberOfBoxes; $i += 1){
        $toSkip = false;

        for($j = 0; $j < sizeof($indexesToSkipArray); $j += 1){
            if($i == $indexesToSkipArray[$j]){
                $toSkip = true;
            }
        }

        if($toSkip == 0){
            echo "<script>console.log('Value updated: ".$i."');</script>";

            $lastQuestionID = "SELECT questions.id FROM questions ORDER BY questions.id DESC LIMIT 1;";
            $lastQuestionIDResult = $connector->query($lastQuestionID);
            $lastQuestionIDAssoc = $lastQuestionIDResult->fetch_array(MYSQLI_NUM);
            $newQuestionID = $lastQuestionIDAssoc[0] + 1;
            
            $questionName = mysqli_real_escape_string($connector, $_POST['questionHeader'.$i]);
            $firstAnswer = mysqli_real_escape_string($connector, $_POST['Answer1name'.$i]);
            $secondAnswer = mysqli_real_escape_string($connector, $_POST['Answer2name'.$i]);
            $thirdAnswer = mysqli_real_escape_string($connector, $_POST['Answer3name'.$i]);
            $fourthAnswer = mysqli_real_escape_string($connector, $_POST['Answer4name'.$i]);
            $explanation = mysqli_real_escape_string($connector, $_POST['explanationName'.$i]);
            $trueAnswer = mysqli_real_escape_string($connector, $_POST['trueAnswerName'.$i]);

            if($i < $quantityOfQuestions){
                $alterQuestionsQuery = "UPDATE questions SET questionTitle = '".$questionName."', firstAnswer = '".$firstAnswer."', secondAnswer = '".$secondAnswer."', thirdAnswer = '".$thirdAnswer."', fourthAnswer = '".$fourthAnswer."', correct = ".$trueAnswer.", explanation = '".$explanation."' WHERE id LIKE ".$questionsIDsArray[$k].";";
                $alteredQuestions = $connector->query($alterQuestionsQuery);

                $k += 1;
            }
            else{
                $sqlQuestion = "INSERT INTO questions(id, questionTitle, firstAnswer, secondAnswer, thirdAnswer, fourthAnswer, correct, explanation) VALUES(".$newQuestionID.", '".$questionName."', '".$firstAnswer."', '".$secondAnswer."', '".$thirdAnswer."', '".$fourthAnswer."', '".$trueAnswer."', '".$explanation."');";
            
                $connector->query($sqlQuestion);

                $connectionQuery = "INSERT INTO questionsinquiz(quizID, questionID) VALUES(".$editedQuizID.", ".$newQuestionID.");";

                $connector->query($connectionQuery);
            }

        }
        else{
            echo "<script>console.log('Value skipped: ".$i."');</script>";
            if($i < $quantityOfQuestions){
                $deleteQuestionFromQuizQuery = "DELETE FROM questionsinquiz WHERE questionID LIKE ".$questionsIDsArray[$k].";";
                $questionFromQuizExecutor = $connector -> query($deleteQuestionFromQuizQuery);

                $deleteQuestionQuery = "DELETE FROM questions WHERE id LIKE ".$questionsIDsArray[$k].";";
                $questionExecutor = $connector -> query($deleteQuestionQuery);

                $k += 1;
            }
        }
    }

    $connector->close();

    header("Location: adminPanelPreview.php?success=1");
    exit;
?>