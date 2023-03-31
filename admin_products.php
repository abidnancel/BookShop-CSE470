<?php

include 'config.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
   header('location:login.php');
};

if(isset($_POST['add_product_button'])){
   // This is only for the "product" table
   $name = mysqli_real_escape_string($conn, $_POST['name']);
   $price = $_POST['price'];
   $image = $_FILES['image']['name'];
   $image_size = $_FILES['image']['size'];
   $image_tmp_name = $_FILES['image']['tmp_name'];
   $image_folder = 'uploaded_img/'.$image;

   date_default_timezone_set('Asia/Dhaka');
   $book_creation_date = date('d/m/Y h:i:s a', time());

   // This is for the "current_product_details" table
   $author_name = mysqli_real_escape_string($conn, $_POST['author_name']);
   $book_description = mysqli_real_escape_string($conn, $_POST['book_description']);
   $book_language = mysqli_real_escape_string($conn, $_POST['book_language']);
   $book_pages = mysqli_real_escape_string($conn, $_POST['book_pages']);
   $book_publication_date = mysqli_real_escape_string($conn, $_POST['book_publication_date']);
   $book_genre = mysqli_real_escape_string($conn, $_POST['book_genre']);



   // This is to check if the book name already exists into the database
   $select_product_name = mysqli_query($conn, "SELECT name FROM `products` WHERE name = '$name'") or die('query failed');

   if(mysqli_num_rows($select_product_name) > 0){
      $message[] = 'Book Already Exists';
   }else{
      $add_product_query = mysqli_query($conn, "INSERT INTO `products`(name, price, image) VALUES('$name', '$price','$image')") or die('query failed');
      
      $product_query_id = mysqli_query($conn, "SELECT id FROM `products` WHERE name='$name'") or die('query failed');
      $fetch_id = mysqli_fetch_assoc($product_query_id);
      $final_id = $fetch_id['id'];
      $add_current_product_details_query = mysqli_query($conn, "INSERT INTO `current_product_details`(product_id,author_name,description, book_language, page_numbers, publication_date, book_genre) VALUES('$final_id','$author_name','$book_description', '$book_language', '$book_pages','$book_publication_date', '$book_genre')") or die('query failed');

      if($add_product_query){
         if($image_size > 2000000){
            $message[] = 'Image Size Is Too Big';
         }else{
            move_uploaded_file($image_tmp_name, $image_folder);
            $message[] = 'Book Has Been Added';
         }
      }else{
         $message[] = 'Could Not Add The Book';
      }
   }
}

if(isset($_GET['delete'])){
   $delete_id = $_GET['delete'];
   $delete_image_query = mysqli_query($conn, "SELECT image FROM `products` WHERE id = '$delete_id'") or die('query failed');
   $fetch_delete_image = mysqli_fetch_assoc($delete_image_query);
   unlink('uploaded_img/'.$fetch_delete_image['image']);
   mysqli_query($conn, "DELETE FROM `products` WHERE id = '$delete_id'") or die('query failed');
   header('location:admin_products.php');
}

