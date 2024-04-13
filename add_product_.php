<?php
    $product_code = $_POST['product_code'];
    $product_name = $_POST['product_name'];
    $mrp = $_POST['mrp'];
    $rate = $_POST['rate'];
    $p_rate = $_POST['p_rate'];    

    $conn = new mysqli('127.0.0.1:3307','root','','dbms');
    if($conn->connect_error)
    {
        die('connection Failed : ' . $conn->connect_error);
    }
    
    else
    {
        $stmt = $conn->prepare("insert into product(product_code,product_name,mrp,rate,p_rate) values('$product_code','$product_name','$mrp','$rate','$p_rate')");

        $stmt->execute();
        $stmt->close();
        echo "added successfully...";
        $conn->close();
    }
?>