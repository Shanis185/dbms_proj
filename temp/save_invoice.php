<?php
// Step 1: Establish a Database Connection
$conn = new mysqli('127.0.0.1:3306', 'root', '', 'dbms');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Step 2: Generate Invoice Number
// You can generate invoice numbers based on your own logic, for example, incrementing numbers, combination of date and a unique identifier, etc.
$invoiceNumber = "INV-" . date("Ymd") . "-" . uniqid();
$date = date("Y-m-d"); // Get the current date in the format YYYY-MM-DD

// Step 3: Save Invoice Details into Database
$productCode = $_POST['productCode'];
$quantity = $_POST['quantity'];
$customer_no= $_POST['customer_no'];

// Fetch product details from database based on product code
$sql = "SELECT product_name, mrp, rate FROM product WHERE product_code = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $productCode);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    // Fetch product details
    $row = $result->fetch_assoc();
    $productName = $row['product_name'];
    $mrp = $row['mrp'];
    $rate = $row['rate'];

    // Calculate total amount
    $total = $rate * $quantity;

    // Insert invoice details into database
    $sql = "INSERT INTO invoice (invoice_no,customer_number, invoice_date, total_amount) 
            VALUES (?,?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssd", $invoiceNumber,$customer_no, $date, $total);
    $stmt->execute();

    echo "Invoice saved successfully.";
} else {
    echo "Invalid product code!";
}

// Step 4: Close the Connection
$stmt->close();
$conn->close();
?>
