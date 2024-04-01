<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scope=1.0">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <title>Change Password</title>
</head>
<body>
    <form action="post" id="form">
        <label for="new-password">New Password</label>
        <input type="password" id="new-password" name="new-password" placeholder="New Password">
        <div class="alert"></div>
        <br><br>

        <label for="confirm-password">Confirm Password</label>
        <input type="password" id="confirm-password" name="confirm-password" placeholder="Confirm Password">
        <div class="alert"></div>  <input type="submit" name="submit" id="submit" value="Change Password">
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
</body>
</html>
