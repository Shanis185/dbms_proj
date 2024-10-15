<?php
// Step 1: Establish a Database Connection
$conn = new mysqli('localhost:3306', 'root', '', 'dbms');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Step 2: Save Invoice Details into Database
$invoiceNumber = $_POST['invoiceNumber'];
$customer_no = $_POST['customer_no'];

// Initialize total amount
$total = 0;

// Iterate over each product in the invoice
foreach ($_POST['productCode'] as $key => $productCode) {
    $quantity = $_POST['quantity'][$key];

    // Fetch product details from the product table based on product code
    $sql_product = "SELECT product_name, mrp, rate FROM product WHERE product_code = ?";
    $stmt_product = $conn->prepare($sql_product);
    $stmt_product->bind_param("s", $productCode);
    $stmt_product->execute();
    $result_product = $stmt_product->get_result();

    if ($result_product->num_rows > 0) {
        // Fetch product details
        $row_product = $result_product->fetch_assoc();
        $productName = $row_product['product_name'];
        $mrp = $row_product['mrp'];
        $rate = $row_product['rate'];

        // Calculate total amount for this product
        $totalItemAmount = $rate * $quantity;

        // Add total item amount to the total amount
        $total += $totalItemAmount;

        // Insert invoice details into the invoice table
        $sql_insert_invoice = "INSERT INTO invoice (invoice_no, customer_number,  quantity, total_amount) 
                               VALUES (?, ?, ?, ?, ?)";
        $stmt_insert_invoice = $conn->prepare($sql_insert_invoice);
        $stmt_insert_invoice->bind_param("sssid", $invoiceNumber, $customer_no, $quantity, $totalItemAmount);
        $stmt_insert_invoice->execute();

        // Update the stock in the stock table by subtracting the quantity sold
        $sql_update_stock = "UPDATE stock SET stock = stock - ? WHERE pro_code = ?";
        $stmt_update_stock = $conn->prepare($sql_update_stock);
        $stmt_update_stock->bind_param("is", $quantity, $productCode);
        $stmt_update_stock->execute();
    } else {
        echo "Invalid product code!";
    }
}

// Update total amount in the invoice table
$sql_update_total = "UPDATE invoice SET total_amount = ? WHERE invoice_no = ?";
$stmt_update_total = $conn->prepare($sql_update_total);
$stmt_update_total->bind_param("ds", $total, $invoiceNumber);
$stmt_update_total->execute();

echo "Invoice saved successfully.";

// Step 3: Close the Connection
$stmt_product->close();
$stmt_insert_invoice->close();
$stmt_update_stock->close();
$stmt_update_total->close();
$conn->close();
?>