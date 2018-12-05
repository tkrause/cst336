<?php

    include '../../lab5/dbConnection.php';
    $conn = getDatabaseConnection("ottermart");
    
    $sql = "SELECT *, YEAR(CURDATE()) - yob age
            FROM pets
            WHERE id = :id";

    $statement = $conn->prepare($sql);
    $ds = array("id"=>$_GET['id']);
    $statement->execute($ds);
    $records = $statement->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($records[0]);