<?php
// Step 1: Establish a Database Connection
$conn = new mysqli('127.0.0.1:3307', 'root', '', 'dbms');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Step 2: Fetch product details based on product code
$productCode = $_GET['productCode'];
$sql = "SELECT product_name, mrp, rate FROM product WHERE product_code = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $productCode);
$stmt->execute();
$result = $stmt->get_result();

// Step 3: Send product details as JSON response
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    echo json_encode($row);
} else {
    echo json_encode(null); // Return null if product not found
}

// Step 4: Close the Connection
$stmt->close();
$conn->close();
?>
