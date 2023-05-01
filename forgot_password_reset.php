<?php

include 'config.php';
session_start();

if(isset($_POST['reset_password'])){

   $email = mysqli_real_escape_string($conn, $_POST['email']);

   $code = mysqli_real_escape_string($conn, $_POST['code']);

   $pass = mysqli_real_escape_string($conn, md5($_POST['update_password']));

   $cpass = mysqli_real_escape_string($conn, md5($_POST['confirm_password']));

   $select_users = mysqli_query($conn, "SELECT * FROM `users` WHERE email = '$email'") or die('query failed');

   if(mysqli_num_rows($select_users) > 0){
    if($pass != $cpass){
        $message[] = 'confirm password not matched!';
     }else{
        $select_users_code = mysqli_query($conn, "SELECT * FROM `users` WHERE email = '$email' AND temp_code = '$code'") or die('query failed');
        if((mysqli_num_rows($select_users_code) > 0) && ($code != 0)){
            mysqli_query($conn, "UPDATE `users` SET password ='$pass' WHERE email='$email'") or die('query failed');

            mysqli_query($conn, "UPDATE `users` SET temp_code = 0 WHERE email='$email'") or die('query failed');
            header('location:login.php');
        }else{
            $message[] = 'Code Invalid';
        }
     }

   }else{
      $message[] = 'No one with this email';
   }

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Reset Password</title>

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
      <input type="number" name="code" placeholder="Enter The Code" required class="box">
      <input type="password" name="update_password" placeholder="Enter Your Password" required class="box">
      <input type="password" name="confirm_password" placeholder="confirm Your Password" required class="box">

      <input type="submit" name="reset_password" value="Reset Password" class="btn">
   </form>

</div>

</body>
</html>