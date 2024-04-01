<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
</head>
<body>
    <form id="form" method="post">

        <label for="email">Email</label><div id="available"></div><br>
        <input type="email" id="email" name="email">
        <br><br>

        <label for="password">Password</label><div id="validate"></div><br>
        <input type="text" id="password" name="password">
        <br><br>

        <a href="forget_password.php" id="forgot_password"></a>
        <br><br>

        <input type="submit" name="submit" id="submit">
        <div id="response"></div>
    </form>
    <script>
        $(document).ready(()=>{
            $('#forgot_password').html('Forgot password?')
            $('#forgot_password').css('color','red');


            $('#form').on('submit',(e)=>{
                e.preventDefault();
                var formData = new FormData($('#form')[0]);
                formData.append('submit','something else');

                $.ajax({
                    type: 'post',
                    url:'action/login.php',
                    data: formData,
                    dataType: 'json',
                    processData: false,
                    contentType: false,
                    success:
                    (res)=>{
                        $("#response").html(res.data);
                        $('#available').html(res.check);
                        $('#validate').html(res.pwd);
                    },
                    error: 
                    (jqXHR,error, errorThrown)=>{  
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