if(isset($_POST['update_product'])){

   $update_p_id = $_POST['update_p_id'];
   $update_name = mysqli_real_escape_string($conn, $_POST['update_name']);
   $update_price = $_POST['update_price'];

   // This is the product_details table
   $update_author_name = $_POST['update_author_name']; 
   $update_book_description = mysqli_real_escape_string($conn, $_POST['update_book_description']);
   $update_book_language = $_POST['update_book_language'];
   $update_page_numbers = $_POST['update_page_numbers'];
   $update_publication_date = $_POST['update_publication_date'];
   $update_book_genre = $_POST['update_book_genre'];

   mysqli_query($conn, "UPDATE `products` SET name = '$update_name', price = '$update_price' WHERE id = '$update_p_id'") or die('query failed');

   mysqli_query($conn, "UPDATE `current_product_details` SET author_name = '$update_author_name', description = '$update_book_description', book_language = '$update_book_language', page_numbers = '$update_page_numbers', publication_date = '$update_publication_date', book_genre = '$update_book_genre' WHERE product_id = '$update_p_id'") or die('query failed');

   $update_image = $_FILES['update_image']['name'];
   $update_image_tmp_name = $_FILES['update_image']['tmp_name'];
   $update_image_size = $_FILES['update_image']['size'];
   $update_folder = 'uploaded_img/'.$update_image;
   $update_old_image = $_POST['update_old_image'];

   if(!empty($update_image)){
      if($update_image_size > 2000000){
         $message[] = 'image file size is too large';
      }else{
         mysqli_query($conn, "UPDATE `products` SET image = '$update_image' WHERE id = '$update_p_id'") or die('query failed');
         move_uploaded_file($update_image_tmp_name, $update_folder);
         unlink('uploaded_img/'.$update_old_image);


      }
   }

   header('location:admin_products.php');

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
   <title>products</title>

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

   <h1 class="title">All Books</h1>

   <form action="" method="post" enctype="multipart/form-data">
      <h3>Add A Book</h3>
      <!-- Start of the products -->
      <input type="text" name="name" class="box" placeholder="Enter Book Name" required>
      <input type="number" min="0" name="price" class="box" placeholder="Enter Book Price" required>
      <input type="file" name="image" accept="image/jpg, image/jpeg, image/png" class="box" required>
      <!-- Start of the current_product_details -->
      <input type="text" name="author_name" class="box" placeholder="Enter Author Name" required>
      <textarea type="text" name="book_description" class="box" placeholder="Enter Book Description" cols="30" rows="10" required></textarea>
      <select name="book_language" class="box" required> 
         <option value="English">English</option>
         <option value="Japanese">Japanese</option>
         <option value="French">French</option>
         <option value="Chinese">Chinese</option>
      </select>
      <input type="number" min="1" name="book_pages" class="box" placeholder="Total Pages" required>
      <input type="date" name="book_publication_date" class="box" placeholder="Publication Date" required>
      <select name="book_genre" class="box" required> 
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


      <input type="submit" value="add product" name="add_product_button" class="btn">
   </form>

</section>

<!-- product CRUD section ends -->

<!-- Blog Category Start  -->



<!-- This is for search bar -->
<section class="search-form">
   <form action="" method="post">
      <input type="text" name="search_book" placeholder="Search Any Blog" class="box">
      <input type="submit" name="submit_book_search" value="search" class="btn">
   </form>
</section>

<!-- This is for search, category, dropdown dropdown menu STARTS -->
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


<!-- show products  -->

<section class="show-products">

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
      <div class="box">
         <img src="uploaded_img/<?php echo $fetch_products['image']; ?>" alt="">
         <div class="name"><?php echo $fetch_products['name']; ?></div>
         <div class="price"><?php echo $fetch_products['price']; ?> Taka</div>
         <a href="admin_products.php?update=<?php echo $fetch_products['id']; ?>" class="option-btn">update</a>
         <a href="admin_products.php?delete=<?php echo $fetch_products['id']; ?>" class="delete-btn" onclick="return confirm('delete this product?');">delete</a>
      </div>
      <?php
         }
      }else{
         echo '<p class="empty">no products added yet!</p>';
      }
      ?>
   </div>

</section>

<section class="edit-product-form">

   <?php
      if(isset($_GET['update'])){
         $update_id = $_GET['update'];
         // select * from products INNER JOIN current_product_details on products.id = current_product_details.product_id
         $update_query = mysqli_query($conn, "SELECT * FROM `products` INNER JOIN `current_product_details` on products.id = current_product_details.product_id where id = '$update_id'") or die('query failed');
         // $update_query = mysqli_query($conn, "SELECT * FROM `products` WHERE id = '$update_id'") or die('query failed');
         if(mysqli_num_rows($update_query) > 0){
            while($fetch_update = mysqli_fetch_assoc($update_query)){
   ?>
   <form action="" method="post" enctype="multipart/form-data">
      <input type="hidden" name="update_p_id" value="<?php echo $fetch_update['id']; ?>">
      <input type="hidden" name="update_old_image" value="<?php echo $fetch_update['image']; ?>">
      <!-- <img src="uploaded_img/<?php echo $fetch_update['image']; ?>" alt=""> -->
      <input type="text" name="update_name" value="<?php echo $fetch_update['name']; ?>" class="box" required placeholder="Enter New Name">
      <input type="number" name="update_price" value="<?php echo $fetch_update['price']; ?>" min="0" class="box" required placeholder="Enter New Price">
      <input type="file" class="box" name="update_image" accept="image/jpg, image/jpeg, image/png">
      
      <input type="text" name="update_author_name" value="<?php echo $fetch_update['author_name']; ?>" class="box" required placeholder="Enter New Author Name">
      <textarea type="text" name="update_book_description" cols="30" rows="10" class="box" required placeholder="Enter Blog New Description"><?php echo $fetch_update['description']; ?></textarea>
      <input type="text" name="update_book_language" value="<?php echo $fetch_update['book_language']; ?>" class="box" required placeholder="Enter New Language">
      <input type="number" name="update_page_numbers" value="<?php echo $fetch_update['page_numbers']; ?>" min="0" class="box" required placeholder="Enter New Page Number">
      <input type="date" name="update_publication_date" value="<?php echo $fetch_update['publication_date']; ?>" class="box" required placeholder="Enter New Publication Date">
      
      <select name="update_book_genre" class="box" required>
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

      <input type="submit" value="update" name="update_product" class="btn">
      <input type="reset" value="cancel" id="close-update" class="option-btn">
   </form>
   <?php
         }
      }
      }else{
         echo '<script>document.querySelector(".edit-product-form").style.display = "none";</script>';
      }
   ?>

</section>







<!-- custom admin js file link  -->
<script src="js/admin_script.js"></script>

</body>
</html>