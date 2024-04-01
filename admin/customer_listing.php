
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <title>List of Customers</title>
</head>
<body>
<?php
    require_once __DIR__."/../config/conn.php";
    $list_of_customers_query = "SELECT * FROM `user_table`";
    $result = $conn->query($list_of_customers_query);
?>
<table cellpadding="15px" cellspacing="10px">
    <tr>
        <th>id</th>
        <th>First Name</th>
        <th>Last Name</th>
        <th>Email</th>
        <th>Profile Image</th>
        <th>Action</th>
    </tr>
    <?php
    if ($result) {
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) { ?>
                <tr id="delete-<?php echo $row['id'];?>">
                    <td><?php echo $row["id"]; ?></td>
                    <td><?php echo $row["first_name"]; ?></td>
                    <td><?php echo $row["last_name"]; ?></td>
                    <td><?php echo $row["email"]; ?></td>
                    <td>
                        <img src="http://localhost/online_shopping/uploads/<?php echo $row['profile_image']; ?>" width="100" height="auto">
                    </td>
                    <td>
                        <div class="actions">  
                            <a href="#" class="update-link" data-user-id="<?php echo $row['id']; ?>">Update</a>
                            |  
                            <a href="#" class="delete-link"  data-user-id="<?php echo $row['id']; ?>">Delete</a>
                        </div>
                    </td>
                </tr>
            <?php
            }
        } else {?>
            <tr>
                <td colspan="6" style="text-align: center;" id="empty"></td>            
            </tr>
        <?php
        }
    }
    ?>
</table>

    <script>
        $(document).ready(function() {
            $('#update-link').on('click', function(e) {
                e.preventDefault(); 
                var userId = $(this).data('user-id');
                $.ajax({
                    url: 'update.php',
                    method: 'GET', 
                    data: { id: userId },
                    success: function(response) { 
                        window.location.href = 'update.php?id=' + userId;
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.error('Update error:', textStatus, errorThrown);
                        alert('An error occurred during update. Please try again later.');
                    }
                });
            });

            $('.delete-link').on('click', function(e) {

                e.preventDefault(); 
                var userId = $(this).data('user-id');
                var deleteId = '#delete-'+userId;
                $.ajax({
                    url: 'delete_customer.php',
                    method: 'GET', 
                    data: { id: userId },
                    dataType: 'json',
                    success: function(res) { 
                        $(deleteId).remove();
                        if ($('#customer-table tbody tr').length === 0) {
                            $('#empty').html('Empty Field!');
                        }
                    },
                    
                });

            });
        });
    </script>
</body>
</html>