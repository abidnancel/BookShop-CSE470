<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'phpmailer/src/Exception.php';
require 'phpmailer/src/PHPMailer.php';
require 'phpmailer/src/SMTP.php';

include 'config.php';

if(isset($_POST['reset_password'])){
   $email = mysqli_real_escape_string($conn, $_POST['email']);

   $select_users = mysqli_query($conn, "SELECT * FROM `users` WHERE email = '$email'") or die('query failed');

   if(mysqli_num_rows($select_users) <= 0){
      $message[] = 'User does not exist with this email';
   }else{
        $temp_code = rand(1000000000, 9999999999); // 10 digit code
        mysqli_query($conn, "UPDATE `users` SET temp_code ='$temp_code' WHERE email='$email'") or die('query failed');
        $message[] = 'An email with a code has been sent';

        $mail = new PHPMailer(true);

        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'sunakodesu123@gmail.com';
        $mail->Password = 'htfhfazgjpekrjlk';
        $mail->SMTPSecure = 'ssl';
        $mail->Port = 465;

        $mail->setFrom('sunakodesu123@gmail.com');
        $mail->addAddress($email);

        $mail->isHTML(true);

        $mail->Subject = ('Password Reset by CSE470 Book Shop');

        $mail->Body = $temp_code;

        $mail->send();

        

        header('location:forgot_password_reset.php');
      
   }

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Forgot Password</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>



<?php
if(isset($message)){
   foreach($message as $message){
      echo '
      <div class="message">
         <span>'.$message.'</span>
         <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
      </div>
      ';
   }
}
?>
   
<div class="form-container">

   <form action="" method="post">
      <h3>Reset Password</h3>
      <input type="email" name="email" placeholder="Enter Your Email" required class="box">

      <input type="submit" name="reset_password" value="Send Code" class="btn">
      <p>Already have an account? <a href="login.php">Login Now</a></p>
   </form>

</div>

</body>
</html>