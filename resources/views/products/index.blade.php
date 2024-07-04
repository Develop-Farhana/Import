<!-- resources/views/products/index.blade.php -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products</title>
    <!-- Include DataTables CSS and JS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
</head>
<body>
    <table id="products-table" class="display">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Category</th>
                <th>Image</th>
                <th>Actions</th>
            </tr>
        </thead>
    </table>

    <!-- Popup Modal -->
    <div id="productModal" style="display:none;">
        <form id="productForm">
            <input type="hidden" id="productId">
            <div>
                <label for="name">Name</label>
                <input type="text" id="name" name="name" required>
            </div>
            <div>
                <label for="category_id">Category</label>
                <select id="category_id" name="category_id" required>
                    <!-- Populate categories -->
                </select>
            </div>
            <div>
                <label for="image">Image</label>
                <input type="file" id="image" name="image">
            </div>
            <button type="submit">Save</button>
        </form>
    </div>

    <script>
        $(document).ready(function() {
            $('#products-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route('products.index') }}',
                columns: [
                    { data: 'id', name: 'id' },
                    { data: 'name', name: 'name' },
                    { data: 'category.name', name: 'category.name' },
                    { data: 'image', name: 'image', render: function(data) {
                        return `<img src="/storage/${data}" width="50">`;
                    }},
                    { data: 'action', name: 'action', orderable: false, searchable: false }
                ]
            });

            // Add event listeners for edit, update, delete actions here
        });
    </script>
</body>
</html>
