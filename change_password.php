<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scope=1.0">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <title>Change Password</title>
</head>
<body>
    <h2>Change Password</h2>
    <form method="post" id="form" action="">
        <label for="new-password">New Password</label>
        <input type="password" id="new-password" name="new-password" placeholder="New Password">
        <div class="alert"></div>
        <br><br>
        <label for="confirm-password">Confirm Password</label>
        <input type="password" id="confirm-password" name="confirm-password" placeholder="Confirm Password">
        <div class="alert"></div>  
        <input type="submit" name="submit" id="submit" value="Change Password">
        <br><br>
    </form>
    <script>
        $(document).ready(function() {
            function validatePassword(firstPassword, secondPassword, alert) {
                if (firstPassword !== secondPassword) {
                    $(alert).html("Passwords do not match");
                    $(alert).css("color",'red');
                    return false;
                } else {
                    $(alert).html("");
                    return true; 
                }
            }
            $('#new-password, #confirm-password').on('keyup', function() {
                var firstPassword = $('#new-password').val();
                var secondPassword = $('#confirm-password').val();
                validatePassword(firstPassword, secondPassword, '.alert'); 
            });
        });
    </script>

    <?php
    if ($_SERVER["REQUEST_METHOD"]=="POST" && isset($_POST['submit'])) {
        require __DIR__."/config/conn.php";

        $password = $_POST['confirm-password'];
        $email = $_GET['email'];

        $DeleteToken = "DELETE FROM `recover_password` WHERE `recover_password`.`email` = '$email'";
        $conn->query($DeleteToken);
        $New_password = password_hash($password, PASSWORD_DEFAULT);

        $stmt = $conn->prepare("UPDATE `user_table` SET `password` = ? WHERE `email` = ?");
        $stmt->bind_param("ss", $New_password, $email);
        if ($stmt->execute()) {
            echo "Your password has changed";
        } else {
            echo "Error updating password: " . $conn->error;
        }
        $stmt->close();
        $conn->close();
    }
    ?>

</body>
</html>
