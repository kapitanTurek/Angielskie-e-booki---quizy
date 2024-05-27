<?php
    include "connectionCredentials.php";
    session_start();

    if($_SESSION['status'] == 0){
        header("Location: adminLogin.php");
        exit();
    }
    
    $connector = new mysqli($serverLocation, $loginName, $passwordToAccess, $databaseName);

    $errorCode = 0;

    echo "<script>console.log('".$_GET['id']." ---> ".gettype($_GET['id'])."');</script>";
    
    if($GET['id'] == "0" || $_GET['id'] == 0){
        $errorCode = 2;
    }
    else{
        $updateQuery = "UPDATE quizcategories SET categoryID = 0 WHERE categoryID LIKE ".$_GET['id'].";";
        $processUpdate = $connector->query($updateQuery);
        echo "<p>console.log('Zmieniam rekordy kategorii o ID: ".$_GET['id']."')</p>";
        
        $deleteCategory = "DELETE FROM categories WHERE id LIKE ".$_GET['id'].";";
        $processDelete = $connector->query($deleteCategory);
        echo "<p>console.log('Usuwam rekordy o ID: ".$_GET['id']."')</p>";
        $errorCode += 1;
    }

    $connector->close();

    header("Location: adminCategories.php?deleted=".$errorCode."");
    exit;
?>