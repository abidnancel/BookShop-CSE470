<?php
if(isset($message)){
   foreach($message as $message){
      echo '
      <div class="message">
         <span>'.$message.'</span>
         <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
      </div>
      ';
   }
}
?>

<header class="header">

   <section class="flex">

      <a href="user_dashboard.php" class="logo"><?php echo $_SESSION['user_name']; ?></a>

      <div class="profile">
         
      </div>

   </section>

</header>



<!-- header section ends -->

<!-- side bar section starts  -->

<div class="side-bar">

   <div class="close-side-bar">
      <i class="fas fa-times"></i>
   </div>

   <nav class="navbar">
      <a href="user_dashboard.php"><i class="fas fa-home"></i><span>Dashboard</span></a>
      <a href="user_order.php"><i class="fa-solid fa-users"></i><span>Ordered</span></a>
      <a href="user_message.php"><i class="fa-solid fa-message"></i><span>User Messages</span></a>
      <a href="user_profile.php"><i class="fa-solid fa-square-poll-horizontal"></i><span>User Profile</span></a>
      <a href="Home.php"><i class="fa-solid fa-arrow-left"></i><span>Back To Home</span></a>
      <a href="logout.php"><i class="fa fa-sign-out"></i><span>Log Out</span></a>

   </nav>

</div>

<!-- side bar section ends -->