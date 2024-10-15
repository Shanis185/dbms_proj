<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Customer</title>
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
            max-width: 400px;
            margin: 0 auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        label {
            display: block;
            margin-bottom: 5px;
        }
        input[type="number"],
        input[type="text"],
        button {
            width: 100%;
            padding: 8px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
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
    </style>
</head>
<body>
    <h1>Add Customer</h1>
    <form action="add_customer_.php" method="post">
        <label for="customer_no">Customer Number:</label>
        <input type="number" id="customer_no" name="customer_no" required><br><br>
        
        <label for="customer_name">Customer Name:</label>
        <input type="text" id="customer_name" name="customer_name" required><br><br>
        
        <label for="ph_no">Phone Number:</label>
        <input type="tel" id="ph_no" name="ph_no" pattern="[0-9]{10}" required><br><br>
        
        <label for="place">Place:</label>
        <input type="text" id="place" name="place" required><br><br>

        <button type="submit">Add Customer</button>
    </form>
</body>
</html>
