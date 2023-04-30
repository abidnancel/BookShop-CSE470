<?php

include 'config.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
   header('location:login.php');
};

if(isset($_POST['add_voucher'])){ //This will be called when the user presses post blog

    $user_id = $admin_id;
 
    $voucher_code = mysqli_real_escape_string($conn, $_POST['voucher_code']);
    $voucher_discount = mysqli_real_escape_string($conn, $_POST['voucher_discount']);
    $voucher_expiration_date = mysqli_real_escape_string($conn, $_POST['voucher_expiration_date']);
 
    $add_blog_query = mysqli_query($conn, "INSERT INTO `vouchers`(voucher_code, voucher_expiration_date, voucher_discount) VALUES('$voucher_code', '$voucher_expiration_date', '$voucher_discount')") or die('query failed');
 
     if($add_blog_query){
         $message[] = 'Voucher Has Been Added';
     }else{
         $message[] = 'Could Not Post The Blog';
     }
    
 }

if(isset($_GET['delete'])){
   $delete_id = $_GET['delete'];
   mysqli_query($conn, "DELETE FROM `vouchers` WHERE voucher_id = '$delete_id'") or die('query failed');
   header('location:admin_voucher.php');
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Admin Voucher</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- custom admin css file link  -->
   <link rel="stylesheet" href="css/admin_style.css">
   <link rel="stylesheet" href="css/style.css">

</head>
<body>
   
<?php include 'admin_header.php'; ?>

<!-- product CRUD section starts  -->

<section class="add-products">

   <h1 class="title">All Vouchers</h1>

   <form action="" method="post" enctype="multipart/form-data">
      <h3>Add A Voucher</h3>

      <input type="text" name="voucher_code" class="box" placeholder="Enter Voucher" required>

      <input type="number" name="voucher_discount" class="box" placeholder="Enter Discount Amount" required>
    
      <input type="date" name="voucher_expiration_date" class="box" placeholder="Publication Date" required>


      <input type="submit" value="Add Voucher" name="add_voucher" class="btn">
   </form>

</section>

<!-- product CRUD section ends -->


<section class="add-products">

   <h1 class="title">Available Vouchers</h1>

</section>



<!-- show products  -->

<section class="show-products">

   <div class="box-container">

   <?php

        $current_date = date('Y-m-d');

        $select_voucher = mysqli_query($conn, "SELECT * FROM `vouchers` WHERE voucher_expiration_date > '$current_date'") or die('query failed');
                    
        if(mysqli_num_rows($select_voucher) > 0){
        while($fetch_products = mysqli_fetch_assoc($select_voucher)){
        ?>
        <div class="box">
        <div class="price"><?php echo $fetch_products['voucher_code']; ?></div>
         <div class="name">Discount <?php echo $fetch_products['voucher_discount']; ?> Taka</div>
            <div class="name">Created on: <?php echo $fetch_products['voucher_creation_date']; ?></div>
            <div class="name">Expires on: <?php echo $fetch_products['voucher_expiration_date']; ?></div>
            <!-- <div class="price"><?php echo $fetch_products['price']; ?></div> -->
            <a href="admin_voucher.php?delete=<?php echo $fetch_products['voucher_id']; ?>" class="delete-btn" onclick="return confirm('delete this product?');">delete</a>
        </div>
        <?php
        }
        }else{
        echo '<p class="empty">No Available Voucher</p>';
        }
    ?>

   </div>

</section>

<section class="add-products">

   <h1 class="title">Expired Vouchers</h1>

</section>

<section class="show-products">

   <div class="box-container">

   <?php

        $current_date = date('Y-m-d');

        $select_voucher = mysqli_query($conn, "SELECT * FROM `vouchers` WHERE voucher_expiration_date < '$current_date'") or die('query failed');
                    
        if(mysqli_num_rows($select_voucher) > 0){
        while($fetch_products = mysqli_fetch_assoc($select_voucher)){
        ?>
        <div class="box">
            <div class="price"><?php echo $fetch_products['voucher_code']; ?></div>
            <div class="name">Discount <?php echo $fetch_products['voucher_discount']; ?> Taka</div>
            <div class="name">Created on: <?php echo $fetch_products['voucher_creation_date']; ?></div>
            <div class="name">Expires on: <?php echo $fetch_products['voucher_expiration_date']; ?></div>
            <a href="admin_voucher.php?delete=<?php echo $fetch_products['voucher_id']; ?>" class="delete-btn" onclick="return confirm('delete this product?');">delete</a>
        </div>
        <?php
        }
        }else{
        echo '<p class="empty">No Voucher Has Been Expired</p>';
        }
    ?>

   </div>

</section>




<!-- custom admin js file link  -->
<script src="js/admin_script.js"></script>

</body>
</html>