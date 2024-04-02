<?php

if($_SERVER['REQUEST_METHOD']=='POST' && isset($_POST['submit'])){

    require __DIR__ ."/../config/conn.php";
    $firstName = $_POST['product_name'];
    $lastName = $_POST['product_stock'];
    $email = $_POST['product_price'];

    // File upload handling
    $targetDirectory = "product_uploads/"; 
    $profileImage = $_FILES['uploadFile']['name'];
    $targetFile = "../".$targetDirectory . basename($profileImage);

    // Move uploaded file to target directory
    if (!move_uploaded_file($_FILES["uploadFile"]["tmp_name"], $targetFile)) {
        echo json_encode(Array("data"=>"Sorry, there was an error uploading your file."));
    }

    $sql = "INSERT INTO `user_table` (first_name, last_name, email, password, role,profile_image) 
            VALUES ('$firstName', '$lastName', '$email', '$password', 'User','$profileImage')";

    if ($conn->query($sql) === TRUE) {
        echo json_encode(Array("data"=>"Your data has been uploaded"));
    } else {
        echo json_encode(Array("data"=>"Error: " . $sql . "<br>" . $conn->error));
    }
    $conn->close();
}
?>