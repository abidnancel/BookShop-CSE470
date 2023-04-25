<?php

include 'config.php';

session_start();

$user_id = $_SESSION['user_id'];

if(!isset($user_id)){
   header('location:login.php');
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


?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Book Suggestion</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/admin_style.css">
   <link rel="stylesheet" href="css/style.css">

</head>
<body>
   
<?php include 'header.php'; ?>

<div class="heading">
   <h3>Book Suggestion</h3>
   <p> <a href="home.php">Home</a> / Can't Decide? </p>
</div>

<section class="add-products">

   <h1 class="title">We are here to help</h1>

   <form action="" method="post" enctype="multipart/form-data">
      <h3>Write Your Preference</h3>
      <!-- Start of the products -->
      <input type="number" min="0" name="highest_price" class="box" placeholder="Highest Amount You Want To Pay" required>
      <!-- Start of the current_product_details -->
      <select name="suggest_book_language" class="box" required> 
         <option value="English">English</option>
         <option value="Japanese">Japanese</option>
         <option value="French">French</option>
         <option value="Chinese">Chinese</option>
      </select>
      <!-- <input type="number" min="1" name="book_pages" class="box" placeholder="Total Pages" required> -->
      <!-- <input type="date" name="book_publication_date" class="box" placeholder="Publication Date" required> -->
      <select name="suggest_book_genre" class="box" required> 
         <option value="Action">Action</option>
         <option value="Horror">Horror</option>
         <option value="Mystery">Mystery</option>
         <option value="Thriller">Thriller</option>
         <option value="Science Fiction">Science Fiction</option>
         <option value="Fantasy">Fantasy</option>
         <option value="Romance">Romance</option>
         <option value="Light Novel">Light Novel</option>
         <option value="Manga">Manga</option>
         <option value="Short Story">Short Story</option>
         <option value="Historical">Historical</option>
         <option value="Biography">Biography</option>
         <option value="Cook Books">Cook Books</option>
         <option value="Travel Books">Travel Books</option>
         <option value="Religion & Spirituality">Religion & Spirituality</option>
         <option value="Children">Children</option>
      </select>


      <input type="submit" value="Suggest Me!" name="book_suggestion_button" class="btn">
   </form>

</section>

<section class="products">


   <div class="box-container">

      <?php
        
        if(isset($_POST['book_suggestion_button'])){
            $highest_amount = $_POST['highest_price'];
            $suggest_book_language = $_POST['suggest_book_language'];
            $suggest_book_genre = $_POST['suggest_book_genre'];

            // Select * from products inner join current_product_details on products.id = current_product_details.product_id where book_genre='Light Novel' and book_language='English' and price between 0 and 1000 order by rand() limit 1;
            $select_book = mysqli_query($conn, "SELECT * FROM products INNER JOIN current_product_details ON products.id = current_product_details.product_id WHERE book_genre='$suggest_book_genre' and book_language='$suggest_book_language' and price between 0 AND $highest_amount ORDER BY rand() LIMIT 1") or die('query failed');

            if(mysqli_num_rows($select_book) > 0){
            
                while($fetch_products = mysqli_fetch_assoc($select_book)){
                ?>
             <form action="" method="post" class="box">
                <img class="image" src="uploaded_img/<?php echo $fetch_products['image']; ?>" alt="">
                <div class="name"><?php echo $fetch_products['name']; ?></div>
                <div class="price"><?php echo $fetch_products['price']; ?> Tk</div>
                <input type="number" min="1" name="product_quantity" value="1" class="qty">
                <input type="hidden" name="product_name" value="<?php echo $fetch_products['name']; ?>">
                <input type="hidden" name="product_price" value="<?php echo $fetch_products['price']; ?>">
                <input type="hidden" name="product_image" value="<?php echo $fetch_products['image']; ?>">
                <input type="submit" value="add to cart" name="add_to_cart" class="btn">
                <a href="book_suggestion.php?update=<?php echo $fetch_products['id']; ?>" class="btn">Book Details</a>
             </form>
                <?php
                   }
             }else{
                echo '<p class="empty">no products added yet!</p>';
             }

        }
      ?>
   </div>

</section>

<section class="edit-product-form">

   <?php
      if(isset($_GET['update'])){
         $book_detail_id = $_GET['update'];
      $update_query = mysqli_query($conn, "SELECT * FROM `products` INNER JOIN `current_product_details` on products.id = current_product_details.product_id WHERE id = '{$book_detail_id}'") or die('query failed');
         if(mysqli_num_rows($update_query) > 0){
            while($fetch_update = mysqli_fetch_assoc($update_query)){
   ?>
         <form action="" method="post" enctype="multipart/form-data">
            <input type="hidden" name="update_book_id" value="<?php echo $fetch_update['id']; ?>">

            <img src="uploaded_img/<?php echo $fetch_update['image']; ?>" alt="">
            <p type="text" name="show_book_title" class="box" style="font-size: 20px; color: red;"><?php echo $fetch_update['name']; ?></p>
            <p type="text" name="show_book_author_name" class="box" style="font-size: 15px; color: black;">Author: <?php echo $fetch_update['author_name']; ?></p>
            <p type="text" name="show_book_title" class="box" style="font-size: 15px;">Genre: <?php echo $fetch_update['book_genre']; ?></p>
            <textarea type="text" name="show_book_description" cols="30" rows="10" class="box" disabled><?php echo $fetch_update['description']; ?></textarea>
            <p type="text" name="show_book_title" class="box" style="font-size: 15px;">Language: <?php echo $fetch_update['book_language']; ?></p>
            <p type="text" name="show_book_title" class="box" style="font-size: 15px;">Pages: <?php echo $fetch_update['page_numbers']; ?></p>
            <p type="text" name="show_book_title" class="box" style="font-size: 15px;">Publication Date: <?php echo $fetch_update['publication_date']; ?></p>

            <input type="number" min="1" name="product_quantity" value="1" class="qty" hidden>
            <input type="hidden" name="product_name" value="<?php echo $fetch_update['name']; ?>">
            <input type="hidden" name="product_price" value="<?php echo $fetch_update['price']; ?>">
            <input type="hidden" name="product_image" value="<?php echo $fetch_update['image']; ?>">
            <input type="submit" value="add to cart" name="add_to_cart" class="btn">
            <input type="reset" value="cancel" id="close-update" class="option-btn" onclick="window.location = 'book_suggestion.php'">
            
         </form>
   <?php
         }
      }
      }else{
         echo '<script>document.querySelector(".edit-product-form").style.display = "none";</script>';
      }
   ?>

</section>

<?php include 'footer.php'; ?>

<!-- custom js file link  -->
<script src="js/script.js"></script>

</body>
</html>