<?php

include 'config.php';

session_start();


$user_id = $_SESSION['admin_id'];

if(!isset($user_id)){
   header('location:login.php');
}

if(isset($_POST['send_message'])){
    $message_detail = $_POST['message_detail'];
    $company_id = $_SESSION['admin_id'];
    $specific_job_seeker = $_GET['job_seeker_id'];
    $insert_message = mysqli_query($conn, "INSERT INTO message (message_detail, message_sender_id, message_receiver_id) VALUES ('$message_detail', '$company_id', '$specific_job_seeker')") or die('query failed');
    header('location:'.$_SERVER['REQUEST_URI']);
 
 }


?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Admin Message Details</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/admin_style.css">
   <!-- <link rel="stylesheet" href="css/user_style.css"> -->

</head>
<body>

<?php include 'admin_header.php'; ?>

<!-- quick select section starts  -->

<section class="quick-select">

    <h1 class="heading">
        <?php 
        $temp_id = $_GET['job_seeker_id'];
        
        $userMessage = mysqli_query($conn, "SELECT name FROM `users` WHERE id='$temp_id'") or die('query failed');
        
        if(mysqli_num_rows($userMessage) > 0){
            $row = mysqli_fetch_assoc($userMessage);
            echo 'Messages From: '.$row['name'];
        }
        ?>
    </h1>

<form method="post">
  <div class="box-container">
    <textarea type="text" name="message_detail" cols="150" rows="5" class="box" required placeholder="Type Any Message"></textarea>
  </div>
  <input type="submit" value="Send Message" name="send_message" class="btn" style="border: 1px solid black;">
</form>

<br>

<div class="box-container">
   <?php
        $user_id = $_SESSION['admin_id'];
        $admin_id = $_GET['job_seeker_id'];
        $select_post = mysqli_query($conn, "SELECT 
        users.name as Sender_name,
        message.message_time,
        message.message_detail
    FROM 
        message
        JOIN users ON message.message_sender_id = users.id
    WHERE 
        (message.message_receiver_id = '$user_id' AND message.message_sender_id = '$admin_id') OR (message.message_receiver_id = '$admin_id' AND message.message_sender_id = '$user_id')
    ORDER BY 
        message_time DESC
    ") or die('query failed');
        if(mysqli_num_rows($select_post) > 0){
        ?>
        <div class="box">
        <?php while($fetch_job = mysqli_fetch_assoc($select_post)){ ?>
            <div class="box">
            <p> <span><?php echo $fetch_job['Sender_name']; ?></span> </p>
            <p> <?php echo $fetch_job['message_detail']; ?></span> </p>
            <p> <span class="details"><span><?php echo $fetch_job['message_time']; ?></span> </p>
            
            </div>
            <br>
            <br>
            
        <?php } ?>
        </div>
        <?php
        }else{
        echo '<div class="box"><p class="empty">Empty Message Box</p></div>';
        }
        ?>



</div>
<!-- <p> <span class="details"><span><?php echo $fetch_job['message_time']; ?></span> </p> -->
<style>
.box p { position: relative; }
.box .details { position: absolute; top: 0; right: 0; }
</style>




</section>

<!-- quick select section ends -->

<!-- custom js file link  -->
<script src="js/admin_script.js"></script>

</body>
</html>