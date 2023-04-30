<?php

include 'config.php';

session_start();

$user_id = $_SESSION['user_id'];

if(!isset($user_id)){
   header('location:login.php');
}

if(isset($_POST['add_to_wishlist'])){

   $wishlist_user_id = $_SESSION['user_id'];
   $wishlist_book_id = $_POST['update_book_id'];

   $check_cart_numbers = mysqli_query($conn, "SELECT * FROM `wishlist` WHERE wishlist_user_id = '$wishlist_user_id' AND wishlist_book_id = '$wishlist_book_id'") or die('query failed');

   if(mysqli_num_rows($check_cart_numbers) > 0){
      $message[] = 'You have already wishlisted this book!';
   }else{
      mysqli_query($conn, "INSERT INTO `wishlist`(wishlist_user_id, wishlist_book_id) VALUES('$wishlist_user_id', '$wishlist_book_id')") or die('query failed');
      $message[] = 'Added to the wishlist!';
   }

}

if(isset($_POST['add_to_cart'])){

   $product_name = $_POST['product_name'];
   $product_price = $_POST['product_price'];
   $product_image = $_POST['product_image'];
   $product_quantity = $_POST['product_quantity'];

   $check_cart_numbers = mysqli_query($conn, "SELECT * FROM `cart` WHERE name = '$product_name' AND user_id = '$user_id'") or die('query failed');

   if(mysqli_num_rows($check_cart_numbers) > 0){
      $message[] = 'already added to cart!';
   }else{
      mysqli_query($conn, "INSERT INTO `cart`(user_id, name, price, quantity, image) VALUES('$user_id', '$product_name', '$product_price', '$product_quantity', '$product_image')") or die('query failed');
      $message[] = 'product added to cart!';
   }

}

if(isset($_POST['write_review'])){

   $user_reviewer_id = $_SESSION['user_id'];
   $product_id = $_GET['update'];
   $reviewer_name = $_SESSION['user_name'];
   $review_details = $_POST['user_review_details'];

   $user_rating = $_POST['user_rating'];

   $check_cart_numbers = mysqli_query($conn, "SELECT * FROM `product_reviews` WHERE user_reviewer_id = '$user_reviewer_id' AND product_id = '$product_id'") or die('query failed');

   if(mysqli_num_rows($check_cart_numbers) > 0){
      $message[] = 'Sorry, you can only post 1 review';
   }else{
      mysqli_query($conn, "INSERT INTO `product_reviews` (user_reviewer_id, product_id, reviewer_name, review_details, user_rating) VALUES('$user_reviewer_id', '$product_id', '$reviewer_name', '$review_details', '$user_rating')") or die('query failed');
      $message[] = 'Your review has been added';
   }

}


?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Product Details</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/admin_style.css">
   <link rel="stylesheet" href="css/style.css">

   <style>
		.qty {
			display: block;
			margin: 0 auto;
			text-align: center;
			border: 1px solid black;
			border-radius: 5px;
			width: 10rem;
			height: 5rem;
			font-size: 2rem;
			line-height: 1.5rem;
			padding: 0.5rem;
		}

      .form-rating {
      display: flex;
      flex-direction: row;
      align-items: center;
      font-size: 1.8rem;
      margin-bottom: 1rem;
      }

      .form-rating label {
      margin-right: 1rem;
      }

      .form-rating select {
      border: 1px solid black;
      border-radius: 0.5rem;
      font-size: 1.8rem;
      padding: 0.5rem;
      }

      .form-rating select option {
      font-size: 1.8rem;
      }

      .form-rating select:focus {
      outline: none;
      }
	</style>

</head>
<body>
   
<?php include 'header.php'; ?>

<div class="heading">
   <h3 style="color: white;">Book Details</h3>
   <p style="color: #ccc;"> <a href="home.php">Home</a> / Book Details </p>
</div>

<!-- This is for search, category, dropdown dropdown menu ENDS -->

