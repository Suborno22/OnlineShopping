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
        <br>
        <input type='file' name='uploadFile' multiple>
        <br><br>

        <div id= "upload_image">

        <!-- <div id = "add_file-0">
            <input type="file" id="myfile" name="multiple_product_file[]"></br></br>
        </div> -->
    
        <button name="add" id= "add_btn">Add more Product Images</button>

        <div id="response"></div>
        <input type="submit" id="submit" name="submit" value="register">
        
    </form>
    <script>
        $(()=>{
            let div_id = 2;
            $('#add_btn').on('click',()=>{
                const newField = '<div id = "add_file-'+div_id+'"><input type="file" id="myfile" name="multiple_product_file[]"><input type="button" name="remove" class="remove" btn_id="add_file-'+div_id+'"value="Remove this Product image"/></br></br></div>';
                $('#upload_image').append(newField); 
                div_id++;
            })

            $('.remove').on("click",()=>{
                let btn_id = "#"+$(this).attr('btn_id');
                console.log(this);
                $(btn_id).remove();
            })
            
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
        })
    </script>
</body>
</html>
