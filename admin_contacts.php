<?php

include 'config.php';

session_start();


$user_id = $_SESSION['admin_id'];

if(!isset($user_id)){
   header('location:login.php');
}


if(isset($_GET['delete'])){
   $delete_id = $_GET['delete'];
   mysqli_query($conn, "DELETE FROM `message` WHERE id = '$delete_id'") or die('query failed');
   header('location:admin_contacts.php');
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Admin Message</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- custom admin css file link  -->
   <link rel="stylesheet" href="css/admin_style.css">

</head>
<body>
   
<?php include 'admin_header.php'; ?>

<section class="messages">

   <h1 class="title"> Messages </h1>

   <div class="box-container">
   <?php
      $admin_id = $_SESSION['admin_id'];
      $select_post = mysqli_query($conn, "SELECT users.name AS user_name, max(message.message_time) AS message_time, users.id AS user_id, user_type
      FROM users INNER JOIN message on users.id = message.message_sender_id WHERE user_type = 'user'
      GROUP BY users.name
      ORDER BY message.message_time ASC") or die('query failed');
      if(mysqli_num_rows($select_post) > 0){
         while($fetch_job = mysqli_fetch_assoc($select_post)){
      ?>
      <div class="box">
        <a href="admin_contacts_details.php?job_seeker_id=<?php echo $fetch_job['user_id']; ?>"><p> Name : <span><?php echo $fetch_job['user_name']; ?></span> </p></a>
        
         
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









<!-- custom admin js file link  -->
<script src="js/admin_script.js"></script>

</body>
</html>