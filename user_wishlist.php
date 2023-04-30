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
   <title>User Wishlist</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/user_style.css">

</head>
<body>

<?php include 'user_header.php'; ?>

<!-- All jobs section Starts -->

<section class="quick-select">

   <h1 class="heading">Wishlist</h1>

   <div class="box-container">

      <?php
         $display_user_id = $_SESSION['user_id'];
         $select_book = mysqli_query($conn, "SELECT
         wishlist.*,
         users.name AS user_name,
         products.name AS product_name, products.price AS product_price, products.image as product_image
     FROM
         wishlist
         JOIN users ON wishlist.wishlist_user_id = users.id
         JOIN products ON wishlist.wishlist_book_id = products.id WHERE wishlist.wishlist_user_id = '$display_user_id' ORDER BY wishlist_time desc") or die('query failed');
            
        
         if(mysqli_num_rows($select_book) > 0){
            while($fetch_products = mysqli_fetch_assoc($select_book)){
            ?>
         <form action="" method="post" class="box">
            <p><img src="uploaded_img/<?php echo $fetch_products['product_image']; ?>" alt="Book Image" style="width: 150px; height: 200px;"></span> </p>
            <div class="title"><a style="font-size: 25px;" href="product_details.php?update=<?php echo $fetch_products['wishlist_book_id']; ?>"><?php echo $fetch_products['product_name']; ?></a></div>
            <p style="font-size: 18px;">Price: <span></span></p>

            <br>
            <div class="box">
            <p style="font-size: 20px;"><span><?php echo $fetch_products['product_price']; ?> TK</span></p>
            </div>
        
         </form>
            <?php
               }
         }else{
            echo '<p class="empty">You do not have anything in your wishlist</p>';
         }
      ?>
      


   </div>

</section>

<!-- All jobs section Ends -->


<!-- custom js file link  -->
<script src="js/script.js"></script>

</body>
</html>