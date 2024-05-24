<!DOCTYPE html>
<?php
    session_start();

    if($_SESSION['status'] == 0){
        header("Location: adminLogin.php");
        exit();
    }

    if(isset($_GET['success']) && $_GET['success'] == 1){
        echo "<script>alert('Operacja zakończona sukcesem!');</script>";
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
                            <a href="#" class="navLink"><img src="../../icons/pencileWhite.png" alt="pencile" class="menuIcon"/>Stwórz quiz</a>
                        </li>
                        <li>
                            <a href="adminPanelPreview.php" class="navLink"><img src="../../icons/listWhite.png" alt="pencile" class="menuIcon"/>Przeglądaj quizy</a>
                            <input type="hidden" id="hiddenCategories" value="" />
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
    ?>

    <script src="../js/adminScript.js" onload="formGenerator('Witaj w generatorze quizów!', 'adminHandler.php')"></script>
    <script src="https://requirejs.org/docs/release/2.3.5/minified/require.js"></script>
</body>
</html>