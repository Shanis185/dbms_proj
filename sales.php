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
            };
            xhr.send();
        }
    </script>
</body>
</html>
