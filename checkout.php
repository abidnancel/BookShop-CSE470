<?php

include 'config.php';

session_start();

$user_id = $_SESSION['user_id'];

if(!isset($user_id)){
   header('location:login.php');
}

if(isset($_POST['order_btn'])){

   $name = mysqli_real_escape_string($conn, $_POST['name']);
   $number = $_POST['number'];
   $email = mysqli_real_escape_string($conn, $_POST['email']);
   $bkash_transaction = mysqli_real_escape_string($conn, $_POST['delivery_link']);
   $offline_address =  mysqli_real_escape_string($conn, $_POST['delivery_address']);
   $payment_method = mysqli_real_escape_string($conn, $_POST['delivery_method']);
   $placed_on = date('d-M-Y');

   $cart_total = 0;
   $cart_products[] = '';

   $cart_query = mysqli_query($conn, "SELECT * FROM `cart` WHERE user_id = '$user_id'") or die('query failed');
   if(mysqli_num_rows($cart_query) > 0){
      while($cart_item = mysqli_fetch_assoc($cart_query)){
         $cart_products[] = $cart_item['name'].' ('.$cart_item['quantity'].') ';
         $sub_total = ($cart_item['price'] * $cart_item['quantity']);
         $cart_total += $sub_total;
      }
   }

   $total_products = implode(', ',$cart_products);

   $order_query = mysqli_query($conn, "SELECT * FROM `orders` WHERE name = '$name' AND number = '$number' AND email = '$email' AND bkash_transaction = '$bkash_transaction' AND offline_address = '$offline_address' AND total_products = '$total_products' AND total_price = '$cart_total' AND payment_method = '$payment_method'") or die('query failed');

   if($cart_total == 0){
      $message[] = 'your cart is empty';
   }else{
      if(mysqli_num_rows($order_query) > 0){
         $message[] = 'order already placed!'; 
      }else{
         mysqli_query($conn, "INSERT INTO `orders`(user_id, name, number, email, bkash_transaction, total_products, total_price, placed_on, offline_address, payment_method) VALUES('$user_id', '$name', '$number', '$email', '$bkash_transaction', '$total_products', '$cart_total', '$placed_on', '$offline_address', '$payment_method')") or die('query failed');
         $message[] = 'order placed successfully!';
         mysqli_query($conn, "DELETE FROM `cart` WHERE user_id = '$user_id'") or die('query failed');
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
   <title>checkout</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>
   
<?php include 'header.php'; ?>

<div class="heading">
   <h3>checkout</h3>
   <p> <a href="home.php">home</a> / checkout </p>
</div>

<section class="display-order">

   <?php  
      $grand_total = 0;
      $select_cart = mysqli_query($conn, "SELECT * FROM `cart` WHERE user_id = '$user_id'") or die('query failed');
      if(mysqli_num_rows($select_cart) > 0){
         while($fetch_cart = mysqli_fetch_assoc($select_cart)){
            $total_price = ($fetch_cart['price'] * $fetch_cart['quantity']);
            $grand_total += $total_price;
   ?>
   <p> <?php echo $fetch_cart['name']; ?> <span>(<?php echo '$'.$fetch_cart['price'].'/-'.' x '. $fetch_cart['quantity']; ?>)</span> </p>
   <?php
      }
   }else{
      echo '<p class="empty">your cart is empty</p>';
   }
   ?>
   <div class="grand-total"> grand total : <span>$<?php echo $grand_total; ?>/-</span> </div>

</section>

<section class="checkout">

   <form action="" method="post">
      <h3>place your order</h3>
      <div class="flex">
         <div class="inputBox">
            <span>Your Name :</span>
            <input type="text" name="name" required placeholder="enter your name">
         </div>
         <div class="inputBox">
            <span>Your Phone Number :</span>
            <input type="number" name="number" required placeholder="enter your number">
         </div>
         <div class="inputBox">
            <span>Your Email :</span>
            <input type="email" name="email" required placeholder="enter your email">
         </div>
         <div class="inputBox">
            <span>Delivery Method :</span>
            <select name="delivery_method" required>
               <option value="">Select a delivery method</option>
               <option value="Physical Delivery">Physical Delivery</option>
               <option value="Online Delivery">Online Delivery</option>
            </select>
         </div>
         <div class="inputBox" id="delivery_address" style="display:none">
            <span>Delivery Address :</span>
            <input type="text" name="delivery_address" placeholder="Enter your delivery address">
         </div>
         <div class="inputBox" id="delivery_link" style="display:none">
            <span>Bkash: 01302542301</span>
            <input type="text" name="delivery_link" placeholder="Enter Bkash Transaction Number After Sending Money">
         </div>
      </div>
      <input type="submit" value="order now" class="btn" name="order_btn">
   </form>

</section>

<script>
   const deliveryMethodSelect = document.querySelector('select[name="delivery_method"]');
   const deliveryAddress = document.getElementById('delivery_address');
   const deliveryLink = document.getElementById('delivery_link');

   deliveryMethodSelect.addEventListener('change', () => {
      if (deliveryMethodSelect.value === 'Physical Delivery') {
         deliveryAddress.style.display = 'block';
         deliveryLink.style.display = 'none';
      } else if (deliveryMethodSelect.value === 'Online Delivery') {
         deliveryAddress.style.display = 'none';
         deliveryLink.style.display = 'block';
      } else {
         deliveryAddress.style.display = 'none';
         deliveryLink.style.display = 'none';
      }
   });
</script>










<?php include 'footer.php'; ?>

<!-- custom js file link  -->
<script src="js/script.js"></script>

</body>
</html>