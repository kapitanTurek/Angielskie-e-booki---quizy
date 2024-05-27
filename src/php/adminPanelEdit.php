<!DOCTYPE html>
<?php
    session_start();

    if($_SESSION['status'] == 0){
        header("Location: adminLogin.php");
        exit();
    }
    
    if(isset($_GET['success']) && $_GET['success'] == 1){
        echo "<script>alert('Operacja zakończona sukcesem! Dodano quiz posiadający: ".$_GET['created']." pytania')</script>";
    }
?>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="../css/admin.css" />
    <!-- GOOGLE FONTS ADDING -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Mulish:wght@200&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display&display=swap" rel="stylesheet">
    <!-- BOOTSTRAP ADDING -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <title>Admin Panel</title>
</head>
<body>
    <div class="container-fluid" id="pageContent">
        <div class="row">
            <div class="col-sm-2 sideMenu">
                <div class="row logo">
                    <a class="navbar-brand" style="font-weight: 600; font-size: .99em;" href="../../index.html">Angielskie-ebooki</a>
                </div>

                <div class="expand" onclick="menuExpander()"><img src="../../icons/down_arrow.png" alt="down arrow" class="menuIconInteractive" id="downArrowIcon"/></div>

                <div class="row menuContent">
                    <ul class="listMenu" id="listMenu">
                        <li>
                            <a href="adminPanel.php" class="navLink"><img src="../../icons/pencileWhite.png" alt="pencile" class="menuIcon"/>Stwórz quiz</a>
                        </li>
                        <li>
                            <a href="adminPanelPreview.php" class="navLink"><img src="../../icons/listWhite.png" alt="pencile" class="menuIcon"/>Przeglądaj quizy</a>
                            <input type="hidden" id="hiddenCategories" value="" />
                            <input type="hidden" id="quizID" value="" />
                            <input type="hidden" id="quizName" value="" />
                            <input type="hidden" id="quizCategoryReached" value="" />
                            <input type="hidden" id="questionsQuantity" value="" />
                            <input type="hidden" id="hiddenIDs" value="" />
                            <input type="hidden" id="hiddenQuestion" value="" />
                            <input type="hidden" id="hiddenFirstAnswer" value="" />
                            <input type="hidden" id="hiddenSecondAnswer" value="" />
                            <input type="hidden" id="hiddenThirdAnswer" value="" />
                            <input type="hidden" id="hiddenfourthAnswer" value="" />
                            <input type="hidden" id="hiddenCorrect" value="" />
                            <input type="hidden" id="hiddenExplanation" value="" />
                            <input type="hidden" id="category" value="" />
                        </li>
                        <li>
                            <a href="adminCategories.php" class="navLink"><img src="../../icons/categoriesIcon.png" alt="categories" class="menuIcon"/>Kategorie</a>
                        </li>
                        <li class="logoutButton">
                            <a href="logout.php" class="navLink"><img src="../../icons/logout.png" alt="logout" class="menuIcon"/>Wyloguj się</a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="col-sm-10 infos" id="infos"></div>
        </div>
    </div>

    <?php
        include "connectionCredentials.php";
        $connector = new mysqli($serverLocation, $loginName, $passwordToAccess, $databaseName);
        
        $quizID = $_GET['quizID'];

        $numberOfQuestionsQuery = "SELECT COUNT(questionID) AS quantityOfQuestions FROM questionsinquiz WHERE quizID LIKE ".$quizID.";";
        $numberOfQuestionsResult = $connector->query($numberOfQuestionsQuery);
        $valuesReached = $numberOfQuestionsResult->fetch_array(MYSQLI_NUM);
        $nunmberOfResult = $valuesReached[0];

        $nameOfQuizQuery = "SELECT quizName FROM quizes WHERE id LIKE ".$quizID.";";
        $nameOfQuizResult = $connector -> query($nameOfQuizQuery);
        $reachedRecords = $nameOfQuizResult->fetch_array(MYSQLI_NUM);
        $quizName = $reachedRecords[0];

        $quizCategoryQuery = "SELECT categories.name FROM categories INNER JOIN quizcategories ON categories.id = quizcategories.categoryID WHERE quizcategories.quizID LIKE ".$quizID.";";
        $quizCategoryResult = $connector->query($quizCategoryQuery);
        $reachedQuizCategory = $quizCategoryResult->fetch_array(MYSQLI_NUM);
        $quizCategory = $reachedQuizCategory[0];

        $questionsDataQuery = "SELECT questions.id, questions.questionTitle, questions.firstanswer, questions.secondanswer, questions.thirdanswer, questions.fourthanswer, questions.explanation, questions.correct FROM questions INNER JOIN questionsinquiz ON questions.id = questionsinquiz.questionID WHERE quizID LIKE ".$quizID.";";
        $reachedQuestionData = $connector -> query($questionsDataQuery);

        $questionIDArray = [];
        $questionNameArray = [];
        $firstAnswerArray = [];
        $secondAnswerArray = [];
        $thirdAnswerArray = [];
        $fourthAnswerArray = [];
        $explanationArray = [];
        $trueAnswerArray = [];

        $questionIDString = "";
        $questionNameString = "";
        $firstAnswerString = "";
        $secondAnswerString = "";
        $thirdAnswerString = "";
        $fourthAnswerString = "";
        $explanationString = "";
        $trueAnswerString = "";
        $valueCatcherQuestions = 1;

        if($reachedQuestionData->num_rows > 0){
            while($row = $reachedQuestionData->fetch_array(MYSQLI_NUM)){
                array_push($questionIDArray, $row[0]);
                array_push($questionNameArray, $row[1]);
                array_push($firstAnswerArray, $row[2]);
                array_push($secondAnswerArray, $row[3]);
                array_push($thirdAnswerArray, $row[4]);
                array_push($fourthAnswerArray, $row[5]);
                array_push($explanationArray, $row[6]);
                array_push($trueAnswerArray, $row[7]);
            }
        }

        for($i=0; $i < sizeof($questionIDArray); $i += 1){
            if($valueCatcherQuestions < sizeof($questionIDArray)){
                $questionIDString .= $questionIDArray[$i]."|";
                $questionNameString .= $questionNameArray[$i]."|";
                $firstAnswerString .= $firstAnswerArray[$i]."|";
                $secondAnswerString .= $secondAnswerArray[$i]."|";
                $thirdAnswerString .= $thirdAnswerArray[$i]."|";
                $fourthAnswerString .= $fourthAnswerArray[$i]."|";
                $explanationString .= $explanationArray[$i]."|";
                $trueAnswerString .= $trueAnswerArray[$i]."|";
            }
            else{
                $questionIDString .= $questionIDArray[$i];
                $questionNameString .= $questionNameArray[$i];
                $firstAnswerString .= $firstAnswerArray[$i];
                $secondAnswerString .= $secondAnswerArray[$i];
                $thirdAnswerString .= $thirdAnswerArray[$i];
                $fourthAnswerString .= $fourthAnswerArray[$i];
                $explanationString .= $explanationArray[$i];
                $trueAnswerString .= $trueAnswerArray[$i];
            }
            $valueCatcherQuestions += 1;
        }

        $categoryAvailable = "SELECT `name` FROM categories GROUP BY `name`;";
        $categoriesResult = $connector->query($categoryAvailable);

        $categoriesToUse = [];
        $categoriesString = "";
        $valueCatcherCategories = 1;

        if($categoriesResult -> num_rows > 0){
            while($row = $categoriesResult->fetch_array(MYSQLI_NUM)){
                array_push($categoriesToUse, $row[0]);
            }
        }

        for($i=0; $i < sizeof($categoriesToUse); $i += 1){
            if($valueCatcherCategories < sizeof($categoriesToUse)){
                $categoriesString .= $categoriesToUse[$i]."|";
            }
            else{
                $categoriesString .= $categoriesToUse[$i];
            }
            $valueCatcherCategories += 1;
        }

        echo "<script>let categoriesHolder = document.getElementById('hiddenCategories'); categoriesHolder.value = '".$categoriesString."'</script>";
        echo "<script>let quizToEdit = document.getElementById('quizID'); quizToEdit.value = '".$quizID."'</script>";
        echo "<script>let questionsQuantity = document.getElementById('questionsQuantity'); questionsQuantity.value = '".$nunmberOfResult."'</script>";
        echo "<script>let quizName = document.getElementById('quizName'); quizName.value = '".$quizName."'</script>";
        echo "<script>let quizCategory = document.getElementById('quizCategoryReached'); quizCategory.value = '".$quizCategory."'</script>";

        echo '<script>let questionsIDHolder = document.getElementById("hiddenIDs"); questionsIDHolder.value = "'.$questionIDString.'";</script>';
        echo '<script>let questionsHolder = document.getElementById("hiddenQuestion"); questionsHolder.value = "'.$questionNameString.'";</script>';
        echo '<script>let firstAnswersHolder = document.getElementById("hiddenFirstAnswer"); firstAnswersHolder.value = "'.$firstAnswerString.'";</script>';
        echo '<script>let secondAnswersHolder = document.getElementById("hiddenSecondAnswer"); secondAnswersHolder.value = "'.$secondAnswerString.'";</script>';
        echo '<script>let thirdAnswersHolder = document.getElementById("hiddenThirdAnswer"); thirdAnswersHolder.value = "'.$thirdAnswerString.'";</script>';
        echo '<script>let fourthAnswersHolder = document.getElementById("hiddenfourthAnswer"); fourthAnswersHolder.value = "'.$fourthAnswerString.'";</script>';
        echo '<script>let correctHolder = document.getElementById("hiddenCorrect"); correctHolder.value = "'.$trueAnswerString.'";</script>';
        echo '<script>let explanationHolder = document.getElementById("hiddenExplanation"); explanationHolder.value = "'.$explanationString.'";</script>';
    ?>

    <script src="../js/adminScript.js" onload="editQuiz()"></script>
    <script src="https://requirejs.org/docs/release/2.3.5/minified/require.js"></script>
</body>
</html>