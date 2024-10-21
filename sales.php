<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
            margin: 0;
            padding: 0;
        }
        h1 {
            text-align: center;
            margin-top: 20px;
        }
        form {
            text-align: center;
            margin-bottom: 20px;
        }
        label {
            display: block;
            margin-bottom: 5px;
        }
        input[type="number"],
        input[type="text"],
        button {
            padding: 8px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        button {
            background-color: #4CAF50;
            color: white;
            border: none;
            cursor: pointer;
        }
        button:hover {
            background-color: #45a049;
        }
        table {
            border-collapse: collapse;
            width: 100%;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        #invoiceTotal {
            text-align: right;
            margin-right: 20px;
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <h1>Invoice</h1>
    <div id="invoiceNumberDisplay">
        Invoice Number: <span id="invoiceNumber"></span>
    </div>
    <form id="invoiceForm" method="post" action="save_invoice.php">
        <label for="customer_no">Customer Number:</label>
        <input type="number" id="customer_no" name="customer_no" required><br><br>
        <label for="productCode">Product Code:</label>
        <input type="text" id="productCode" name="productCode" required><br><br>
        <label for="quantity">Quantity:</label>
        <input type="number" id="quantity" name="quantity" min="1" required><br><br>
        <button type="button" onclick="calculateTotal()">Add Item</button>
        <button type="submit" name="saveInvoice">Save Invoice</button>
    </form>
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
    <div id="invoiceTotal">
        <p>Total Amount: <span id="totalAmount">0</span></p>
    </div>

    <script>
        var invoiceNumber = ""; // Initialize invoice number variable
        var totalAmount = 0; // Total amount of all items

        function calculateTotal() {
            var productCode = document.getElementById("productCode").value;
            var quantity = parseInt(document.getElementById("quantity").value);
            
            // AJAX request to fetch product details from PHP script
            var xhr = new XMLHttpRequest();
            xhr.open("GET", "get_product_details.php?productCode=" + productCode, true);
            xhr.onreadystatechange = function () {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    var productDetails = JSON.parse(xhr.responseText);
                    if (productDetails) {
                        var productName = productDetails.product_name;
                        var mrp = productDetails.mrp;
                        var rate = productDetails.rate;
                        var totalItemAmount = rate * quantity;

                        var newRow = "<tr>";
                        newRow += "<td>" + productName + "</td>";
                        newRow += "<td>" + mrp + "</td>";
                        newRow += "<td>" + rate + "</td>";
                        newRow += "<td>" + quantity + "</td>";
                        newRow += "<td>" + totalItemAmount + "</td>";
                        newRow += "</tr>";

                        document.getElementById("invoiceBody").innerHTML += newRow;

                        totalAmount += totalItemAmount; // Add total item amount to the total amount
                        document.getElementById("totalAmount").textContent = totalAmount;

                        // Update stock
                        updateStock(productCode, quantity);
                    } else {
                        alert("Invalid product code!");
                    }
                }
            };
            xhr.send();
        }

        // Function to update stock
        function updateStock(productCode, quantity) {
            var xhrStock = new XMLHttpRequest();
            xhrStock.open("POST", "update_stock.php", true);
            xhrStock.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhrStock.onreadystatechange = function () {
                if (xhrStock.readyState === 4 && xhrStock.status === 200) {
                    var response = xhrStock.responseText;
                    if (response !== "success") {
                        alert("Failed to update stock for product code: " + productCode);
                    }
                }
            };
            xhrStock.send("productCode=" + productCode + "&quantity=" + quantity);
        }

        // Function to set the generated invoice number
        function setInvoiceNumber(number) {
            invoiceNumber = number;
            document.getElementById("invoiceNumber").textContent = invoiceNumber;
        }

        // AJAX request to fetch and set the generated invoice number
        var xhrInvoice = new XMLHttpRequest();
        xhrInvoice.open("GET", "generate_invoice_number.php", true);
        xhrInvoice.onreadystatechange = function () {
            if (xhrInvoice.readyState === 4 && xhrInvoice.status === 200) {
                var generatedNumber = xhrInvoice.responseText;
                setInvoiceNumber(generatedNumber); // Set the generated invoice number
            }
        };
        xhrInvoice.send();
    </script>
</body>
</html>
