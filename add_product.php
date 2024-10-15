<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if the form is submitted to add a new product
    if (isset($_POST['add_product'])) {
        $product_code = $_POST['product_code'];
        $product_name = $_POST['product_name'];
        $mrp = $_POST['mrp'];
        $rate = $_POST['rate'];
        $p_rate = $_POST['p_rate'];

        $conn = new mysqli('127.0.0.1:3306', 'root', '', 'dbms');
        if ($conn->connect_error) {
            die('connection Failed : ' . $conn->connect_error);
        } else {
            $stmt = $conn->prepare("INSERT INTO product (product_code, product_name, mrp, rate, p_rate) VALUES (?, ?, ?, ?, ?)");
            $stmt->bind_param("ssdds", $product_code, $product_name, $mrp, $rate, $p_rate);
            $stmt->execute();
            $stmt->close();

            $stmt_stock = $conn->prepare("INSERT INTO stock (pro_code, stock) VALUES (?, 0)");
            $stmt_stock->bind_param("s", $product_code);
            $stmt_stock->execute();
            $stmt_stock->close();

            echo "Added successfully...";
            $conn->close();
        }
    }

    // Check if the delete product form is submitted
    if (isset($_POST['delete_product'])) {
        $product_code_to_delete = $_POST['delete_product'];

        $conn = new mysqli('127.0.0.1:3306', 'root', '', 'dbms');
        if ($conn->connect_error) {
            die('Connection Failed : ' . $conn->connect_error);
        } else {
            $stmt = $conn->prepare("DELETE FROM product WHERE product_code = ?");
            $stmt->bind_param("s", $product_code_to_delete);

            if ($stmt->execute()) {
                echo "Product deleted successfully.";
            } else {
                echo "Error deleting product: " . $stmt->error;
            }

            $stmt->close();
            $conn->close();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Management</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f2f2f2;
        }

        h1 {
            text-align: center;
            margin-top: 50px;
        }

        form {
            width: 50%;
            margin: 0 auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        label {
            font-weight: bold;
        }

        input[type="text"],
        input[type="number"],
        button {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }

        button {
            background-color: #4caf50;
            color: #fff;
            cursor: pointer;
        }

        button:hover {
            background-color: #45a049;
        }

        input:focus,
        button:focus {
            outline: none;
            border-color: #4caf50;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            padding: 8px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <h1>Product Management</h1>

    <!-- Form to add a new product -->
    <form action="" method="post">
        <label for="product_code">Product Code:</label><br>
        <input type="text" id="product_code" name="product_code" required><br><br>

        <label for="product_name">Product Name:</label><br>
        <input type="text" id="product_name" name="product_name" required><br><br>

        <label for="mrp">MRP:</label><br>
        <input type="number" id="mrp" name="mrp" min="0" step="0.01" required><br><br>

        <label for="rate">Rate:</label><br>
        <input type="number" id="rate" name="rate" min="0" step="0.01" required><br><br>

        <label for="p_rate">Purchase Rate:</label><br>
        <input type="number" id="p_rate" name="p_rate" min="0" step="0.01" required><br><br>

        <button type="submit" name="add_product">Add Product</button>
    </form>

    <!-- Display saved products -->
    <?php
    $conn = new mysqli('127.0.0.1:3306', 'root', '', 'dbms');
    if ($conn->connect_error) {
        die('Connection Failed : ' . $conn->connect_error);
    } else {
        $sql = "SELECT * FROM product";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            echo "<h2>Product List</h2>";
            echo "<table>";
            echo "<tr><th>Product Code</th><th>Product Name</th><th>MRP</th><th>Rate</th><th>Purchase Rate</th><th>Action</th></tr>";
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row['product_code'] . "</td>";
                echo "<td>" . $row['product_name'] . "</td>";
                echo "<td>" . $row['mrp'] . "</td>";
                echo "<td>" . $row['rate'] . "</td>";
                echo "<td>" . $row['p_rate'] . "</td>";
                echo "<td><form method='post'><input type='hidden' name='delete_product' value='" . $row['product_code'] . "'><button type='submit'>Delete</button></form></td>";
                echo "</tr>";
            }
            echo "</table>";
        } else {
            echo "<p>No products found.</p>";
        }

        $conn->close();
    }
    ?>
</body>
</html>
