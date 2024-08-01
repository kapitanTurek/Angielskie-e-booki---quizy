<?php
    include "connectionCredentials.php";
    session_start();

    if($_SESSION['status'] == 0){
        header("Location: adminLogin.php");
        exit();
    }
    
    $connector = new mysqli($serverLocation, $loginName, $passwordToAccess, $databaseName);

    $lastIDquery = "SELECT quizes.id FROM quizes ORDER BY quizes.id DESC LIMIT 1;";
    $lastIDResult = $connector->query($lastIDquery);
    $lastIDnumber = $lastIDResult->fetch_array(MYSQLI_NUM);
    $newIDValue = $lastIDnumber[0] + 1;

    $quizTitle = mysqli_real_escape_string($connector, $_POST['quizTitle']);
    $quizCategory = mysqli_real_escape_string($connector, $_POST['quizCategory']);

    $categoryIDCatcherQuery = 'SELECT id FROM categories WHERE `name` LIKE "'.$quizCategory.'";';
    $categoryID = $connector->query($categoryIDCatcherQuery);
    $categoryIDFetch = $categoryID->fetch_array(MYSQLI_NUM);
    $categoryIDResult = $categoryIDFetch[0];
    
    $numberOfBoxes = $_POST['hiddenValue'];

    $insertIntoQuery = "INSERT INTO quizes(id, quizName) VALUES(".$newIDValue.", '".$quizTitle."');";
    $connector->query($insertIntoQuery);

    $insertIntoQuizCategory = "INSERT INTO quizcategories(quizID, categoryID) VALUES(".$newIDValue.", ".$categoryIDResult.");";
    $connector->query($insertIntoQuizCategory);

    $indexesToSkip = $_POST['hiddenRemoved'];
    $indexesToSkipArray = explode(',', $indexesToSkip);

    for($i = 0; $i < $numberOfBoxes; $i += 1){
        $toSkip = false;

        for($j = 0; $j < sizeof($indexesToSkipArray); $j += 1){
            if($i == $indexesToSkipArray[$j]){
                $toSkip = true;
            }
        }

        if($toSkip == 0){
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
            
            $sqlQuestion = "INSERT INTO questions(id, questionTitle, firstAnswer, secondAnswer, thirdAnswer, fourthAnswer, correct, explanation) VALUES(".$newQuestionID.", '".$questionName."', '".$firstAnswer."', '".$secondAnswer."', '".$thirdAnswer."', '".$fourthAnswer."', '".$trueAnswer."', '".$explanation."');";
            
            $connector->query($sqlQuestion);
            if (http_response_code() === 200){
                echo "<p>Tranzakcja zakończona sukcesem - dodano ".$newQuestionID." rekord!</p>";            
            } else {
                echo "<p>Wystąbił błąd w wykonaniu tranzakcji. Zwrócona wartość to: ".$connector->error."</p>";
                break;
            }

            $connectionQuery = "INSERT INTO questionsinquiz(quizID, questionID) VALUES(".$newIDValue.", ".$newQuestionID.");";

            $connector->query($connectionQuery);
        }
        else{
            echo "<script>console.log('Removed: ".$i."')</script>";
        }
    }   
    
    $connector->close();

    header("Location: adminPanel.php?success=1");
    exit;
?>