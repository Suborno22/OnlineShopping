<?php
require __DIR__."/../config/conn.php";


if (isset($_GET['id'])) {
    $userId = $_GET['id'];

    $query = "DELETE FROM `user_table` WHERE id='$userId'";
    $result = $conn->query($query);

    if ($result) {
        if (mysqli_affected_rows($conn) > 0) {
            echo json_encode(Array("data"=>"User deleted successfully.","action"=>"success"));
        } else {
            echo json_encode(Array("data"=>"User not found.","action"=>"fail"));
        }
    } else {
        echo json_encode(Array("data"=>"Error preparing the delete statement.","action"=>"fail"));
    }
} else {
    echo json_encode(Array("data"=>"User ID not provided.","action"=>"fail"));
}

mysqli_close($conn);
?>