<section class="edit-job-form">

   <?php
      if(isset($_GET['update'])){
         $book_detail_id = $_GET['update'];
      $update_query = mysqli_query($conn, "SELECT * FROM `products` INNER JOIN `current_product_details` on products.id = current_product_details.product_id WHERE id = '{$book_detail_id}'") or die('query failed');
         if(mysqli_num_rows($update_query) > 0){
            while($fetch_update = mysqli_fetch_assoc($update_query)){
               
   ?>    
             
      
         <form action="" method="post" enctype="multipart/form-data">
        
            <input type="hidden" name="update_book_id" value="<?php echo $fetch_update['id']; ?>">
            

            <a href="sample_book/<?php echo urlencode($fetch_update['book_sample']); ?>" target="_blank">
  <img name='product_image' src="uploaded_img/<?php echo $fetch_update['image']; ?>" alt="" width="500" height="716"></a> 
            <p type="text" name="show_product_name" class="box" style="font-size: 20px; color: red;"><?php echo $fetch_update['name']; ?></p>
            <p type="text" name="show_book_author_name" class="box" style="font-size: 15px; color: black;">Author: <?php echo $fetch_update['author_name']; ?></p>
            <p type="text" name="show_book_title" class="box" style="font-size: 15px;">Genre: <?php echo $fetch_update['book_genre']; ?></p>
            <textarea type="text" name="show_book_description" cols="30" rows="10" class="box" disabled><?php echo $fetch_update['description']; ?></textarea>
            <p type="text" name="show_book_title" class="box" style="font-size: 15px;">Language: <?php echo $fetch_update['book_language']; ?></p>
            <p type="text" name="show_book_title" class="box" style="font-size: 15px;">Pages: <?php echo $fetch_update['page_numbers']; ?></p>
            
            <p type="text" name="show_book_title" class="box" style="font-size: 15px;">Publication Date: <?php echo $fetch_update['publication_date']; ?></p>
            <input type="number" min="1" name="product_quantity" value="1" class="qty">

            <input type="submit" value="Add to Wishlist" name="add_to_wishlist" class="btn" style="background-color: green;">
            <input type="submit" value="add to cart" name="add_to_cart" class="btn">

            <input type="hidden" name="product_name" value="<?php echo $fetch_update['name']; ?>">
            <input type="hidden" name="product_price" value="<?php echo $fetch_update['price']; ?>">
            <input type="hidden" name="product_image" value="<?php echo $fetch_update['image']; ?>">
         </form>
         
   <?php
         }
      }
      }
   ?>

</section>

<section class="show-reviews">
    <div class="box-container">
         <?php
            $current_book = $_GET['update'];
            $current_user = $_SESSION['user_id'];
            $check_book_query = $update_query = mysqli_query($conn, "SELECT * FROM `users` INNER JOIN `product_reviews` on users.id = product_reviews.user_reviewer_id WHERE user_reviewer_id = '$current_user' AND product_id = '$current_book'") or die('query failed');
            if(mysqli_num_rows($check_book_query) > 0){
               if(mysqli_num_rows($check_book_query) > 0){
                  while($fetch_update = mysqli_fetch_assoc($check_book_query)){
         ?>
         
         <h1 class='title'>Write A Review</h1>
         <form action="" method="post" enctype="multipart/form-data">
            <input type="hidden" name="update_p_id" value="<?php echo $fetch_update['id']; ?>">
            <div class="form-rating">
               <label for="user_rating">Rate The Book:</label>
               <select name="user_rating" id="user_rating" required>
                  <option value="">Select Rating</option>
                  <option value="1">1</option>
                  <option value="2">2</option>
                  <option value="3">3</option>
                  <option value="4">4</option>
                  <option value="5">5</option>
               </select>
            </div>
            <textarea type="text" name="user_review_details" cols="30" rows="10" class="box" required placeholder="Write Review"></textarea>

            <input type="submit" value="Post Review" name="write_review" class="btn">
         </form>
         <?php
               }
            }
            }else{
               echo '<script>document.querySelector(".edit-product-form").style.display = "none";</script>';
            }
         ?>


        <h1 class='title'>Reviews</h1>

    <?php
        
            $book_detail_id = $_GET['update'];
        $update_query = mysqli_query($conn, "SELECT * FROM `products` INNER JOIN `product_reviews` on products.id = product_reviews.product_id WHERE id = '{$book_detail_id}' ORDER BY product_reviews.review_time DESC") or die('query failed');
            if(mysqli_num_rows($update_query) > 0){
                while($fetch_update = mysqli_fetch_assoc($update_query)){
    ?>
            <form action="" method="post" class="box">
                <input type="hidden" name="update_book_id" value="<?php echo $fetch_update['id']; ?>">
                
                <div class="job_title">Name: <?php echo $fetch_update['reviewer_name']; ?></a></div>
                <p> <span class="details" style="font-size: 19px; color: green;">Time: <span><?php echo $fetch_update['review_time']; ?></span> </p>
                <p> <span class="details" style="font-size: 19px; color: black;">Rating: <span><?php echo $fetch_update['user_rating']; ?></span> </p>

                <p type="text" name="show_book_author_name" class="box" style="font-size: 15px; color: black;"><?php echo $fetch_update['review_details']; ?></p>
                
            </form>
    <?php
            }
        }
        
    ?>
    </div>

</section>






<?php include 'footer.php'; ?>
<script>
  console.log('<?php echo $_SESSION["user_id"]; ?>');
</script>
<!-- custom js file link  -->
<script src="js/script.js"></script>

</body>
</html>