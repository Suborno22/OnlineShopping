<?php
use PHPMailer\PHPMailer\PHPMailer;
require __DIR__.'/../config/conn.php';

$sendMail = $_POST['email']; 
$sendMail = $conn->real_escape_string($sendMail);


$checkEmail = "SELECT * FROM `user_table` WHERE email = '$sendMail'";

$result = $conn->query($checkEmail);

if($result){
    if($result->num_rows > 0){

        $OTP = rand(1111,9999);
    
        require_once '../vendor/autoload.php';

        $mail = new PHPMailer();

        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'subornodas666@gmail.com';
        $mail->Password = 'vfkiddjkrnslggfv';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        $mail->setFrom('subornodas666@gmail.com', 'Password recovery');
        $mail->addAddress($sendMail, 'Me');
        $mail->Subject = 'Change your password';
        // Set HTML 
        $mail->isHTML(TRUE);
        $mail->Body = "<html>Here is your OTP: `$OTP`</br> </html>";
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


