<?php

if($_SERVER['REQUEST_METHOD']=='POST' && isset($_POST['submit'])){

    require __DIR__ ."/../config/conn.php";
    $product_name = $_POST['product_name'];
    $product_stock = $_POST['product_stock'];
    $product_price = $_POST['product_price'];

  
    $targetDirectory = "product_uploads/"; 
    $productImage = $_FILES['uploadFile']['name'];
    $targetFile = "../".$targetDirectory . basename($productImage);

 
    if (!move_uploaded_file($_FILES["uploadFile"]["tmp_name"], $targetFile)) {
        echo json_encode(Array("data"=>"Sorry, there was an error uploading your file."));
    }

    $sql = "INSERT INTO `product` (product_name, product_stock, product_price, product_image) 
            VALUES ('$product_name', '$product_stock', '$product_price', '$productImage')";
    
    $result = $conn->query($sql);
    $productId = $conn->insert_id;

    $MultipleImages = $_FILES['multiple_product_file']['name'];

    $uploads = 0;
    foreach($MultipleImages as $Images){
        $productMultipleImageQuery = "INSERT INTO `product_images`(	productId, gallery ) VALUES ('$productId','$Images')";
        $UploadMultipleImages = $conn->query($productMultipleImageQuery);
        if($UploadMultipleImages){
            $uploads = $uploads +1;
        }else{
            $uploads = $uploads - 1;
        }
    }
    


    if ($result||$uploads>=0) {
        echo json_encode(Array("data"=>"Success"));
    } else {
        echo json_encode(Array("data"=>"Error: " . $sql . "<br>" . $conn->error));
    }
    $conn->close();
}
?>