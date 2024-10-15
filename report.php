<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Stock Report</title>
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
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
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
    <div class="container">
        <h1>Stock Report</h1>
        <table>
            <thead>
                <tr>
                    <th>Product Code</th>
                    <th>Product Name</th>
                    <th>Remaining Stock</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Step 1: Establish a Database Connection
                $conn = new mysqli('localhost:3306', 'root', '', 'dbms');
                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                }

                // Step 2: Retrieve data from the database
                $sql = "SELECT stock.pro_code, product.product_name, stock.stock
                        FROM stock
                        INNER JOIN product ON stock.pro_code = product.product_code";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    // Output data of each row
                    while($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row["pro_code"] . "</td>";
                        echo "<td>" . $row["product_name"] . "</td>";
                        echo "<td>" . $row["stock"] . "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='3'>No data available</td></tr>";
                }

                // Step 3: Close the Connection
                $conn->close();
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>
