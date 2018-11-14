<!DOCTYPE html>
<html>
<head>
    <title>OtterMart History View</title>
    <link href="css/styles.css" rel="stylesheet" type="text/css"/>
</head>
<body>
<?php
    include 'dbConnection.php';
    $conn = getDatabaseConnection("ottermart");
    
    $productId = $_GET['productId'];
    
    $sql = "SELECT * 
            FROM om_product 
            NATURAL JOIN om_purchase 
            WHERE productId = :pId";
            
    $np = array();
    $np[":pId"] = $productId;
    
    $stmt = $conn->prepare($sql);
    $stmt->execute($np);
    $records = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    if (count($records) == 0)
    {
        echo "<h1 class='na'>No History found for this item.</h1>";
    }
    else 
    {
        
    echo "<div class='historyItem'>";
    echo $records[0]['productName'] . "<br/>";
    echo "<img src='" . $records[0]['productImage'] . "' width='200'/><br/>";
    
    foreach($records as $record) {
        
        echo "<span ='item'>";
        echo "Purchase Date: " . $record['purchaseDate'] . "<br/>";
        echo "Unit Price: " . $record['unitPrice'] . "<br/>";
        echo "Quantity: " . $record['quantity'] . "<br/>";
        echo "</span>";
    }
    echo "<div class='historyItem'>";
    
    }
?>

<a class="btn-danger" href="index.php">Return</a>
</body>
</html>