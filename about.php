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
   <title>About</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>
   
<?php include 'header.php'; ?>

<div class="heading">
   <h3 style="color: white;">about us</h3>
   <p style="color: #ccc;"> <a href="home.php">Home</a> / About </p>
</div>

<section class="about">

   <div class="flex">

      <div class="image">
         <img src="images/about-img.jpg" alt="">
      </div>

      <div class="content">
         <h3>why choose us?</h3>
         <p>We have A Good Collection Of Books</p>
         <a href="contact.php" class="btn">contact us</a>
      </div>

   </div>

</section>

<section class="reviews">

   <h1 class="title">client's reviews</h1>

   <div class="box-container">

      <div class="box">
         <img src="images/avatar1.png" alt="">
         <p>Teacher 1</p>
         <div class="stars">
            <i class="fas fa-star-half-alt"></i>
            <i class="far fa-star"></i>
            <i class="far fa-star"></i>
            <i class="far fa-star"></i>
            <i class="far fa-star"></i>

         </div>
         <h3>Teacher Name 1</h3>
      </div>

      <div class="box">
         <img src="images/avatar2.jpg" alt="">
         <p>Teacher 2</p>
         <div class="stars">
            <i class="fas fa-star-half-alt"></i>
            <i class="far fa-star"></i>
            <i class="far fa-star"></i>
            <i class="far fa-star"></i>
            <i class="far fa-star"></i>
         </div>
         <h3>Teacher Name 2</h3>
      </div>

   </div>

</section>

<section class="authors">

   <h1 class="title">Contributors</h1>

   <div class="box-container">

      <div class="box">
         <img src="images/avatar 3.jpg" alt="">
         <div class="share">
            <a href="https://www.facebook.com/alsolin.wenvy" class="fab fa-facebook-f"></a>
         </div>
         <h3>Md. Anas Mahmud</h3>
         <h3>md.anas.mahmud@g.bracu.ac.bd</h3>
         <h3>ID: 20101149</h3>
      </div>
      </div>

   </div>

</section>







<?php include 'footer.php'; ?>

<!-- custom js file link  -->
<script src="js/script.js"></script>

</body>
</html>