<?php
// Database connection
$conn = new mysqli('127.0.0.1:3306', 'root', '', 'dbms');
if ($conn->connect_error) {
    die('Connection Failed: ' . $conn->connect_error);
} 

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the product code and quantity from the request
    $productCode = $_POST['productCode'];
    $quantity = intval($_POST['quantity']);
    
    // First, check the current stock level
    $checkStockQuery = "SELECT stock FROM stock WHERE pro_code = ?";
    $stmt = $conn->prepare($checkStockQuery);
    $stmt->bind_param("s", $productCode);
    $stmt->execute();
    $stmt->bind_result($currentStock);
    $stmt->fetch();
    $stmt->close();

    // Check if there is sufficient stock
    if ($currentStock >= $quantity) {
        // Update the stock in the database
        $updateStockQuery = "UPDATE stock SET stock = stock - ? WHERE pro_code = ?";
        $stmt = $conn->prepare($updateStockQuery);
        $stmt->bind_param("is", $quantity, $productCode);
        $stmt->execute();

        // Check if the stock was updated successfully
        if ($stmt->affected_rows > 0) {
            echo "success"; // Stock updated successfully
        } else {
            echo "error"; // Handle case when stock could not be updated
        }
    } else {
        echo "insufficient_stock"; // Notify the frontend about insufficient stock
    }
}

// Close the database connection
$conn->close();
?>
