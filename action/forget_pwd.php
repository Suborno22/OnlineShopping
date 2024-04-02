<?php
use PHPMailer\PHPMailer\PHPMailer;
require __DIR__.'/../config/conn.php';

$email = $_POST['email']; 
$email = $conn->real_escape_string($email);


$checkEmail = "SELECT * FROM `user_table` WHERE email = '$email'";

$result = $conn->query($checkEmail);

if($result){
    if($result->num_rows > 0){

        $key = rand(1000,9999);

        $output='<p>Dear user,</p>';
        // $output.='<p>Please click on the following link to reset your password.</p>';
        
        $output.='<p><a href="http://localhost/online_shopping/change_password.php?key='.$key.'&email='.$email.'&action=reset" target="_blank">
        http://localhost/online_shopping/change_password.php?key='.$key.'&email='.$email.'&action=reset</a></p>';		
        
        $output.='<p>Please be sure to copy the entire link into your browser.
        The link will expire after 1 day for security reason.</p>';
        // $output.='<p>If you did not request this forgotten password email, no action 
        // is needed, your password will not be reset. However, you may want to log into 
        // your account and change your security password as someone may have guessed it.</p>';   	
        // $output.='<p>Thanks,</p>';
        // $output.='<p>AllPHPTricks Team</p>';
        $body = $output; 

        $subject = "Password Recovery - AllPHPTricks.com";


        //Insert into table

        $insertToken = "INSERT INTO `recover_password` (`email`, `token`) VALUES ('".$email."', '".$key."');";
        $conn->query($insertToken);
    
        require_once '../vendor/autoload.php';

        $mail = new PHPMailer();

        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'subornodas666@gmail.com';
        $mail->Password = 'vfkiddjkrnslggfv';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 25;

        $mail->setFrom('subornodas666@gmail.com', 'Recover Password');
        $mail->addAddress($email, 'Me');
        $mail->Subject = $subject;
        // Set HTML 
        $mail->isHTML(TRUE);
        $mail->Body = $body;
        // $mail->AltBody = 'Hi there, we are happy to confirm your booking. Please check the document in the attachment.';
        // add attachment 
        // just add the '/path/to/file.pdf'
        // $attachmentPath = './confirmations/yourbooking.pdf';
        // if (file_exists($attachmentPath)) {
        //     $mail->addAttachment($attachmentPath, 'yourbooking.pdf');
        // }

        // send the message
        if(!$mail->send()){
            echo json_encode(Array('error'=>'Message could not be sent.'));
            echo json_encode(Array('error'=>'Mailer Error: ' . $mail->ErrorInfo));
        } else {
            echo json_encode(Array('success'=>'Message has been sent'));
        }


    }else{
        echo json_encode(Array('error'=>'Email id does not exist'));
    }


}else{
    echo json_encode(Array('error'=>'Error in query:'.$conn->error));
}


