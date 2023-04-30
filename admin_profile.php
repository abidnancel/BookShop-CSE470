<?php

include 'config.php';

session_start();

$user_id = $_SESSION['admin_id'];

if(!isset($user_id)){
   header('location:login.php');
}

if(isset($_POST['send_user_info'])){

   $user_original_email = mysqli_real_escape_string($conn, $_POST['user_original_email']);

   $name = mysqli_real_escape_string($conn, $_POST['user_name']);
   $email = mysqli_real_escape_string($conn, $_POST['user_email']);
   $pass = mysqli_real_escape_string($conn, md5($_POST['user_password']));
   $cpass = mysqli_real_escape_string($conn, md5($_POST['check_password']));

   $select_users = mysqli_query($conn, "SELECT * FROM `users` WHERE email='$user_original_email'") or die('query failed');

   if (mysqli_num_rows($select_users) > 0) {
      if ($pass != $cpass) {
         $message[] = 'Confirm Password Does not Match';
      } elseif($pass == $cpass) {
         mysqli_query($conn, "UPDATE `users` SET name='$name', email='$email', password='$pass' where id='$user_id'") or die('query failed');
         $message[] = 'User Info Has Been Successfully Changed';
         $_SESSION['admin_name'] = $name;
         $_SESSION['admin_email'] = $email;
      }
   }

}
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Admin Profile</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">
   <link rel="stylesheet" href="css/admin_style.css">

</head>
<body>
   
<?php include 'admin_header.php'; ?>



<section class="contact">

      <?php

         $check_password = 0;

         $select_user_profile = mysqli_query($conn, "SELECT * FROM `users` WHERE id = '$user_id'") or die('query failed');

         
         if(mysqli_num_rows($select_user_profile) > 0){
            while($fetch_user_info = mysqli_fetch_assoc($select_user_profile)){
      ?>
         <form action="" method="post">
            <h3>Edit User Profile</h3>
            <input type="text" name="user_original_email" required placeholder="Enter Your Name" value="<?php echo $fetch_user_info['email']; ?>" class="box" hidden>
            <input type="text" name="user_name" required placeholder="Enter Your Name" value="<?php echo $fetch_user_info['name']; ?>" class="box">
            <input type="text" name="user_email" required placeholder="Enter Your Email" value="<?php echo $fetch_user_info['email']; ?>" class="box">
            <input type="password" name="user_password" required placeholder="Enter Your Password" value="" class="box">
            <input type="password" name="check_password" required placeholder="Confirm Your Password" value="" class="box">


            <input type="submit" value="Update User Info" name="send_user_info" class="btn">
         </form>
      <?php
         }
      }else{
         echo '<p class="empty">no products added yet!</p>';
      }
      ?>

</section>


<!-- custom js file link  -->
<script src="js/script.js"></script>

</body>
</html>