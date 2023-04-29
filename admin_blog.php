<?php

include 'config.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
   header('location:login.php');
};

if(isset($_POST['add_blog'])){ //This will be called when the user presses post blog

   $user_id = $admin_id;
   $admin_name = 'Admin';

   $blog_title = mysqli_real_escape_string($conn, $_POST['blog_title']);
   $blog_details = mysqli_real_escape_string($conn, $_POST['blog_details']);
   $blog_type = mysqli_real_escape_string($conn, $_POST['blog_type']);
    // This will include the current time the blog has been posted
   date_default_timezone_set('Asia/Dhaka');
   $blog_date = date('d/m/Y h:i:s a', time());

    $add_blog_query = mysqli_query($conn, "INSERT INTO `admin_news`(user_id, admin_name, blog_title, admin_blog_message, blog_type, blog_date) VALUES('$user_id', '$admin_name', '$blog_title', '$blog_details', '$blog_type', '$blog_date')") or die('query failed');

    if($add_blog_query){
        $message[] = 'Blog Has Been Posted';
    }else{
        $message[] = 'Could Not Post The Blog';
    }
   
}

if(isset($_GET['delete'])){
   $delete_id = $_GET['delete'];
//    $delete_image_query = mysqli_query($conn, "SELECT image FROM `products` WHERE id = '$delete_id'") or die('query failed');
   mysqli_query($conn, "DELETE FROM `admin_news` WHERE id = '$delete_id'") or die('query failed');
   header('location:admin_blog.php');
}

if(isset($_POST['update_blog'])){

   $update_blog_id = $_POST['update_blog_id'];
   $update_blog_title = $_POST['update_blog_title'];
   $update_admin_blog_message = $_POST['update_admin_blog_message'];
   $update_blog_type = $_POST['update_blog_type'];

   mysqli_query($conn, "UPDATE `admin_news` SET blog_title = '$update_blog_title', admin_blog_message = '$update_admin_blog_message', blog_type='$update_blog_type' WHERE id = '$update_blog_id'") or die('query failed');

   header('location:admin_blog.php');

}

$_SESSION['blog_category'] = 0;

if(isset($_POST['blog_category'])){
   $_SESSION['blog_category'] = mysqli_real_escape_string($conn, $_POST['category_buttons']);

}
$_SESSION['blog_search'] = 0;

if(isset($_POST['submit_blog_search'])){
   $_SESSION['blog_search'] = mysqli_real_escape_string($conn, $_POST['search_blog']);

}
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Board</title>

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

   <h1 class="title">Admin Board Control</h1>

   <form action="" method="post" enctype="multipart/form-data">
      <h3>Add a New Post</h3>
      <input type="text" name="blog_title" class="box" placeholder="Enter Title" required>
      <!-- We need to name= to link it with the php above -->
      <textarea type="text" name="blog_details" class="box" placeholder="Write Your Post" style="height:120px; width:459px;" required></textarea>
      <select name="blog_type" class="box"> 
         <option value="Announcement">Announcement</option>
         <option value="Author News">Author News</option>
         <option value="Offers">Offers</option>
      </select>
      
      
      <input type="submit" value="Post" name="add_blog" class="btn">
   </form>

</section>

<!-- product CRUD section ends -->

<!-- Blog Category Start  -->



<!-- <section class="add-products">
   <form action="" method="post" enctype="multipart/form-data">

   </form>

</section> -->

<section class="search-form">
   <form action="" method="post">
      <input type="text" name="search_blog" placeholder="Search Any Posts" class="box">
      <input type="submit" name="submit_blog_search" value="search" class="btn">

      <select name="category_buttons" class="box"> 
         <option value="Announcement">Announcement</option>
         <option value="Author News">Author News</option>
         <option value="Offers">Offers</option>
      </select>
      <input type="submit" value="Select Category" name="blog_category" class="btn">
   </form>
</section>

<!-- Blog Category Start  -->
<!-- show products  -->

<section class="show-blogs">

   <div class="box-container">

      <?php

         $blog_category = $_SESSION['blog_category'];
         $blog_search = $_SESSION['blog_search'];

         if((!isset($_POST['blog_category'])) and (!isset($_POST['submit_blog_search']))){ // If the category button was not pressed
            $select_blogs = mysqli_query($conn, "SELECT * FROM `admin_news`") or die('query failed');
         }
         else if(isset($_POST['blog_category'])){ // If the category button was pressed
            $select_blogs = mysqli_query($conn, "SELECT * FROM `admin_news` where blog_type='$blog_category'") or die('query failed');
            
         }
         else if(isset($_POST['submit_blog_search'])){
            $select_blogs = mysqli_query($conn, "SELECT * FROM `admin_news` where blog_title like '%{$blog_search}%'") or die('query failed');
         }

         if(mysqli_num_rows($select_blogs) > 0){
               while($fetch_blogs = mysqli_fetch_assoc($select_blogs)){
                  ?>
                  <div class="box">
                  <div class="blog_id" hidden><?php echo $fetch_blogs['id']; ?></div>
                     <div class="blog_title"><?php echo $fetch_blogs['blog_title']; ?></div>
                     <div class="admin_blog_message" style="max-width: 20ch; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;"><?php echo $fetch_blogs['admin_blog_message']; ?></div>
                     <div class="blog_type">Type: <?php echo $fetch_blogs['blog_type']; ?></div>
                     <div class="blog_date">Posted On: <?php echo $fetch_blogs['blog_date']; ?></div>
            
                     <a href="admin_blog.php?update=<?php echo $fetch_blogs['id']; ?>" class="option-btn">Edit Blog</a>

                     <a href="admin_blog.php?delete=<?php echo $fetch_blogs['id']; ?>" class="delete-btn" onclick="return confirm('Delete This Blog?');">Delete Blog</a>
                  </div>
                  <?php
            }
      }
      else{
         echo '<p class="empty">No Blogs Has Been Created Yet.</p>';
      }
      ?>
   </div>

</section>

<section class="edit-product-form">

   <?php
      if(isset($_GET['update'])){
         $update_id = $_GET['update'];
         $update_query = mysqli_query($conn, "SELECT * FROM `admin_news` WHERE id = '$update_id'") or die('query failed');
         if(mysqli_num_rows($update_query) > 0){
            while($fetch_update = mysqli_fetch_assoc($update_query)){
   ?>
   <form action="" method="post" enctype="multipart/form-data">
      <input type="hidden" name="update_blog_id" value="<?php echo $fetch_update['id']; ?>">

      
      <input type="text" name="update_blog_title" value="<?php echo $fetch_update['blog_title']; ?>" class="box" required placeholder="Enter New Blog Title">
      <textarea type="text" name="update_admin_blog_message" cols="30" rows="10" class="box" required placeholder="Enter Blog Info"><?php echo $fetch_update['admin_blog_message']; ?></textarea>

      <!-- <input type="text" name="update_blog_type" value="<?php echo $fetch_update['blog_type']; ?>" class="box" required placeholder="Enter New Blog Title"> -->

      <select name="update_blog_type" class="box"> 
         <option value="Announcement" selected disabled><?php echo $fetch_update['blog_type']; ?></option>
         <option value="Announcement">Announcement</option>
         <option value="Author News">Author News</option>
         <option value="Offers">Offers</option>
      </select>

      <input type="submit" value="update" name="update_blog" class="btn">
      <input type="reset" value="cancel" class="option-btn" onclick="window.location = 'admin_blog.php'">
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