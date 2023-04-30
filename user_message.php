<?php

include 'config.php';

session_start();

$user_id = $_SESSION['user_id'];

if(!isset($user_id)){
   header('location:login.php');
}


if (isset($_GET['job_seeker_id'])) {
    header('Location: /CSE470_BOOK_SHOP/user_message_details.php');

}
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>User Messages</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/user_style.css">

</head>
<body>

<?php include 'user_header.php'; ?>

<!-- quick select section starts  -->

<section class="quick-select">

   <h1 class="heading">All Messages</h1>

   <div class="box-container">
   <?php
      $user_id = $_SESSION['user_id'];
      $select_post = mysqli_query($conn, "SELECT users.name AS user_name, max(message.message_time) AS message_time, users.id AS user_id, user_type
      FROM users INNER JOIN message on users.id = message.message_sender_id WHERE user_type = 'admin'
      GROUP BY users.name
      ORDER BY message.message_time ASC
      ") or die('query failed');
      if(mysqli_num_rows($select_post) > 0){
         while($fetch_job = mysqli_fetch_assoc($select_post)){
      ?>
      <div class="box">
        <a href="user_message_details.php?job_seeker_id=<?php echo $fetch_job['user_id']; ?>"><p> Name : <span><?php echo $fetch_job['user_name']; ?></span> </p></a>
        <p> Latest Message : <span><?php echo $fetch_job['message_time']; ?></span> </p>
        
      </div>
      <?php
         }
      }else{
         echo '<p class="empty">No Messages To Show</p>';
      }
      ?>

   </div>

</section>

<!-- quick select section ends -->

<!-- custom js file link  -->
<script src="js/script.js"></script>

</body>
</html>