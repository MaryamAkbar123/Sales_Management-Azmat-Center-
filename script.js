$(document).ready(function () {
    // Load sales data on page load
    loadSales();

    // Add Sale
    $('#add-sale-btn').click(function () {
        var productName = $('#product-name').val();
        var retailPrice = $('#retail-price').val();
        var salePrice = $('#sale-price').val();

        if (productName && retailPrice && salePrice) {
            $.ajax({
                url: 'sales_action.php',
                type: 'POST',
                data: {
                    action: 'insert',
                    product_name: productName,
                    retail_price: retailPrice,
                    sale_price: salePrice,
                },
                success: function (response) {
                    alert(response);
                    loadSales();
                    $('#add-sale-form')[0].reset();
                },
            });
        } else {
            alert('Please fill out all fields');
        }
    });
      // Add event listener for search bar
      $('#search-bar').on('input', function () {
        var searchValue = $(this).val().toLowerCase();
        $('#sales-table-body tr').filter(function () {
            $(this).toggle(
                $(this).text().toLowerCase().indexOf(searchValue) > -1
            );
        });
    });

    // Edit Sale
    $('body').on('click', '.update-btn', function () {
        var saleId = $(this).data('id');
        var newProductName = prompt('Enter new product name:');
        var newRetailPrice = prompt('Enter new retail price:');
        var newSalePrice = prompt('Enter new sale price:');

        if (newProductName && newRetailPrice && newSalePrice) {
            $.ajax({
                url: 'sales_action.php',
                type: 'POST',
                data: {
                    action: 'update',
                    id: saleId,
                    product_name: newProductName,
                    retail_price: newRetailPrice,
                    sale_price: newSalePrice,
                },
                success: function (response) {
                    alert(response);
                    loadSales();
                },
            });
        }
    });

    // Delete Sale
    $('body').on('click', '.delete-btn', function () {
        var saleId = $(this).data('id');
        if (confirm('Are you sure you want to delete this sale?')) {
            $.ajax({
                url: 'sales_action.php',
                type: 'POST',
                data: { action: 'delete', id: saleId },
                success: function (response) {
                    alert(response);
                    loadSales();
                },
            });
        }
    });

    // Filter Sales
    $('.filter-btn').click(function () {
        var filter = $(this).data('filter');
        loadSales(filter);
    });

    // Load Sales function
    function loadSales(filter = '') {
        $.ajax({
            url: 'sales_action.php',
            type: 'POST',
            data: { action: 'load', filter: filter },
            success: function (response) {
                var res = JSON.parse(response);
                $('#sales-table-body').html(res.data);
                $('#total-sales').text('Total Sales: ' + res.totalSales.toFixed(2));
                $('#total-profit').text('Total Profit: ' + res.totalProfit.toFixed(2));
            },
        });
    }
    
});


