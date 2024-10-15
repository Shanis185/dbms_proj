<?php
    // Check if the form is submitted to add a new customer
    if(isset($_POST['add_customer'])) {
        $customer_no = $_POST['customer_no'];
        $customer_name = $_POST['customer_name'];
        $ph_no = $_POST['ph_no'];
        $place = $_POST['place'];    

        $conn = new mysqli('localhost:3306','root','','dbms');
        if($conn->connect_error) {
            die('Connection Failed : ' . $conn->connect_error);
        } else {
            $stmt = $conn->prepare("INSERT INTO customer (cust_no, customer_name, ph_no, place) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("isss", $customer_no, $customer_name, $ph_no, $place);
            
            if ($stmt->execute()) {
                echo "Customer added successfully.";
            } else {
                echo "Error adding customer: " . $stmt->error;
            }
            
            $stmt->close();
            $conn->close();
        }
    }

    // Check if the delete customer form is submitted
    if(isset($_POST['delete_customer'])) {
        $customer_no_to_delete = $_POST['delete_customer'];
        
        $conn = new mysqli('localhost:3306','root','','dbms');
        if($conn->connect_error) {
            die('Connection Failed : ' . $conn->connect_error);
        } else {
            $stmt = $conn->prepare("DELETE FROM customer WHERE cust_no = ?");
            $stmt->bind_param("i", $customer_no_to_delete);
            
            if ($stmt->execute()) {
                echo "Customer deleted successfully.";
            } else {
                echo "Error deleting customer: " . $stmt->error;
            }
            
            $stmt->close();
            $conn->close();
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Management</title>
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
    <h1>Customer Management</h1>
    
    <!-- Form to add a new customer -->
    <form action="" method="post">
        <label for="customer_no">Customer Number:</label><br>
        <input type="text" id="customer_no" name="customer_no" required><br><br>
        
        <label for="customer_name">Customer Name:</label><br>
        <input type="text" id="customer_name" name="customer_name" required><br><br>
        
        <label for="ph_no">Phone Number:</label><br>
        <input type="text" id="ph_no" name="ph_no" required><br><br>

        <label for="place">Place:</label><br>
        <input type="text" id="place" name="place" required><br><br>

        <button type="submit" name="add_customer">Add Customer</button>
    </form>

    <!-- Display saved customers -->
    <?php
        $conn = new mysqli('localhost:3306','root','','dbms');
        if($conn->connect_error) {
            die('Connection Failed : ' . $conn->connect_error);
        } else {
            $sql = "SELECT cust_no, customer_name, ph_no, place FROM customer";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                echo "<h2>Saved Customers</h2>";
                echo "<table>";
                echo "<tr><th>Customer No</th><th>Name</th><th>Phone No</th><th>Place</th><th>Action</th></tr>";
                while($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>".$row['cust_no']."</td>";
                    echo "<td>".$row['customer_name']."</td>";
                    echo "<td>".$row['ph_no']."</td>";
                    echo "<td>".$row['place']."</td>";
                    echo "<td><form method='post'><input type='hidden' name='delete_customer' value='".$row['cust_no']."'><button type='submit'>Delete</button></form></td>";
                    echo "</tr>";
                }
                echo "</table>";
            } else {
                echo "<p>No customers found.</p>";
            }

            $conn->close();
        }
    ?>
</body>
</html>
