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

        <div class="row navigation" style="padding: .5em .3em;">
            <span><a href="../../index.html" class="navLink">Strona główna</a> / <a href="quizCategories.php" class="navLink">Kategorie Quizów</a> / <span id="quizCategory"></span></span>
        </div>

        <div class="row quizContent">
            <div class="col-sm-1"></div>

            <div class="col-sm-10 reactBox">
                <div id="quizSpace" class="col-sm-12"></div>
            </div>

            <div class="col-sm-1"></div>
        </div>

        <footer class="row footer">
            <div class="row">
                <div class="col-sm-2">
                    <div class="notInterestingThings" style="hidden">
                        <div class="seriouslyThereIsNothingInterestingHere">
                            <div class="doNotCheckThaturther">
                                <div class="whyAreYouDoingThat">
                                    <div class="fineThereAreFewThingsHere">
                                        <div class="iAmJustJoking">
                                            <div class="goAway">
                                                <div class="thatIsNotFunnyAnymore">
                                                    <input type="hidden" id="hiddenValue" value="0" />
                                                    <input type="hidden" id="quizIDData" value="" />
                                                    <input type="hidden" id="quizData" value="" />
                                                    <input type="hidden" id="category" value="" />
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

            $selectedCategoryID = $_GET['id'];

            $currentCategory = "SELECT `name` FROM categories WHERE id LIKE ".$_GET['id'].";";
            $returnedCategory = $connector->query($currentCategory);
            $fetchedCategory = $returnedCategory->fetch_array(MYSQLI_NUM);
            $quizCategoryToDisplay = $fetchedCategory[0];

            $numberOfQuizes = "SELECT COUNT(quizid) AS numberOf FROM quizcategories WHERE categoryID LIKE ".$selectedCategoryID.";";
            $returnedQuery = $connector->query($numberOfQuizes);
            $valuesFromNumber = $returnedQuery->fetch_array(MYSQLI_NUM);
            $nunmberOfResult = $valuesFromNumber[0];
    
            $quizesNames = "SELECT quizes.quizName FROM quizes INNER JOIN quizcategories ON quizes.ID = quizcategories.quizID INNER JOIN categories ON quizcategories.categoryID = categories.id WHERE categories.id LIKE ".$selectedCategoryID.";";
            $returnedNames = $connector->query($quizesNames);
    
            $valueCatcherQuizes = 1;
            $categoryIDValues = "";
            $questionsIDArray = [];
    
            $questionsIDQuery = "SELECT quizID FROM quizcategories WHERE categoryID LIKE ".$selectedCategoryID.";";
            $IDQueryResult = $connector->query($questionsIDQuery);
            if($IDQueryResult->num_rows > 0){
                while($row = $IDQueryResult->fetch_array(MYSQLI_NUM)){
                    array_push($questionsIDArray, $row[0]);
                }
            }
    
            for($i=0; $i < sizeof($questionsIDArray); $i += 1){
                if($valueCatcherQuizes < sizeof($questionsIDArray)){
                    $categoryIDValues .= $questionsIDArray[$i]."|";
                }
                else{
                    $categoryIDValues .= $questionsIDArray[$i];
                }
                $valueCatcherQuizes += 1;
            }
    
            $categoryValues = "";
            $valueCatcher = 1;
    
            if($returnedNames->num_rows > 0){
                while($row = $returnedNames->fetch_array(MYSQLI_NUM)){
                    if($valueCatcher < $nunmberOfResult){
                        $categoryValues .= $row[0]."|";
                    }
                    else{
                        $categoryValues .= $row[0];
                    }
                    $valueCatcher += 1;
                }
            } 
            else{
                echo "<script>console.log('Brak wyników.');</script>";
            }
            
            $connector->close();
            echo '<script>let quizNameHolder = document.getElementById("quizData"); quizNameHolder.value = "'.$categoryValues.'";</script>';
            echo '<script>let quizIDHolder = document.getElementById("quizIDData"); quizIDHolder.value = "'.$categoryIDValues.'";</script>';
            echo '<script>let numberHolder = document.getElementById("hiddenValue"); numberHolder.value = "'.$nunmberOfResult.'";</script>';
            echo '<script>let category = document.getElementById("category"); category.value = "'.$selectedCategoryID.'";</script>';
            echo '<script>let categoryToDisplay = document.getElementById("categoryToDisplay"); categoryToDisplay.value = "'.$quizCategoryToDisplay.'";</script>';
        ?>
        <script src="../js/quiz.js"></script>
    </div>
</body>
</html>