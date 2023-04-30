<?php

include 'config.php';

session_start();

$user_id = $_SESSION['user_id'];

if(!isset($user_id)){
   header('location:login.php');
}

$_SESSION['blog_search'] = 0;
if(isset($_POST['submit_blog_search'])){
   $_SESSION['blog_search'] = mysqli_real_escape_string($conn, $_POST['search_blog']);

}

$_SESSION['blog_category'] = 0;
if(isset($_POST['blog_category'])){
   $_SESSION['blog_category'] = mysqli_real_escape_string($conn, $_POST['category_buttons']);

}

$_SESSION['blog_sort'] = 0;
if(isset($_POST['blog_sort'])){
   $_SESSION['blog_sort'] = mysqli_real_escape_string($conn, $_POST['sort_buttons']);

}


?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>User Board</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">
   <link rel="stylesheet" href="css/admin_style.css">

</head>
<body>
   
<?php include 'header.php'; ?>

<div class="heading">
   <h3 style="color: white;">our board</h3>
   <p style="color: #ccc;"> <a href="home.php">Home</a> / Board </p>
</div>
<!-- Blog Category Start  -->



<!-- This is for search bar -->
<section class="search-form">
   <form action="" method="post">
      <input type="text" name="search_blog" placeholder="Search Any Posts" class="box">
      <input type="submit" name="submit_blog_search" value="search" class="btn">
   </form>
</section>
<!-- This is for category dropdown menu -->
<section class="search-form">
<form action="" method="post">
      <select name="category_buttons" class="box"> 
         <option value="Announcement">Announcement</option>
         <option value="Author News">Author News</option>
         <option value="Offers">Offers</option>
      </select>

      <input type="submit" value="Category By" name="blog_category" class="btn">
      <!-- This is for sort dropdown menu -->
      <select name="sort_buttons" class="box"> 
         <option value="blog_date">New To Old</option>
         <option value="blog_title">Name Desc</option>
      </select>
      <input type="submit" value="Sort By" name="blog_sort" class="btn">
   </form>
</section>

<!-- Blog Category Ends  -->
<section class="show-blogs">

   <div class="box-container">

      <?php

         $blog_category = $_SESSION['blog_category'];
         $blog_search = $_SESSION['blog_search'];
         $blog_sort = $_SESSION['blog_sort'];


         if((!isset($_POST['blog_category'])) and (!isset($_POST['submit_blog_search'])) and (!isset($_POST['blog_sort']))){ // If the category button was not pressed
            $select_blogs = mysqli_query($conn, "SELECT * FROM `admin_news`") or die('query failed');
            
         }
         else if((isset($_POST['blog_category'])) and (!isset($_POST['blog_sort']))){ // If the category button was pressed
            $select_blogs = mysqli_query($conn, "SELECT * FROM `admin_news` where blog_type='$blog_category'") or die('query failed');
            
            
         }
         else if((isset($_POST['submit_blog_search'])) and (!isset($_POST['blog_sort']))){
            $select_blogs = mysqli_query($conn, "SELECT * FROM `admin_news` where blog_title like '%{$blog_search}%'") or die('query failed');

         }
         else if(isset($_POST['blog_sort'])){
            if($blog_sort == 'blog_title'){
               $select_blogs = mysqli_query($conn, "SELECT * FROM `admin_news` order by blog_title asc") or die('query failed');
            }
            else if($blog_sort == 'blog_date'){
               $select_blogs = mysqli_query($conn, "SELECT * FROM `admin_news` order by blog_date asc") or die('query failed');
            }
            
            // echo("<script>console.log('SELECT * FROM admin_news order by {'$blog_sort'} asc')</script>");
         }
         

         if(mysqli_num_rows($select_blogs) > 0){
               while($fetch_blogs = mysqli_fetch_assoc($select_blogs)){
                  ?>
                  <form action='' method="post" class="box">
                  <div class="blog_id" hidden><?php echo $fetch_blogs['id']; ?></div>
                     <div class="blog_title"><?php echo $fetch_blogs['blog_title']; ?></div>
                     <div class="admin_blog_message" style="max-width: 20ch; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;"><?php echo $fetch_blogs['admin_blog_message']; ?></div>
                     <div class="blog_type">Type: <?php echo $fetch_blogs['blog_type']; ?></div>
                     <div class="blog_date">Posted On: <?php echo $fetch_blogs['blog_date']; ?></div>

                     <a href="user_blogs.php?update=<?php echo $fetch_blogs['id']; ?>" class="btn">Blog Detail</a>
                     
                     
                  </form>
                  <?php
            }
      }
      else{
         echo '<p class="empty">No Blogs Has Been Created Yet.</p>';
      }
      ?>
      <?php // This is to get the clicked value of userId and set it as session variable to transfer it to user_blogs
   ?>
   </div>

</section>

<section class="edit-product-form">

   <?php
      if(isset($_GET['update'])){
         $blog_detail_id = $_GET['update'];
         $update_query = mysqli_query($conn, "SELECT * FROM `admin_news` WHERE id = '$blog_detail_id'") or die('query failed');
         if(mysqli_num_rows($update_query) > 0){
            while($fetch_update = mysqli_fetch_assoc($update_query)){
   ?>
         <form action="" method="post" enctype="multipart/form-data">
            <input type="hidden" name="update_blog_id" value="<?php echo $fetch_update['id']; ?>">

            
            <p type="text" name="show_blog_title" class="box" style="font-size: 35px; color: red;"><?php echo $fetch_update['blog_title']; ?></p>
            <p type="text" name="show_blog_title" class="box" style="font-size: 20px">Published: <?php echo $fetch_update['blog_date']; ?></p>
            <textarea type="text" name="update_admin_blog_message" cols="30" rows="10" class="box" disabled><?php echo $fetch_update['admin_blog_message']; ?></textarea>

            <!-- <input type="text" name="update_blog_type" value="<?php echo $fetch_update['blog_type']; ?>" class="box" required placeholder="Enter New Blog Title"> -->

            <input type="reset" value="cancel" id="close-update" class="option-btn" onclick="window.location = 'user_blogs.php'">
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