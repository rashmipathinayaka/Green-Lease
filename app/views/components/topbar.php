<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

  <link rel="stylesheet" href="<?= URLROOT ?>/assets/css/components/navbar.css">
  <link rel="stylesheet" href="<?php echo URLROOT; ?>/assets/CSS/navbar.css">

  <title>Document</title>
</head>

<body>
  <div class="top-bar">
    <div class="logo-section">
      <img src="http://localhost/green-lease/public/assets/images/logo.png" width="100px">
    </div>

    <div class="user-actions">
      <!-- <button class="notification-btn"><i class="fas fa-bell"></i></button> -->
      <button class="profile-btn"></button>
      <div class="user-info">
        <span class="username">
          <img src="<?= URLROOT ?>/assets/images/user.png" alt="Green Lease Logo" class="menu-icon"><a href="<?php echo URLROOT; ?>/components/profile"> Profile</a> </span>
      </div>
    </div>
  </div>
</body>

</html>


<script>
  function toggleMenu() {
    const navbarLinks = document.querySelector('.navbar-links');
    navbarLinks.classList.toggle('active');
  }

  document.addEventListener('click', function(event) {
    const navbar = document.querySelector('.navbar');
    const navbarLinks = document.querySelector('.navbar-links');
    const hamburger = document.querySelector('.hamburger');

    if (!navbar.contains(event.target) && navbarLinks.classList.contains('active')) {
      navbarLinks.classList.remove('active');
    }
  });
</script>