<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products</title>
    <!-- Include Bootstrap CSS and DataTables CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
</head>
<body>
    <div class="container mt-4">
        <h2>Products</h2>
        <table id="products-table" class="table table-striped">
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
    </div>

    <!-- Edit Product Modal -->
    <div class="modal fade" id="editProductModal" tabindex="-1" role="dialog" aria-labelledby="editProductModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form id="editProductForm" enctype="multipart/form-data">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editProductModalLabel">Edit Product</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" id="editProductId" name="editProductId">
                        <div class="form-group">
                            <label for="editName">Name:</label>
                            <input type="text" class="form-control" id="editName" name="editName" required>
                        </div>
                        <div class="form-group">
                    <label for="editCategory">Category:</label>
                    <select class="form-control" id="editCategory" name="editCategory" required>
                        <!-- Options will be populated dynamically -->
                    </select>
                </div>
                        <div class="form-group">
                            <label for="editImage">Image:</label>
                            <input type="file" class="form-control-file" id="editImage" name="editImage">
                            <small class="form-text text-muted">Leave empty if you do not want to change the image.</small>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
    $(document).ready(function() {
        var table = $('#products-table').DataTable({
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
                { 
                    data: 'id', 
                    name: 'action', 
                    render: function(data) {
                        return '<button class="btn btn-primary btn-sm edit-product" data-id="' + data + '">Edit</button>' + 
                               '<button class="btn btn-danger btn-sm delete-product" data-id="' + data + '">Delete</button>';
                    }
                }
            ]
        });

        // Fetch categories for edit modal
        $.ajax({
            url: '{{ route('categories.index') }}', // Adjust as per your route
            type: 'GET',
            success: function(response) {
                var categories = response.data;
                var options = '';
                categories.forEach(function(category) {
                    options += '<option value="' + category.id + '">' + category.name + '</option>';
                });
                $('#editCategory').html(options);
            },
            error: function(err) {
                console.error('Error fetching categories:', err);
            }
        });

        // Open edit modal on click
        $('#products-table tbody').on('click', '.edit-product', function () {
            var productId = $(this).data('id');
            console.log(productId); // Check if productId is correctly fetched
            $('#editProductId').val(productId);

            // Fetch product details via AJAX
            $.ajax({
                url: '/products/' + productId,
                type: 'GET',
                success: function(response) {
                    console.log(response); // Check the response for product details
                    $('#editName').val(response.name);
                    $('#editCategory').val(response.category_id);
                    $('#editProductModal').modal('show');
                },
                error: function(err) {
                    console.error('Error fetching product details:', err);
                }
            });
        });

        // Handle edit form submission
        $('#editProductForm').on('submit', function(e) {
            e.preventDefault();
            var formData = new FormData(this);
            var productId = $('#editProductId').val();

            $.ajax({
                url: '/products/' + productId,
                type: 'POST',
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                success: function(response) {
                    $('#editProductModal').modal('hide');
                    table.ajax.reload();
                },
                error: function(err) {
                    console.error('Error updating product:', err);
                }
            });
        });

        // Handle delete action
        $('#products-table tbody').on('click', '.delete-product', function () {
            var productId = $(this).data('id');
            if (confirm('Are you sure you want to delete this product?')) {
                $.ajax({
                    url: '/products/' + productId,
                    type: 'DELETE',
                    success: function() {
                        table.ajax.reload();
                    },
                    error: function(err) {
                        console.error('Error deleting product:', err);
                    }
                });
            }
        });
    });
    $(document).ready(function() {
    $.ajax({
        url: '/categories',
        type: 'GET',
        dataType: 'json',
        success: function(data) {
            var options = '<option value="">Select Category</option>';
            for (var i = 0; i < data.length; i++) {
                options += '<option value="' + data[i].id + '">' + data[i].name + '</option>';
            }
            $('#editCategory').html(options);
        }
    });
});
</script>

</body>
</html>
