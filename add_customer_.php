<?php
    $customer_no = $_POST['customer_no'];
    $customer_name = $_POST['customer_name'];
    $ph_no = $_POST['ph_no'];
    $place = $_POST['place'];    

    $conn = new mysqli('localhost:3306','root','','dbms');
    if($conn->connect_error)
    {
        die('connection Failed : ' . $conn->connect_error);
    }
    
    else
    {
        $stmt = $conn->prepare("insert into customer(cust_no,customer_name,ph_no,place) values('$customer_no','$customer_name','$ph_no','$place')");

        $stmt->execute();
        $stmt->close();
        echo "added successfully...";
        $conn->close();
    }
?>