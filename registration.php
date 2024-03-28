<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
</head>
<body>
    <form method="POST" enctype="multipart/form-data" id="form">
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
        <div id="response"></div>
    </form>
    <script>
        $(()=>{
            $("#form").on('submit',(e)=>{
                e.preventDefault();
                var formData = new FormData($('#form')[0]);
                formData.append('submit',$('#submit').val());
                // formData.delete('cpassword');

                // for( var [key,value] of formData.entries()){
                //     console.log(key,"=>",value)
                // }
                $.ajax({
                    type:"POST",
                    url:'action/registration.php',
                    data: formData,
                    dataType: 'json',
                    processData: false,
                    contentType: false,
                    success:(res)=>{
                        $("#response").html(res.data);
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
