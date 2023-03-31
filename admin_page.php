<?php

include 'config.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
   header('location:login.php');
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>admin panel</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- custom admin css file link  -->
   <link rel="stylesheet" href="css/admin_style.css">

</head>
<body>
   
<?php include 'admin_header.php'; ?>

<!-- admin dashboard section starts  -->

<section class="dashboard">

   <h1 class="title">Admin Dashboard</h1>

   <div class="box-container">
      <div class="box">
         <?php
            $total_earned = 0;
            $select_completed = mysqli_query($conn, "SELECT sum(total_price) AS total_earned FROM `orders`") or die('query failed');
            if(mysqli_num_rows($select_completed) > 0){
               while($fetch_earned = mysqli_fetch_assoc($select_completed)){
                  $total_earned = $fetch_earned['total_earned'];
               };
            };
         ?>
         <h3><?php echo $total_earned; ?> TK</h3>
         <p>Total Earned</p>
      </div>

      <div class="box">
         <?php
            $select_pendings = mysqli_query($conn, "SELECT count(id) AS total_pendings FROM `orders` WHERE payment_status='pending'") or die('query failed');
            $number_of_pendings = 0;
            if(mysqli_num_rows($select_pendings) > 0){
               while($fetch_users = mysqli_fetch_assoc($select_pendings)){
                  $number_of_pendings = $fetch_users['total_pendings'];
               };
            };
         ?>
         <h3><?php echo $number_of_pendings; ?></h3>
         <p>Total Pendings</p>
      </div>


      <div class="box">
         <?php 
            $select_users = mysqli_query($conn, "SELECT count(user_type) AS total_users FROM users WHERE user_type='user'") or die('query failed');
            $number_of_users = 0;
            if(mysqli_num_rows($select_users) > 0){
               while($fetch_users = mysqli_fetch_assoc($select_users)){
                  $number_of_users = $fetch_users['total_users'];
               };
            };
         ?>
         <h3><?php echo $number_of_users; ?></h3>
         <p>Total Users</p>
      </div>

      <div class="box">
         <?php 
            $select_admins = mysqli_query($conn, "SELECT count(user_type) AS total_admins FROM users WHERE user_type='admin'") or die('query failed');
            $number_of_admins = 0;
            if(mysqli_num_rows($select_admins) > 0){
               while($fetch_users = mysqli_fetch_assoc($select_admins)){
                  $number_of_admins = $fetch_users['total_admins'];
               };
            };
         ?>
         <h3><?php echo $number_of_admins; ?></h3>
         <p>Total Admins</p>
      </div>

      <div class="box">
         <?php 
            
            $select_messages = mysqli_query($conn, "SELECT count(id) as total_messages from message;") or die('query failed');
            $number_of_messages = 0;
            if(mysqli_num_rows($select_messages) > 0){
               while($fetch_users = mysqli_fetch_assoc($select_messages)){
                  $number_of_messages = $fetch_users['total_messages'];
               };
            };
         ?>
         <h3><?php echo $number_of_messages; ?></h3>
         <p>Total Messages</p>
      </div>

      <div class="box">
         <?php 
            
            $select_posts = mysqli_query($conn, "SELECT count(id) as total_posts from `admin_news`;") or die('query failed');
            $number_of_posts = 0;
            if(mysqli_num_rows($select_posts) > 0){
               while($fetch_users = mysqli_fetch_assoc($select_posts)){
                  $number_of_posts = $fetch_users['total_posts'];
               };
            };
         ?>
         <h3><?php echo $number_of_posts; ?></h3>
         <p>Total Posts</p>
      </div>

      <div class="box">
         <?php 
            $select_orders = mysqli_query($conn, "SELECT count(id) AS total_orders FROM `orders`") or die('query failed');
            $number_of_orders = 0;
            if(mysqli_num_rows($select_orders) > 0){
               while($fetch_users = mysqli_fetch_assoc($select_orders)){
                  $number_of_orders = $fetch_users['total_orders'];
               };
            };
         ?>
         <h3><?php echo $number_of_orders; ?></h3>
         <p>Total Orders</p>
      </div>

      <div class="box">
         <?php 
            $select_products = mysqli_query($conn, "SELECT count(id) AS total_products FROM `products`") or die('query failed');
            $number_of_orders = 0;
            if(mysqli_num_rows($select_products) > 0){
               while($fetch_users = mysqli_fetch_assoc($select_products)){
                  $number_of_orders = $fetch_users['total_products'];
               };
            };
         ?>
         <h3><?php echo $number_of_orders; ?></h3>
         <p>Total Products</p>
      </div>


   </div>

</section>

<!-- admin dashboard section ends -->









<!-- custom admin js file link  -->
<script src="js/admin_script.js"></script>

</body>
</html>