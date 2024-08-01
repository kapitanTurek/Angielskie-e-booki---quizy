<!DOCTYPE html>
<?php
    session_start();
    if($_SESSION['status'] == 1){
        header("Location: adminPanel.php");
        exit();
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
    
    <title>Angielskie-ebooki</title>
</head>
<body>
    <div class="container-fluid space">
        <div class="row">
            <div class="col-sm-6 sectionLogin" id="sectionLogin">
                <div class="row" id="supportSpot">
                    <div class="col-sm-1"></div>
                    <div class="col-sm-10 d-flex justify-content-center">
                        <div class="row formStyle">
                            <a class="navbar-brand phoneBrand" style="font-weight: 600; font-size: .99em;" href="../../index.html">Angielskie-ebooki</a><p>&nbsp</p>
                            <h1 class="writtenTitle" id="sectionTitle">Zaloguj się!</h1>
                            <form method="POST" action="loginHandler.php" id="form">
                                <div class="loginHolder" id="wholeLogin">
                                    <img src="../../icons/mail_icon.png" alt="login" class="menuIconNotInShape" />
                                    <input type="text" class="loginInputs" name="loginName" id="loginHolder" placeholder="Adres e-mail" /><br />
                                </div>
                                <div class="loginHolder" id="passwordHolder">
                                    <img src="../../icons/lock_icon.png" alt="login" class="menuIconNotInShape" />
                                    <input type="password" class="loginInputs" id="password" name="passwordValue" placeholder="Hasło" />
                                </div>
                                <br />
                                <p id="supportInformation"></p>
                                <p id="restoration">Zapomniałeś hasła? <a href="#" class="loginLink" onclick="getSupport()" id="interaction">Kliknij tutaj!</a></p>
                                <br />
                                <input type="submit" class="loginSubmit" id="submit" value="Zaloguj się" />
                            </form>
                        </div>
                    </div>
                    <div class="col-sm-1"></div>
                </div>
            </div>
            <div class="col-sm-6 sectionInformation" id="sectionInformation">
                <div class="col-sm-12 informationData">
                    <a class="navbar-brand" style="font-weight: 600; font-size: .99em;" href="../../index.html">Angielskie-ebooki</a><p>&nbsp</p>
                    <h3 class="writtenTitle">Wszystkie quizy w jednym miejscu - gdzie chcesz i kiedy chcesz</h3>
                </div>
                
            </div>
        </div>
    </div>
    <script src="../js/loginScript.js"></script>
</body>
</html>