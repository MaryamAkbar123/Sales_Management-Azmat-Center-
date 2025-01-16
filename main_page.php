<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sales Management</title>
    <link rel="stylesheet" href="styles.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <div class="container">
        <h1>New Azmat Center</h1>
        <h1>Sales Management</h1>
        <form id="add-sale-form">
            <input type="text" id="product-name" placeholder="Product Name" required><br>
            <input type="number" id="retail-price" placeholder="Retail Price" step="0.01" required><br>
            <input type="number" id="sale-price" placeholder="Sale Price" step="0.01" required><br>
            <button type="button" id="add-sale-btn">Add Sale</button>
        </form>

        <div>
            <input type="text" id="search-bar" placeholder="Search by product name" />
        </div>

        <table>
            <thead>
                <tr>
                    <th>Product Name</th>
                    <th>Retail Price</th>
                    <th>Sale Price</th>
                    <th>Profit</th>
                    <th>Sale Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody id="sales-table-body"></tbody>
        </table>

        <div>
            <h3 id="total-sales"></h3>
            <h3 id="total-profit"></h3>
            <button class="filter-btn" data-filter="daily">Daily Sales</button>
            <button class="filter-btn" data-filter="monthly">Monthly Sales</button>
            <button class="filter-btn" data-filter="yearly">Yearly Sales</button>
        </div>

    
    <script src="script.js"></script>
</body>
</html>
