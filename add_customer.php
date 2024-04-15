<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Customer</title>
</head>
<body>
    <h1>Add Customer</h1>
    <form action="add_customer_.php" method="post">
        <label for="customer_no">Customer Number:</label><br>
        <input type="number" id="customer_no" name="customer_no"><br><br>
        
        <label for="customer_name">Customer Name:</label><br>
        <input type="text" id="customer_name" name="customer_name"><br><br>
        
        <label for="ph_no">Phone Number:</label><br>
        <input type="number" id="ph_no" name="ph_no" min="0" step="0.01"><br><br>
        
        <label for="place">Place:</label><br>
        <input type="text" id="place" name="place" min="0" step="0.01"><br><br>

        

        <button type="submit">Add Customer</button>
        

        <bu
