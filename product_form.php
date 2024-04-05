<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Form</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
</head>
<body>
    <form method="POST" enctype="multipart/form-data" id="form">
        <h1>Product Form</h1>


        <label for="product_name">Product Name</label>
        <input type="text" name="product_name" id="product_name">
        <br><br>

        <label for="product_stock">Product Stock</label>
        <input type="text" name="product_stock" id="product_stock">
        <br><br>

        <label for="product_price">Product Price</label>
        <input type="text" name="product_price" id="product_price">
        <br><br>

        <label for="uploadFile">Upload your product photo</label>
        <input type='file' name='uploadFile' multiple>
        <br><br>

        <button id="uploadMultipleImageField" type="button">Upload another Image?</button><span> <----- Click here</span>
        <br><br>

        <div id="AllocateImages"></div>

        <input type="submit" id="submit" name="submit" value="register">
         
        <div id="response"></div>
        <div id="id"></div>
        
    </form>
    <script>
        $(document).ready(function() {
            let i = 0;
            $('#uploadMultipleImageField').on('click', () => {
                var insertImage = "<div id='imageField-" + i + "'><label for='insertImage-" + i + "'>Image: </label><input type='file' name='multiple_product_file[]' id='insertImage'>&nbsp;<button id='removeImage-" + i + "' class='removeImage'>Remove</button><br><br></div>";
                console.log(i);
                $('#AllocateImages').append(insertImage);
                i++;
            });

            $('#AllocateImages').on('mousedown', '.removeImage', function() {
                // console.log("removed:",i)
                $(this).closest('div').remove();
                i--;
            });

            $("#form").on('submit', (e) => {
                e.preventDefault();
                var formData = new FormData($('#form')[0]);
                formData.append('submit', $('#submit').val());
                formData.delete('cpassword'); 
                for( var [key,value] of formData.entries()){
                    console.log(key,"=>",value)
                }
                $.ajax({
                    type:"POST",
                    url:'action/product_form.php',
                    data: formData,
                    dataType: 'json',
                    processData: false,
                    contentType: false,
                    success:(res)=>{
                        $("#response").html(res.data);
                    }
                })

            })
        });
    </script>
</body>
</html>
