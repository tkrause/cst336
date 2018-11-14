<?php
    include 'dbConnection.php';
    
    $conn = getDatabaseConnection("ottermart");
    
    function displayCategories()
    {
        global $conn;
        
        $sql = "SELECT catId, catName from om_category ORDER BY catName";
        
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $records = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach($records as $record) {
            echo "<option value='".$record["catId"]."'>".$record["catName"]."</option>";
        }
    }
    
    function displaySearchResults()
    {
        global $conn;
        
        if (isset($_GET['searchForm'])) {
            echo "<h3>Products Found: </h3>";
            echo "<span class='itemHeader'>";
            echo "<span class='history'> History </span>";
            echo "<span class='itemName'>Product Name </span>";
            echo "<span class='itemPrice'>Price </span>";
            echo "<span class='itemDesc'>Description </span>";
            echo "</span>";
            echo " <br/>";
            echo "<hr>";
            
            //Query below prevents SQL injection style attack?
            $namedParams = array();
            
            $sql = "SELECT * FROM om_product WHERE 1";
            
            // Checks if user typed something for product.
            if (!empty($_GET['product'])) {
                $sql .= " AND (productName LIKE :productName";
                $sql .= " OR productDescription LIKE :productName)";
                $namedParams[":productName"] = "%".$_GET['product'] . "%";
            }
            
            // Checks if user typed something for category
            if (!empty($_GET['category'])) {
                $sql .= " AND catId = :categoryId";
                $namedParams[":categoryId"] = $_GET['category'];
            }
            
            // Checks if user typed something for priceFrom
            if (!empty($_GET['priceFrom'])) {
                $sql .= " AND price >= :priceFrom";
                $namedParams[":priceFrom"] = $_GET['priceFrom'];
            }
            
            // Checks if user typed something for priceTo
            if (!empty($_GET['priceTo'])) {
                $sql .= " AND price <= :priceTo";
                $namedParams[":priceTo"] = $_GET['priceTo'];
            }
            
            if (isset($_GET['orderBy'])) {
                if ($_GET['orderBy'] == "price"){
                    $sql .= " ORDER BY price";
                } else {
                    $sql .= " ORDER BY productName";
                }
            }
            
            
            $stmt = $conn->prepare($sql);
            $stmt->execute($namedParams);
            $records = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            echo "<table>";
            
            foreach($records as $record) {
                echo "<tr class='item'>";
                echo "<td class='history'><a href=\"purchaseHistory.php?productId=".$record['productId']."\"> History </a></td>";
                echo "<td class='itemName'>".$record['productName']."</td>";
                echo "<td class='itemPrice'>$".$record['price']."</td>";
                echo "<td class='itemDesc'>".$record['productDescription']."</td>";
                echo "</tr>";
            }
            
            echo "</table>";
        }
    }
?>

<!DOCTYPE html>
<html>
    <head>
        <title>OtterMart Product Search</title>
        <link href="css/styles.css" rel="stylesheet" type="text/css"/>
    </head>
    <body>
        <header>
            <h1>OtterMart Product Search</h1>
        </header>

        <div id="content">
            <div id="menu">
                <form>
                    <div id="search">
                        Product: <input type="text" name="product"/>

                        <br/>
                        Category:
                            <select name="category">
                                <option value="">Select One</option>
                                <?=displayCategories() ?>
                            </select>
                        <br/>
                        <input id="searchButton" type="submit" value="Search" name="searchForm"/>
                    </div>

                    <div id="options">
                        Price: From <input type="text" name="priceFrom" size="7"/>
                               To   <input type="text" name="priceTo" size="7"/>
                        <br/>
                        Order result by:
                        <br/>

                        <input type="radio" name="orderBy" value="price"/>Price<br>
                        <input type="radio" name="orderBy" value="name"/>Name
                    </div>

                </form>
                <br/><br/><br/>
            </div>

            <?= displaySearchResults() ?>
        </div>

        <footer>
            CST 336. 2018 &copy; Krause <br />
            <strong>Disclamer:</strong> The information in this webpage is fictitous. <br />
            It is used for academic purposes only.
            <br /><br />
            <img src="/hw3/img/csumb.png" alt="CSUMB logo">
        </footer>
    </body>
</html>