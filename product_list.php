
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <title>List of Products</title>
</head>
<body>
<?php
    require_once __DIR__."/config/conn.php";
    $list_of_customers_query = "SELECT * FROM `product`";
    $result = $conn->query($list_of_customers_query);
?>
<table cellpadding="15px" cellspacing="10px">
    <tr>
        <th>id</th>
        <th>Item Name</th>
        <th>Stock</th>
        <th>Price</th>
        <th>Image</th>
    </tr>
    <?php
    if ($result) {
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) { ?>
                <tr id="delete-<?php echo $row['productId'];?>">
                    <td><?php echo $row["productId"]; ?></td>
                    <td><?php echo $row["product_name"]; ?></td>
                    <td><?php echo $row["product_stock"]; ?></td>
                    <td><?php echo $row["product_price"]; ?></td>
                    <td>
                        <img src="http://localhost/online_shopping/product_uploads/<?php echo $row['profile_image']; ?>" width="100" height="auto">
                    </td>
                    <td><?php echo $row["role"]; ?></td>
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
                    url: 'action/update_product.php',
                    method: 'GET', 
                    data: { id: userId },
                    dataType:'json',
                    success: function(res) { 
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
                    url: 'action/delete_product.php',
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