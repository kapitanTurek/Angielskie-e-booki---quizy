<!DOCTYPE html>
<?php
    session_start();

    if($_SESSION['status'] == 0){
        header("Location: adminLogin.php");
        exit();
    }
    
    if(isset($_GET['deleted']) && $_GET['deleted'] == 1){
        echo "<script>alert('Operacja usunięcia zakończona sukcesem!')</script>";

        // do rozwinięcia - pojawi się ładniejszy komunikat, po zatwierdzeniu którego nastąpi przekierowanie na odpowiednią stronę.
        // header("Location: adminPanelPreview.php");
        // exit;
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
                            <a href="#" class="navLink"><img src="../../icons/listWhite.png" alt="pencile" class="menuIcon"/>Przeglądaj quizy</a>
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
            <div class="col-sm-10 infos" id="infos">
                <input type="hidden" id="hiddenValue" value="0" />
                <input type="hidden" id="quizIDData" value="" />
                <input type="hidden" id="quizData" value="" />
            </div>
        </div>
    </div>

    <?php
        include "connectionCredentials.php";
        $connector = new mysqli($serverLocation, $loginName, $passwordToAccess, $databaseName);
        
        $numberOfQuizes = "SELECT COUNT(id) AS numberOf FROM quizes;";
        $returnedQuery = $connector->query($numberOfQuizes);
        $valuesFromNumber = $returnedQuery->fetch_array(MYSQLI_NUM);
        $nunmberOfResult = $valuesFromNumber[0];

        $quizesNames = "SELECT quizName FROM quizes;";
        $returnedNames = $connector->query($quizesNames);

        $valueCatcherQuizes = 1;
        $quizIDValues = "";
        $questionsIDArray = [];

        $questionsIDQuery = "SELECT ID FROM quizes;";
        $IDQueryResult = $connector->query($questionsIDQuery);
        if($IDQueryResult->num_rows > 0){
            while($row = $IDQueryResult->fetch_array(MYSQLI_NUM)){
                array_push($questionsIDArray, $row[0]);
            }
        }

        for($i=0; $i < sizeof($questionsIDArray); $i += 1){
            if($valueCatcherQuizes < sizeof($questionsIDArray)){
                $quizIDValues .= $questionsIDArray[$i].", ";
            }
            else{
                $quizIDValues .= $questionsIDArray[$i];
            }
            $valueCatcherQuizes += 1;
        }

        $quizValues = "";
        $valueCatcher = 1;

        if($returnedNames->num_rows > 0){
            while($row = $returnedNames->fetch_array(MYSQLI_NUM)){
                if($valueCatcher < $nunmberOfResult){
                    $quizValues .= $row[0].", ";
                }
                else{
                    $quizValues .= $row[0];
                }
                $valueCatcher += 1;
            }
        } 
        else{
            echo "<script>console.log('Brak wyników.');</script>";
        }
        
        $connector->close();
        echo '<script>let quizNameHolder = document.getElementById("quizData"); quizNameHolder.value = "'.$quizValues.'";</script>';
        echo '<script>let quizIDHolder = document.getElementById("quizIDData"); quizIDHolder.value = "'.$quizIDValues.'";</script>';
        echo '<script>let numberHolder = document.getElementById("hiddenValue"); numberHolder.value = "'.$nunmberOfResult.'";</script>';
    ?>

    <script src="../js/quizPreview.js"></script>
    <script src="https://requirejs.org/docs/release/2.3.5/minified/require.js"></script>
</body>
</html>