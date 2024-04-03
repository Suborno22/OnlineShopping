<html>
    <head>
        <style>
        .error {
            color: #FF0000;
        }
        </style> 
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    </head>
    <body>
        <?php
        include_once("database_conn.php"); 
        echo"<center><h1><u>ADD PRODUCT</u></h1>";
        session_start();
  $current_account_id = $_SESSION['account_id'];
 echo "<b>account_id =".$current_account_id. ".</b></br></br></center>";


 $fetch_category = "SELECT * FROM `category` WHERE account_id ='$current_account_id'"; 
  $result = $conn->query($fetch_category);
   if ($result) {
    // print_r($result);
   $count = mysqli_num_rows($result); 
   ?>
 <form id="form" method="post" action="" enctype="multipart/form-data">
 </br></br><label for="category">Choose a Category:</label>
    <select name="category_id" id="category">
    <option value="">--- Select a Category ---</option>
    <?php if ($result->num_rows > 0) {
             while($row = $result->fetch_assoc()) {
                echo "id: " . $row["id"]. "title: " . $row["title"]. " description: " . $row["description"]." image: " . $row["image"]. "account_id: " . $row["account_id"]."<br>";
               ?>
      <option value="<?php echo $row["id"];?>"><?php echo $row["title"];?></option></br>
      <?php } } ?>
      </select> 
      <br> <br> <label> Product Title:</label>           
    <input type="text" name="title" id="title" size="15" class="form-control"/>   
    <br> <br> 
  <label>Product Description:</label>
  <input type="text" name="description" id="description" class="form-control">
  <br> <br>
  <label for="myfile">Upload Product image:</label>
  <input type="file" id="myfile" name="single_product_file"></br></br>
 
  <label>Product Price:</label>
  <input type="number" name="price" id="price" class="form-control">
  <br> <br>
  <label>Product Stock:</label>
  <input type="number" name="stock" id="stock" class="form-control">
  <br> <br>
  
    <label for="myfile">Upload Multiple Product images:</label>
    <div id= "add_file">
<div id = "add_file-1">
<input type="file" id="myfile" name="multiple_product_file[]"></br></br>
</div>
</div>
</br></br><input type="button" name="add" id= "add_btn" value="Add more Product Images"/></br></br>
<input type="submit" name="submit" id="submit_btn" value="Upload Product"/> </br></br>

</br></br><a href="http://localhost/project_coustomer/admin/product_list.php">View Product Details</a> 



<script>
    $(document).ready(function(){
       let div_id= 1;
      $("#add_btn").click(function(){
        const newElement = '<div id = "add_file-'+div_id+'">
        <input type="file" id="myfile" name="multiple_product_file[]">
        <input type="button" name="remove" class="remove" btn_id="add_file-'+div_id+'"value="Remove this Product image"/>
        </br></br>
        </div>';
        $('#add_file').append(newElement); 
  div_id++;
  
      })
   
    jQuery(document).on("click", '.remove', function(event) { 
     
     let btn_id = "#"+$(this).attr('btn_id');
     $(btn_id).remove();

  })
    })
   
    
   </script>

<?php
}
$a=array();
$tableName='product';
session_start();
  if(isset($_POST['submit'])){ 
   $category_id= $_POST['category_id'];
   $title= $_POST['title'];
   $description= $_POST['description'];
   $price= $_POST['price'];
   $stock= $_POST['stock'];
   // echo "<pre>";
  
    $location = dirname(__FILE__);
    $_FILES['single_product_file']['tmp_name']; 
    //    print_r ($_FILES);
   
    $imageTmpName = $_FILES['single_product_file']['tmp_name'];
    // print_r ($imageTmpName);
      $file_name = basename($_FILES["single_product_file"]["name"]);
    //   print_r ($file_name);
      $file_name = $file_name.'-'.date("Y-m-d").'-'.date("h:i:sa");
     if (( move_uploaded_file($imageTmpName, "$location/images/$file_name"))==true ) {

    $query = "INSERT INTO `product`(`category`, `title`, `description`,`image`,`price`,`stock`) VALUES ('$category_id','$title','$description','$file_name','$price','$stock') " ;
    
     if ($conn->query($query)===TRUE) {
        $last_id = $conn->insert_id;
        // echo $last_id;
        // echo "<pre>";
        // print_r ($_FILES);
        foreach ($_FILES['multiple_product_file']['tmp_name']as $key => $image){
        //    print_r ($_FILES);

       
        $imageTmpName = $_FILES['multiple_product_file']['tmp_name'][$key];
        // print_r ($imageTmpName);
          $file_name = basename($_FILES["multiple_product_file"]["name"][$key]);
        //   print_r ($file_name);
          $file_name = $file_name.'-'.date("Y-m-d").'-'.date("h:i:sa");
         if (( move_uploaded_file($imageTmpName, "$location/images/$file_name"))==true ){

        $image_query = "INSERT INTO `product_images`(`product_id`, `image`) VALUES ('$last_id','$file_name') " ;
        if($conn->query($image_query)){

     array_push($a,"true");
     
    }
    
     else {
    array_push($a,"false");

  }
}
        }
}
}
    
    $count=0;
    foreach($a as $b){
    if($b=="true"){
      $count++;
    }
  //  print_r($a);

    }
     $count;
    if($count==sizeof($a)){
    $msg = "Upload Product successfully....";
    echo json_encode(array('success'=>true,'message'=>$msg));

    }
  else
  {
   $msg = "Uploading error... please check all field..";
   echo json_encode(array('success'=>false,'message'=>$msg));
    
  }




}




?>
