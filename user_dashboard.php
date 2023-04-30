<?php

include 'config.php';

session_start();

$user_id = $_SESSION['user_id'];

if(!isset($user_id)){
   header('location:login.php');
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>User Dashboard</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/user_style.css">

</head>
<body>

<?php include 'user_header.php'; ?>

<!-- User Status section starts  -->

<section class="quick-select">

   <h1 class="heading">User Dashboard</h1>

   <div class="box-container">

      <div class="box">
         <?php
         $user_id = $_SESSION['user_id'];
         $select_post = mysqli_query($conn, "SELECT *
                     FROM `orders`
                     WHERE user_id='$user_id'") or die('query failed');
         $total_bought = mysqli_num_rows($select_post); // Counting the total number of applicants
                  
         ?>
         <h3 class="title">Total Ordered: <?php echo $total_bought ?> Times</h3>
         </div>

      <div class="box">
      <?php
         $user_id = $_SESSION['user_id'];
         $select_post = mysqli_query($conn, "SELECT DISTINCT message_sender_id
                     FROM `message`
                     WHERE message_receiver_id='$user_id'") or die('query failed');
         $total_applicants = mysqli_num_rows($select_post); // Counting the total number of applicants
         $latest_applicant = null;
         

         ?>
         <h3 class="title">Total Messages: <?php echo $total_applicants ?></h3>
         
      </div>
      


   </div>

</section>

<!-- User status section ends -->

<!-- custom js file link  -->
<script src="js/script.js"></script>

</body>
</html>