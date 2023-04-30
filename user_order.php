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
   <title>User Ordered Books</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/user_style.css">

</head>
<body>

<?php include 'user_header.php'; ?>

<!-- All Orderd section Starts -->

<section class="quick-select">

   <h1 class="heading">Order History</h1>

   <div class="box-container">

      <?php
         $display_user_id = $_SESSION['user_id'];
         $select_book = mysqli_query($conn, "SELECT * FROM `orders` WHERE user_id = '$user_id'") or die('query failed');
            
        
         if(mysqli_num_rows($select_book) > 0){
            while($fetch_orders = mysqli_fetch_assoc($select_book)){
            ?>
         <form action="" method="post" class="box">

         <p> Placed On : <span><?php echo $fetch_orders['placed_on']; ?></span> </p>
         <p> Name : <span><?php echo $fetch_orders['name']; ?></span> </p>
         <p> Phone : <span><?php echo $fetch_orders['number']; ?></span> </p>
         <p> Email : <span><?php echo $fetch_orders['email']; ?></span> </p>
         <p> Payment Method : <span><?php echo $fetch_orders['payment_method']; ?></span> </p>

         <?php if ($fetch_orders['payment_method'] === 'Physical Delivery'): ?>
            <p> Offline Address : <span><?php echo $fetch_orders['offline_address']; ?></span> </p>
         <?php elseif ($fetch_orders['payment_method'] === 'Online Delivery'): ?>
            <p> Bkash Transaction : <span><?php echo $fetch_orders['bkash_transaction']; ?></span> </p>
         <?php endif; ?>

         <p> Your Orders : <span><?php echo $fetch_orders['total_products']; ?></span> </p>
         <p> Total Price : <span><?php echo $fetch_orders['total_price']; ?> TK</span> </p>
         <p> Payment Status : <span style="color:<?php if($fetch_orders['payment_status'] == 'pending'){ echo 'red'; }else{ echo 'green'; } ?>;"><?php echo $fetch_orders['payment_status']; ?></span> </p>
         </form>
            <?php
               }
         }else{
            echo '<p class="empty">You have not applied to any jobs yet</p>';
         }
      ?>
      


   </div>

</section>

<!-- All Ordered section Ends -->

<!-- custom js file link  -->
<script src="js/script.js"></script>

</body>
</html>