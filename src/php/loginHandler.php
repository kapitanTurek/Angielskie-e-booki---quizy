<?php
    include "connectionCredentials.php";
    session_start();

    $userLogin = $_POST['loginName'];
    $userPassword = $_POST['passwordValue'];
    $userPasswordToCompare = hash('sha256', $userPassword);
    $_SESSION['status'] = 0;

    $connector = new mysqli($serverLocation, $loginName, $passwordToAccess, $databaseName);

    $accountsQuery = "SELECT `password` FROM accounts WHERE email LIKE '".$userLogin."';";
    $collectedData = $connector->query($accountsQuery);
    if($collectedData->num_rows > 0){
        $accountTransformed = $collectedData->fetch_array(MYSQLI_NUM);
        $dbPassword = $accountTransformed[0];
    }
    else{
        header("Location: adminLogin.php");
        exit();
    }

    if($userPasswordToCompare == $dbPassword){
        $_SESSION['status'] = 1;
        header("Location: adminLogin.php");
        exit();
    }
    else{
        header("Location: adminLogin.php");
        exit();
    }
?>