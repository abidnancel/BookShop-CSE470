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

$_SESSION['book_search'] = 0;
if(isset($_POST['submit_book_search'])){
   $_SESSION['book_search'] = mysqli_real_escape_string($conn, $_POST['search_book']);

}

$_SESSION['book_category'] = 0;
if(isset($_POST['book_category_button'])){
   $_SESSION['book_category'] = mysqli_real_escape_string($conn, $_POST['category_buttons']);

}

$_SESSION['book_sort'] = 0;
if(isset($_POST['book_sort_button'])){
   $_SESSION['book_sort'] = mysqli_real_escape_string($conn, $_POST['book_sort']);

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>shop</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/admin_style.css">
   <link rel="stylesheet" href="css/style.css">

</head>
<body>
   
<?php include 'header.php'; ?>

<div class="heading">
   <h3>Our Books</h3>
   <p> <a href="home.php">Home</a> / All Books </p>
</div>

<section class="products">

   <h1 class="title">Latest Books</h1>

   <!-- This is for search, category, dropdown dropdown menu STARTS -->

   <section class="search-form">
         <form action="" method="post">
            <input type="text" name="search_book" placeholder="Search Any Blog" class="box">
            <input type="submit" name="submit_book_search" value="search" class="btn">
         </form>
   </section>

   <section class="search-form">
   <form action="" method="post">
         <select name="category_buttons" class="box"> 
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
         <input type="submit" value="Category By" name="book_category_button" class="btn">
         <!-- This is for sort dropdown menu -->
         <select name="book_sort" class="box"> 
            <option value="price">Low To High</option>
            <option value="name">Name Asc</option>
         </select>
         <input type="submit" value="Sort By" name="book_sort_button" class="btn">
      </form>
   </section>

<!-- This is for search, category, dropdown dropdown menu ENDS -->


<div class="box-container">

      <?php
         $book_category = $_SESSION['book_category'];
         $book_search = $_SESSION['book_search'];
         $book_sort = $_SESSION['book_sort'];


         if((!isset($_POST['book_category_button'])) and (!isset($_POST['submit_book_search'])) and (!isset($_POST['book_sort_button']))){ // If the category button was not pressed
            $select_book = mysqli_query($conn, "SELECT * FROM `products`") or die('query failed');
            
         }
         else if((isset($_POST['book_category_button'])) and (!isset($_POST['book_sort_button']))){ // If the category button was pressed
            
            
            $select_book = mysqli_query($conn, "SELECT * FROM `products` INNER JOIN `current_product_details` on products.id = current_product_details.product_id WHERE book_genre='$book_category'") or die('query failed');
            
         }
         else if((isset($_POST['submit_book_search'])) and (!isset($_POST['book_sort_button']))){
            $select_book = mysqli_query($conn, "SELECT * FROM `products` where name like '%{$book_search}%'") or die('query failed');

         }
         else if(isset($_POST['book_sort_button'])){
            if($book_sort == 'price'){
               $select_book = mysqli_query($conn, "SELECT * FROM `products` INNER JOIN `current_product_details` on products.id = current_product_details.product_id ORDER BY price asc") or die('query failed');
            }
            else if($book_sort == 'name'){
               $select_book = mysqli_query($conn, "SELECT * FROM `products` INNER JOIN `current_product_details` on products.id = current_product_details.product_id ORDER BY name asc") or die('query failed');
            }
            
            // echo("<script>console.log('SELECT * FROM admin_news order by {'$blog_sort'} asc')</script>");
         }
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
            <a href="product_details.php?update=<?php echo $fetch_products['id']; ?>" class="btn">Book Details</a>
         </form>
            <?php
               }
         }else{
            echo '<p class="empty">no products added yet!</p>';
         }
      ?>
   </div>

</section>








<?php include 'footer.php'; ?>

<!-- custom js file link  -->
<script src="js/script.js"></script>

</body>
</html>