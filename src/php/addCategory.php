<?php
    include "connectionCredentials.php";
    session_start();

    if($_SESSION['status'] == 0){
        header("Location: adminLogin.php");
        exit();
    }
    
    $connector = new mysqli($serverLocation, $loginName, $passwordToAccess, $databaseName);

    $categoryName = mysqli_real_escape_string($connector, $_POST['categoryName']);
    
    $lastIDquery = "SELECT categories.id FROM categories ORDER BY categories.id DESC LIMIT 1;";
    $lastIDResult = $connector->query($lastIDquery);
    $lastIDnumber = $lastIDResult->fetch_array(MYSQLI_NUM);
    $newIDValue = $lastIDnumber[0] + 1;
    
    
    $addCategoryQuery = "INSERT INTO categories(id, `name`) VALUES(".$newIDValue.", '".$categoryName."');";
    $queryResult = $connector->query($addCategoryQuery);
    
    $connector -> close();
    
    header("Location: adminCategories.php?success=1");
    exit();
?>