<?php 

// process_update.php
require __DIR__."/../config/conn.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $userId = $_POST['id'];
    $newFirstName = $_POST['first_name'];
    $newLastName = $_POST['last_name'];
    $newEmail = $_POST['email'];

    $query = "UPDATE `user_table` SET first_name='$newFirstName', last_name='$newLastName', email='$newEmail' WHERE id='$userId'";
    $result = $conn->query($query);

    if ($result) {

        if (mysqli_affected_rows($conn) > 0) {
            echo json_encode(Array("data"=>"User updated successfully."));
        } else {
            echo json_encode(Array("data"=>"No changes made or user not found."));
        }
        
    } else {
        echo json_encode(Array("data"=>"Error preparing the update statement."));
    }

    mysqli_close($conn);
} else {
    echo json_encode(Array("data"=>"Invalid form submission."));
}


?>