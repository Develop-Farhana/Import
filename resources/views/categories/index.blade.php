<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Categories</title>
    <!-- Include DataTables CSS and JS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css">
    <!-- Include Bootstrap CSS for better styling (optional) -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h1>Categories</h1>
        <form action="{{ route('categories.import') }}" method="POST" enctype="multipart/form-data" class="mb-3">
            @csrf
            <div class="form-group">
                <input type="file" name="file" required class="form-control-file">
            </div>
            <button type="submit" class="btn btn-primary">Import</button>
        </form>
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        <table id="categories-table" class="display">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Actions</th>
                </tr>
            </thead>
        </table>
    </div>

    <!-- Modal for Edit Category -->
    <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Edit Category</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="editForm" method="POST">
                        @csrf
                        @method('PUT') <!-- Use PUT method for update -->
                        <div class="form-group">
                            <label for="editName">Name</label>
                            <input type="text" class="form-control" id="editName" name="name" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Include jQuery and DataTables JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
    <!-- Include Bootstrap JS for Modal functionality -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>

    <script>
        $(document).ready(function() {
            var table = $('#categories-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route('categories.getCategories') }}',
                columns: [
                    { data: 'id', name: 'id' },
                    { data: 'name', name: 'name' },
                    { data: 'action', name: 'action', orderable: false, searchable: false }
                ]
            });

            // Edit button click handler
            $('#categories-table').on('click', '.edit', function () {
                var id = $(this).data('id');
                $.get('categories/' + id + '/edit', function (data) {
                    $('#editName').val(data.name);
                    $('#editForm').attr('action', 'categories/' + id); // Set the form action dynamically
                    $('#editModal').modal('show');
                });
            });

            // Update form submission handler
            $('#editForm').on('submit', function (e) {
                e.preventDefault(); // Prevent default form submission
                var actionUrl = $(this).attr('action'); // Get the form action URL
                var formData = $(this).serialize(); // Serialize form data
                $.ajax({
                    url: actionUrl,
                    type: 'POST', // Use POST for update
                    data: formData,
                    success: function (response) {
                        $('#editModal').modal('hide'); // Hide the modal after successful update
                        table.ajax.reload(); // Reload the DataTable
                        alert(response.success); // Show success message
                    },
                    error: function (xhr) {
                        // Handle any errors here
                        alert('Error: ' + xhr.responseText);
                    }
                });
            });

            // Delete button click handler
            $('#categories-table').on('click', '.delete', function () {
                if (confirm('Are you sure you want to delete this category?')) {
                    var id = $(this).data('id');
                    $.ajax({
                        url: 'categories/' + id,
                        type: 'DELETE',
                        data: {
                            _token: '{{ csrf_token() }}'
                        },
                        success: function (response) {
                            table.ajax.reload(); // Reload the DataTable
                            alert(response.success); // Show success message
                        },
                        error: function (xhr) {
                            // Handle any errors here
                            alert('Error: ' + xhr.responseText);
                        }
                    });
                }
            });
        });
    </script>
</body>
</html>
