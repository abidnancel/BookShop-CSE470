<?php

include 'config.php';

session_start();

$user_id = $_SESSION['user_id'];

if(!isset($user_id)){
   header('location:login.php');
}

if(isset($_POST['update_user_profile'])){

    $update_p_id = $_POST['update_p_id'];

    $update_name = $_POST['update_name'];
    $update_email = $_POST['update_email'];

    $pass = mysqli_real_escape_string($conn, md5($_POST['password']));
    $cpass = mysqli_real_escape_string($conn, md5($_POST['cpassword']));

    // This is for uploading picture
    $profile_image = $_FILES['profile_image']['name'];

    $profile_image_tmp_name = $_FILES['profile_image']['tmp_name'];
    $profile_image_folder = 'uploaded_img/profile_image/'.$profile_image;

    $select_users = mysqli_query($conn, "SELECT * FROM `users` WHERE email = '$update_email' AND password = '$pass'") or die('query failed');

    if(mysqli_num_rows($select_users) > 0){
        
        if($pass != $cpass){
            $message[] = 'Confirm Password Does Not Match';
         }else{
            mysqli_query($conn, "UPDATE `users` SET name = '$update_name',
            email = '$update_email', password = '$pass',
            user_profile_pic = '$profile_image'
            WHERE id = '$update_p_id'") or die('query failed');
            move_uploaded_file($profile_image_tmp_name, $profile_image_folder);
   
            $message[] = 'User Profile Has Been Edited Successfully';
         }
     }else{
        $message[] = 'Password Incorrect';
        
     }

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>User Profile</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/user_style.css">

</head>
<body>

<?php include 'user_header.php'; ?>


<!-- User Profile section Starts -->

<section class="edit-job-form">
         
   <?php
         $update_id = $_SESSION['user_id'];
         $update_query = mysqli_query($conn, "SELECT * FROM `users` WHERE id = '$update_id'") or die('query failed');
         if(mysqli_num_rows($update_query) > 0){
            while($fetch_update = mysqli_fetch_assoc($update_query)){
   ?>
   
   <form action="" method="post" enctype="multipart/form-data">
   <h1 class='heading'>User Profile Edit</h1>
      
      <input type="hidden" name="update_p_id" value="<?php echo $fetch_update['id']; ?>">
      <p style="font-size: 19px; text-align: left;">Edit User Name</p>
      <input type="text" name="update_name" value="<?php echo $fetch_update['name']; ?>" class="box" required placeholder="Edit User Name">
      <p style="font-size: 19px; text-align: left;">Edit User Email</p>
      <input type="text" name="update_email" value="<?php echo $fetch_update['email']; ?>" class="box" required placeholder="Edit User Email">

      <p style="font-size: 19px; text-align: left;">Upload Your Picture</p>
      <input type="file" name="profile_image" accept="profile_image/jpg, profile_image/jpeg, profile_image/png" class="box" required>
      
      <p style="font-size: 19px; text-align: left;">Change Password</p>
      <input type="password" name="password" placeholder="Enter Password" required class="box">
      <input type="password" name="cpassword" placeholder="Confirm Password" required class="box">

      <input type="submit" value="update" name="update_user_profile" class="btn">
      <input type="reset" value="cancel" id="close-update" class="option-btn" onclick="window.location = 'user_dashboard.php'">
   </form>
   <?php
         }
      }
      
   ?>

</section>
<!-- User Profile Detail section Ends -->

<!-- custom js file link  -->
<script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
<script src="js/script.js"></script>

</body>
</html>