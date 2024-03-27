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
    if (!move_uploaded_file($_FILES["uploadFile"]["tmp_name"], $targetFile)) {
        echo json_encode(Array("data"=>"Sorry, there was an error uploading your file."));
    }

    $sql = "INSERT INTO `user_table` (first_name, last_name, email, password, profile_image) 
            VALUES ('$firstName', '$lastName', '$email', '$password', '$profileImage')";

    if ($conn->query($sql) === TRUE) {
        echo json_encode(Array("data"=>"Your data has been uploaded"));
    } else {
        echo json_encode(Array("data"=>"Error: " . $sql . "<br>" . $conn->error));
    }
    $conn->close();
}
?>