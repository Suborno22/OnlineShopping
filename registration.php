<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
</head>
<body>
    <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" enctype="multipart/form-data">
        <h1>Register user</h1>
        <label for="first_name">First Name</label>
        <input type="text" name="first_name" id="first_name">
        <br><br>

        <label for="last_name">Last Name</label>
        <input type="text" name="last_name" id="last_name">
        <br><br>

        <label for="email">Email</label>
        <input type="text" name="email" id="email">
        <br><br>

        <label for="password">Password</label>
        <input type="text" name="password" id="password">
        <br><br>

        <label for="cpassword">Confirm Password</label>
        <input type="text" name="cpassword" id="cpassword">
        <br><br>

        <label for="uploadFile">Upload your profile photo</label>
        <input type="file" name="uploadFile" id="uploadFile">
        <br><br>

        <input type="submit" id="submit" name="submit" value="register">
    </form>
    <script>
        // $(document).ready(()=>{
        //     $("form").on('#submit',()=>{
        //         var formData = new FormData(this);
        //         console.log(this)
        //         return false;
        //     })
        // })
    </script>
</body>
</html>
<?php

if($_SERVER['REQUEST_METHOD']=='POST'){

    require __DIR__ ."/config/conn.php";
    $firstName = $_POST['first_name'];
    $lastName = $_POST['last_name'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'],PASSWORD_DEFAULT);

    // File upload handling
    $targetDirectory = "uploads/"; // Change this to your desired directory
    $profileImage = $_FILES['uploadFile']['name'];
    $targetFile = $targetDirectory . basename($profileImage);

    // Move uploaded file to target directory
    if (move_uploaded_file($_FILES["uploadFile"]["tmp_name"], $targetFile)) {
        echo json_encode(Array("data"=>"The file ". basename( $_FILES["uploadFile"]["name"]). " has been uploaded."));
    } else {
        echo json_encode(Array("data"=>"Sorry, there was an error uploading your file."));
    }

    $sql = "INSERT INTO `user_table` (first_name, last_name, email, password, profile_image) 
            VALUES ('$firstName', '$lastName', '$email', '$password', '$profileImage')";

    if ($conn->query($sql) === TRUE) {
        echo json_encode(Array("Array"=>"Sorry, there was an error uploading your file."));
    } else {
        echo json_encode(Array("data"=>"Error: " . $sql . "<br>" . $conn->error));
    }
    $conn->close();
}
?>