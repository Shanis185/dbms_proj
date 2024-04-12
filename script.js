<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sales Page</title>
    <style>
        /* Basic styling */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }
        .container {
            max-width: 800px;
            margin: 20px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h1 {
            text-align: center;
        }
        select, input[type="number"], button {
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Sales Page</h1>
        <form id="salesForm">
            <label for="product">Select Product:</label>
            <select id="product">
                <option value="product1">Product 1 ($10)</option>
                <option value="product2">Product 2 ($20)</option>
                <option value="product3">Product 3 ($30)</option>
            </select><br>
            <label for="quantity">Quantity:</label>
            <input type="number" id="quantity" min="1" value="1"><br>
            <button type="button" onclick="calculateTotal()">Add to Cart</button><br>
            <label for="total">Total Amount:</label>
            <input type="text" id="total" readonly>
        </form>
    </div>

    <script>
        function calculateTotal() {
            // Get selected product and quantity
            var product = document.getElementById("product").value;
            var quantity = document.getElementById("quantity").value;

            // Calculate total amount
            var price;
            switch (product) {
                case "product1":
                    price = 10;
                    break;
                case "product2":
                    price = 20;
                    break;
                case "product3":
                    price = 30;
                    break;
                default:
                    price = 0;
                    break;
            }
            var total = price * quantity;

            // Display total amount
            document.getElementById("total").value = "$" + total.toFixed(2);
        }
    </script>
</body>
</html>
