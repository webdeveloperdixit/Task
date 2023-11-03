<!DOCTYPE html>
<html>
<head>
    <title>Data Table Example</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <table id="data-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Date Time</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <!-- Rows will be added dynamically -->
        </tbody>
    </table>

    <!-- Add new entry button, name input, and send button -->
    <button id="add-button">Add New Entry</button>
    <input type="text" id="new-name" placeholder="Name" style="display: none;">
    <button id="send-button" style="display: none;">Send</button>

    <script>
        $(document).ready(function() {
            // Function to populate the table with data from the server
            function populateTable() {
                
                var mockData = [
                    { id: 1, name: "Entry 1", datetime: "2023-11-03 12:00:00" },
                    { id: 2, name: "Entry 2", datetime: "2023-11-03 14:00:00" }
                ];

                var tableBody = $('#data-table tbody');
                tableBody.empty(); // Clear existing rows

                $.each(mockData, function(index, item) {
                    var row = '<tr data-id="' + item.id + '">';
                    row += '<td>' + item.id + '</td>';
                    row += '<td><span class="editable">' + item.name + '</span></td>';
                    row += '<td>' + item.datetime + '</td>';
                    row += '<td><button class="edit-button">Edit</button> <button class="delete-button">Delete</button></td>';
                    row += '</tr>';
                    tableBody.append(row);
                });
            }

            // Initial table population with mock data
            populateTable();

            // Add New Entry button click event
            $('#add-button').click(function() {
                $('#new-name').show();
                $('#send-button').show();
            });

            // Send button click event for adding a new entry
            $('#send-button').click(function() {
                var newName = $('#new-name').val();

               
                $.ajax({
                    url: 'add-entry.php', // Replace with the actual server-side script
                    type: 'POST',
                    data: { name: newName },
                    success: function(response) {
                        var response = JSON.parse(response);
                        
                        var newEntry = { id: response.id, name: newName, datetime: response.datetime };

                        var tableBody = $('#data-table tbody');
                        var row = '<tr data-id="' + newEntry.id + '">';
                        row += '<td>' + newEntry.id + '</td>';
                        row += '<td><span class="editable">' + newEntry.name + '</span></td>';
                        row += '<td>' + newEntry.datetime + '</td>';
                        row += '<td><button class="edit-button">Edit</button> <button class="delete-button">Delete</button></td>';
                        row += '</tr>';
                        tableBody.append(row);

                        // Hide the input fields and Send button
                        $('#new-name').val('').hide();
                        $('#send-button').hide();
                    },
                    error: function(xhr, status, error) {
                        // Display the error message in the UI
                        alert("Error: " + error);
                    }
                });
            });

            // Edit button click event
            $('#data-table').on('click', '.edit-button', function() {
                var row = $(this).closest('tr');
                var nameCell = row.find('td:nth-child(2) .editable');
                nameCell.attr('contenteditable', true).focus();
                $(this).text('Save').removeClass('edit-button').addClass('save-button');
            });

            // Save button click event
            $('#data-table').on('click', '.save-button', function() {
                var row = $(this).closest('tr');
                var id = row.data('id');
                var nameCell = row.find('td:nth-child(2) .editable');
                var newName = nameCell.text();

                
                $.ajax({
                    url: 'update-entry.php', // Replace with the actual server-side script
                    type: 'POST',
                    data: { id: id, name: newName },
                    success: function(response) {
                        nameCell.attr('contenteditable', false);
                        $(this).text('Edit').removeClass('save-button').addClass('edit-button');
                    },
                    error: function(xhr, status, error) {
                        // Display the error message in the UI
                        alert("Error: " + error);
                    }
                });
            });

            // Delete button click event
            $('#data-table').on('click', '.delete-button', function() {
                var row = $(this).closest('tr');
                var id = row.data('id');

                
                $.ajax({
                    url: 'delete-entry.php', // Replace with the actual server-side script
                    type: 'POST',
                    data: { id: id },
                    success: function(response) {
                        row.remove();
                    },
                    error: function(xhr, status, error) {
                        // Display the error message in the UI
                        alert("Error: " + error);
                    }
                });
            });
        });
    </script>
</body>
</html>
