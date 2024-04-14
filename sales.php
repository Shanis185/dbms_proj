<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice</title>
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
        }
        th, td {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <h1>Invoice</h1>
    <form id="invoiceForm">
        <label for="productCode">Product Code:</label>
        <input type="text" id="productCode" name="productCode"><br><br>
        <label for="quantity">Quantity:</label>
        <input type="number" id="quantity" name="quantity" min="1"><br><br>
        <button type="button" onclick="calculateTotal()">Add Item</button>
    </form>
    <br>
    <table id="invoiceTable">
        <thead>
            <tr>
                <th>Product Name</th>
                <th>MRP</th>
                <th>Rate</th>
                <th>Quantity</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody id="invoiceBody">
            <!-- Invoice items will be added here -->
        </tbody>
    </table>

    <script>
        function calculateTotal() {
            var productCode = document.getElementById("productCode").value;
            var quantity = parseInt(document.getElementById("quantity").value);
            
            // Assuming you have a JavaScript object containing product details
            var productDetails = {
                "12345": { name: "Product A", mrp: 100, rate: 80 },
                "67890": { name: "Product B", mrp: 150, rate: 120 }
                // Add more products as needed
            };

            if (productDetails.hasOwnProperty(productCode)) {
                var product = productDetails[productCode];
                var productName = product.name;
                var mrp = product.mrp;
                var rate = product.rate;
                var total = rate * quantity;

                var newRow = "<tr>";
                newRow += "<td>" + productName + "</td>";
                newRow += "<td>" + mrp + "</td>";
                newRow += "<td>" + rate + "</td>";
                newRow += "<td>" + quantity + "</td>";
                newRow += "<td>" + total + "</td>";
                newRow += "</tr>";

                document.getElementById("invoiceBody").innerHTML += newRow;
            } else {
                alert("Invalid product code!");
            }
        }
    </script>

    <?php
    // Step 1: Establish a Database Connection
    $conn = new mysqli('127.0.0.1:3307', 'root', '', 'dbms');
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Step 2: Query the Database to get product details
    $sql = "SELECT product_code, product_name, mrp, rate FROM product";
    $result = $conn->query($sql);

    // Step 3: Fetch Data
    if ($result->num_rows > 0) {
        // Step 4: Loop through results and display data
        while($row = $result->fetch_assoc()) {
            // Assuming product_code is unique and used as a key in the productDetails JavaScript object
            echo "<script>";
            echo "productDetails['" . $row['product_code'] . "'] = { name: '" . $row['product_name'] . "', mrp: " . $row['mrp'] . ", rate: " . $row['rate'] . " };";
            echo "</script>";
        }
    }

    // Step 5: Close the Connection
    $conn->close();
    ?>
</body>
</html>
