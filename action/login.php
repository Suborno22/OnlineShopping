<?php
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
    require_once __DIR__ . "/../config/conn.php";

    $email = $_POST['email'];
    $password = $_POST['password'];


    $email = $conn->real_escape_string($email);

    $checkDb = "SELECT * FROM `user_table` WHERE email = '$email'";
    $result = $conn->query($checkDb);

    if ($result) {
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            // Verify password
            if (password_verify($password, $row['password'])) {
                echo json_encode(Array("data" => "You are logged in"));
            } else {
                echo json_encode(Array("pwd" => "Incorrect password"));
            }
        } else {
            echo json_encode(Array('check' => 'User does not exist'));
        }
    } else {
        echo json_encode(Array('data' => 'Error in database query'));
    }

    // Close the database connection
    $conn->close();
}
?>
