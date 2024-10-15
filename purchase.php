<?php
// Include your database connection code here
// Example: include('db_connection.php');

// Retrieve form data
$product_code = $_POST['product_code'];
$quantity = $_POST['quantity'];

// Validate input (you might want to do more robust validation)
if(empty($product_code) || empty($quantity)) {
    echo "Please fill in all fields.";
    exit;
}

// Process the purchase
try {
    // Connect to your database
    $pdo =new mysqli('localhost:3306', 'root', '', 'dbms');


    // Prepare a query to check if the product exists in the stock table
$stmt = $pdo->prepare("SELECT COUNT(*) FROM stock WHERE pro_code = ?");
$stmt->bind_param('s', $product_code);
$stmt->execute();
$stmt->bind_result($count);
$stmt->fetch();
$stmt->close();

if ($count == 0) {
    // If the product does not exist in the stock table, check if it exists in the product table
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM product WHERE pro_code = ?");
    $stmt->bind_param('s', $product_code);
    $stmt->execute();
    $stmt->bind_result($count);
    $stmt->fetch();
    $stmt->close();

    if ($count > 0) {
        // If the product exists in the product table, insert it into the stock table with a stock of zero
        $stmt = $pdo->prepare("INSERT INTO stock (pro_code, stock) VALUES (?, 0)");
        $stmt->bind_param('s', $product_code);
        $stmt->execute();
        $stmt->close();
    } else {
        // If the product does not exist in the product table, display an error message
        echo "Product not found.";
        exit;
    }
}

// Now, proceed to update the stock
$stmt = $pdo->prepare("UPDATE stock SET stock = stock + ? WHERE pro_code = ?");
$stmt->bind_param('ss', $quantity, $product_code);
$stmt->execute();

// Check if any rows were affected
if ($stmt->affected_rows > 0) {
    echo "Purchase successful. Stock updated.";
} else {
    echo "Failed to update stock.";
}

$stmt->close();

    

} catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>
