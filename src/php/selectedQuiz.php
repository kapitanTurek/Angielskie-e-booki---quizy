<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="../css/style.css" />
    <!-- GOOGLE FONTS ADDING -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Mulish:wght@200&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display&display=swap" rel="stylesheet"> 
    <!-- BOOTSTRAP ADDING -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <title>Angielskie-ebooki</title>
</head>
<body>
    <div class="container-fluid space">
        <div class="row navBarStyle">
            <nav class="navbar navbar-expand-sm navbar-light">
                <a class="navbar-brand" style="font-weight: 600; font-size: .99em;" href="../../index.html">Angielskie-ebooki</a>
    
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
    
                <div class="collapse navbar-collapse justify-content-end" id="navbarSupportedContent">
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a class="nav-link navLink" href="quizCategories.php">Quizy</a>
                        </li>
            
                        <li class="nav-item">
                            <a class="nav-link navLink" href="../../index.html#popularSection">Popularne</a>
                        </li>
                
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle navLink" href="" id="navbarDropdown" data-bs-toggle="dropdown">O autorze</a>
            
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="../../index.html#about">Poznaj mnie</a></li>
                                <li><a class="dropdown-item" href="../../index.html#contact">Kontakt</a></li>
                            </ul>
                        </li>
            
                        <li class="nav-item">
                            <a class="nav-link navLink" href="">Sklep</a>
                        </li>
                                        
                        <li class="nav-item">
                            <a href="" class="navLink">
                                <button class="btn-cart">
                                    <img src="../../icons/cart_white.png" class="icon" style="transform: translate(-5%, -10%);"/>
                                </button>
                            </a>
                        </li>
                    </ul>
                </div>
            </nav>
        </div>

        <div class="row navigation" id="navigation" style="padding: .5em .3em;">
            <span><a href="../../index.html" class="navLink">Strona główna</a> / <a href="quizCategories.php" class="navLink">Kategorie Quizów</a> / <a href="quizy.php" class="navLink" id="quizPather"></a> / <span id="path"></span> </span>
        </div>

        <div class="row quizContent">
            <div class="col-sm-3"></div>

            <div class="col-sm-6 reactBox">
                <div id="quizSpace" class="col-sm-12"></div>
            </div>

            <div class="col-sm-3"></div>
        </div>

        <footer class="row footer">
            <hr style="opacity: 0.8;"/>
            <div class="row">
                <div class="col-sm-3 footerLink">
                    <a href="" class="navLinkFooter">Sklep</a>
                </div>
    
                <div class="col-sm-3 footerLink">
                    <a href="../../index.html#about" class="navLinkFooter">O autorze</a>
                </div>
    
                <div class="col-sm-3 footerLink">
                    <a href="../../index.html#contact" class="navLinkFooter">Kontakt</a>
                </div>
    
                <div class="col-sm-3 footerLink">
                    <a href="../../index.html#popularSection" class="navLinkFooter">Popularne</a>
                </div>
            </div>
                
            <div class="row">
                <div class="col-sm-2"></div>

                <div class="col-sm-4 footerLink">
                    <a href="../html/policies.html" class="navLinkFooter">Regulamin sklepu</a>
                </div>

                <div class="col-sm-4 footerLink">
                    <a href="quizCategories.php" class="navLinkFooter">Quizy</a>
                </div>

                <div class="col-sm-2">
                    <div class="notInterestingThings" style="hidden">
                        <div class="seriouslyThereIsNothingInterestingHere">
                            <div class="doNotCheckThaturther">
                                <div class="whyAreYouDoingThat">
                                    <div class="fineThereAreFewThingsHere">
                                        <div class="iAmJustJoking">
                                            <div class="goAway">
                                                <div class="thatIsNotFunnyAnymore">
                                                    <input type="hidden" id="hiddenQuestion" value="0" />
                                                    <input type="hidden" id="hiddenFirstAnswer" value="" />
                                                    <input type="hidden" id="hiddenSecondAnswer" value="" />
                                                    <input type="hidden" id="hiddenThirdAnswer" value="" />
                                                    <input type="hidden" id="hiddenfourthAnswer" value="" />
                                                    <input type="hidden" id="hiddenCorrect" value="" />
                                                    <input type="hidden" id="hiddenExplanation" value="" />
                                                    <input type="hidden" id="category" value="" />
                                                    <input type="hidden" id="quizName" value="" />
                                                    <input type="hidden" id="categoryToDisplay" value="" />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>            
        </footer>

        <?php
            include "connectionCredentials.php";
            $connector = new mysqli($serverLocation, $loginName, $passwordToAccess, $databaseName);

            $questionsIDArray = [];

            $selectedCategoryID = $_GET['category'];

            $currentCategory = "SELECT `name` FROM categories WHERE id LIKE ".$_GET['category'].";";
            $returnedCategory = $connector->query($currentCategory);
            $fetchedCategory = $returnedCategory->fetch_array(MYSQLI_NUM);
            $quizCategoryToDisplay = $fetchedCategory[0];

            $quizName = "SELECT quizName FROM quizes WHERE id LIKE ".$_GET['id'].";";
            $returnedName = $connector->query($quizName);
            $fetchingName = $returnedName->fetch_array(MYSQLI_NUM);
            $quizNameValue = $fetchingName[0];
            
            $questionsToTakeQuery = "SELECT questionID FROM questionsinquiz WHERE quizID LIKE ".$_GET['id'].";";
            $listOfQuestions = $connector -> query($questionsToTakeQuery);
            if($listOfQuestions -> num_rows > 0){
                while($row = $listOfQuestions->fetch_array(MYSQLI_NUM)){
                    array_push($questionsIDArray, $row[0]);
                }
            }

            if(sizeof($questionsIDArray) > 1){
                $questionData = "SELECT questionTitle, firstAnswer, secondAnswer, thirdAnswer, fourthAnswer, correct, explanation FROM questions WHERE id BETWEEN ".$questionsIDArray[0]." AND ".$questionsIDArray[(sizeof($questionsIDArray)-1)].";";
            }
            else{
                $questionData = "SELECT questionTitle, firstAnswer, secondAnswer, thirdAnswer, fourthAnswer, correct, explanation FROM questions WHERE id LIKE ".$questionsIDArray[0].";";
            }

            $questionDataResult = $connector -> query($questionData);

            $valueCounter = 1;
            $questionsInQuiz = "";
            $firstAnswerString = "";
            $secondAnswerString = "";
            $thirdAnswerString = "";
            $fourthAnswerString = "";
            $correctString = "";
            $explanationString = "";

            if($questionDataResult->num_rows > 0){
                while($row = $questionDataResult->fetch_array(MYSQLI_NUM)){
                    if($valueCounter < sizeof($questionsIDArray)){
                        $questionsInQuiz .= $row[0]."|";
                        $firstAnswerString .= $row[1]."|";
                        $secondAnswerString .= $row[2]."|";
                        $thirdAnswerString .= $row[3]."|";
                        $fourthAnswerString .= $row[4]."|";
                        $correctString .= $row[5]."|";
                        $explanationString .= $row[6]."|";
                    }
                    else{
                        $questionsInQuiz .= $row[0];
                        $firstAnswerString .= $row[1];
                        $secondAnswerString .= $row[2];
                        $thirdAnswerString .= $row[3];
                        $fourthAnswerString .= $row[4];
                        $correctString .= $row[5];
                        $explanationString .= $row[6];
                    }
                    $valueCounter += 1;
                }
            }

            $connector->close();

            echo '<script>let questionsHolder = document.getElementById("hiddenQuestion"); questionsHolder.value = "'.$questionsInQuiz.'";</script>';
            echo '<script>let firstAnswersHolder = document.getElementById("hiddenFirstAnswer"); firstAnswersHolder.value = "'.$firstAnswerString.'";</script>';
            echo '<script>let secondAnswersHolder = document.getElementById("hiddenSecondAnswer"); secondAnswersHolder.value = "'.$secondAnswerString.'";</script>';
            echo '<script>let thirdAnswersHolder = document.getElementById("hiddenThirdAnswer"); thirdAnswersHolder.value = "'.$thirdAnswerString.'";</script>';
            echo '<script>let fourthAnswersHolder = document.getElementById("hiddenfourthAnswer"); fourthAnswersHolder.value = "'.$fourthAnswerString.'";</script>';
            echo '<script>let correctHolder = document.getElementById("hiddenCorrect"); correctHolder.value = "'.$correctString.'";</script>';
            echo '<script>let explanationHolder = document.getElementById("hiddenExplanation"); explanationHolder.value = "'.$explanationString.'";</script>';
            echo '<script>let category = document.getElementById("category"); category.value = "'.$selectedCategoryID.'";</script>';
            echo '<script>let quizName = document.getElementById("quizName"); quizName.value = "'.$quizNameValue.'";</script>';
            echo '<script>let categoryToDisplay = document.getElementById("categoryToDisplay"); categoryToDisplay.value = "'.$quizCategoryToDisplay.'";</script>';
        ?>
        <script src="../js/selectedQuizPreview.js"></script>
    </div>
</body>
</html>