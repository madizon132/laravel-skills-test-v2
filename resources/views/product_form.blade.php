<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Form</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
<div class="container mt-5">
    <h1>Product Form</h1>
    <form id="productForm">
        @csrf
        <div class="mb-3">
            <label for="product_name" class="form-label">Product Name</label>
            <input type="text" class="form-control" id="product_name" name="product_name" required>
        </div>
        <div class="mb-3">
            <label for="quantity_in_stock" class="form-label">Quantity in Stock</label>
            <input type="number" class="form-control" id="quantity_in_stock" name="quantity_in_stock" required>
        </div>
        <div class="mb-3">
            <label for="price_per_item" class="form-label">Price per Item</label>
            <input type="number" step="0.01" class="form-control" id="price_per_item" name="price_per_item" required>
        </div>
        <button type="submit" class="btn btn-primary">Add</button>
    </form>
    <h2 class="mt-5">Submitted Data</h2>
    <table class="table table-bordered">
        <thead>
        <tr>
            <th>Product Name</th>
            <th>Quantity in Stock</th>
            <th>Price per Item</th>
            <th>Datetime Submitted</th>
            <th>Total Value</th>
            <th>Actions</th>
        </tr>
        </thead>
        <tbody id="productTable">
        @foreach($products as $index => $product)
            <tr>
                <td>{{ $product['product_name'] }}</td>
                <td>{{ $product['quantity_in_stock'] }}</td>
                <td>{{ $product['price_per_item'] }}</td>
                <td>{{ $product['created_at'] }}</td>
                <td>{{ $product['total_value'] }}</td>
                <td>
                    <button class="btn btn-sm btn-warning edit-btn" data-id="{{ $product['id'] }}">Edit</button>
                </td>
            </tr>
        @endforeach
        </tbody>
        <tfoot>
        <tr>
            <td colspan="4">Sum Total</td>
            <td colspan="2">{{ array_sum(array_column($products->items(), 'total_value')) }}</td>
        </tr>
        </tfoot>
    </table>
</div>
<script>
    $('#productForm').on('submit', function (e) {
        e.preventDefault();
        $.ajax({
            url: '/products',
            method: 'POST',
            data: $(this).serialize(),
            success: function (response) {
                alert(response.message);
                location.reload();
            },
            error: function (xhr, status, error) {
                alert('Failed to submit the form. Please try again.');
            }
        });
    });

    $('.edit-btn').on('click', function () {
        const id = $(this).data('id');
        const row = $(this).closest('tr');  
        const productName = row.find('td:nth-child(1)').text();
        const quantity = row.find('td:nth-child(2)').text();
        const price = row.find('td:nth-child(3)').text();

        $('#product_name').val(productName);
        $('#quantity_in_stock').val(quantity);
        $('#price_per_item').val(price);

        $('h1').text('Update Product');
        $('button[type="submit"]').text('Update');

        $('#productForm').off('submit').on('submit', function (e) {
            e.preventDefault();
            $.ajax({
                url: `/products/${id}`,
                method: 'PUT',
                data: $(this).serialize(),
                success: function (response) {
                    alert(response.message);
                    location.reload();
                },
                error: function (xhr, status, error) {
                    alert('Failed to update the form. Please try again.');
                }
            });
        });
    });
</script>
</body>
</html>
