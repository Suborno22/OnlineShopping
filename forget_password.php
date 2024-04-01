<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <title>Forgot Password</title>
</head>
<body>
    <h2>Forgot Password?</h2>
    <p>To change your password, fill up this form</p>

    <form id="form">

        
        <label for="email">Your Email</label>
        <input type="email" name="email" id="email">
        <br>
        <div id="Error"></div>
        <br>
        <div id="Success"></div>
        
        <input type="submit" id="submit" name="submit">
        <br><br>
    </form>
    <script>
        $(document).ready(()=>{
            
            $("#form").on('submit',(e)=>{
                var formData = new FormData($('#form')[0]);
                formData.append('submit','something else');
                e.preventDefault();
                for (var [key, value] of formData.entries()) {
                    console.log("Input name:", key,"|","Value:", value);
                }
                $.ajax({
                    type:'post',
                    url: 'action/forget_pwd.php',
                    data: formData,
                    dataType: 'json',
                    processData: false,
                    contentType: false,
                    success: 
                    (res)=>{
                        $('#Success').html(res.success);
                        $('#Success').css('color','green')
                    }
                })
                
            })
        })
    </script>
</body>
</html>