<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Product</title>
</head>
<body>
    <h1>Add Product</h1>
    <form action="add_product_.php" method="post">
        <label for="product_code">Product Code:</label><br>
        <input type="text" id="product_code" name="product_code"><br><br>
        
        <label for="product_name">Product Name:</label><br>
        <input type="text" id="product_name" name="product_name"><br><br>
        
        <label for="mrp">MRP:</label><br>
        <input type="number" id="mrp" name="mrp" min="0" step="0.01"><br><br>
        
        <label for="rate">Rate:</label><br>
        <input type="number" id="rate" name="rate" min="0" step="0.01"><br><br>

        <label for="p_rate">Purchase Rate:</label><br>
        <input type="number" id="p_rate" name="p_rate" min="0" step="0.01"><br><br>

        <button type="submit">Add Product</button>
        

        <bu
