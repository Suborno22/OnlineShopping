<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update User</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
</head>

<body>
    <?php
    require __DIR__."/../config/conn.php";

    // Check if a user ID is provided in the query string
    if (isset($_GET['id'])) {
        $userId = $_GET['id'];

        // Retrieve the user details from the database based on the ID
        $query = "SELECT * FROM `user_table` WHERE id = '$userId'";
        $result = $conn->query($query);

        if ($result) {

            if ($row = mysqli_fetch_assoc($result)) {?>
            <form method="POST" id="form" enctype="multipart/form-data" id="form">
                
                <h1>Register user</h1>

                <input type='hidden' name='id' value="<?php echo $row['id'];?>" >
                <label for="first_name">First Name</label>
                <input type="text" name="first_name" id="first_name" value="<?php echo $row['first_name']?>">
                <br><br>

                <label for="last_name">Last Name</label>
                <input type="text" name="last_name" id="last_name"  value="<?php echo $row['last_name']?>">
                <br><br>

                <label for="email">Email</label>
                <input type="text" name="email" id="email"  value="<?php echo $row['email']?>">
                <br><br>
                <br>
                <div id="updateStts"></div>
                <br>
                <input type="submit" id="submit" name="submit" value="Update">
                <div id="response"></div>
            </form>
            <?php
            } else {
                echo json_encode(Array("data"=>"User not found."));
            }
        } else {
            echo json_encode(Array("data"=>"Error preparing the statement."));
        }
    } else {
        echo json_encode(Array("data"=>"User ID not provided."));
    }

    // Close the database connection
    mysqli_close($conn);
    ?>
    <script>
        $(()=>{
          $('#form').on('submit',(e)=>{
            e.preventDefault();
            var formData = new FormData($('#form')[0]);
            for(var[key,value] of formData.entries()){
                console.log(key,"=>",value);
            }

            $.ajax({
                type: 'POST',
                url: 'process_update.php',
                data: formData,
                dataType: 'json',
                processData: false,
                contentType: false,
                success: (res)=>{
                    $("#updateStts").html(res.data);
                },
                error:(jqXHR,error,errorThrown)=>{
                    if(jqXHR.status&&jqXHR.status==400){
                        alert(jqXHR.responseText); 
                    }else{
                        alert("Something went wrong:",error,errorThrown);
                    }
               }
            })
          })  
        })
    </script>
</body>

</html>