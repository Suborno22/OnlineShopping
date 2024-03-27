
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
if($result){
    if($result->num_rows>0){
        while($row = $result->fetch_assoc()){?>
            <tr>
            <td><?php echo $row["id"]?></td>
            <td><?php echo$row["first_name"]?></td>
            <td><?php echo $row["last_name"]?></td>
            <td><?php echo $row["email"]?></td>
            <td><img src="http://localhost/online_shopping/uploads/<?php echo $row['profile_image']?>" width="100" height="auto"> </td>
            <td><div id="update">Update</div>--------<div id="delete">Delete</div></td>
<?php       }
    }else{
        echo json_encode(Array("data"=>"Empty Field"));
    }
}
?>
    </table>  
    <script>
        $(()=>{
            
        })
    </script>
</body>
</html>