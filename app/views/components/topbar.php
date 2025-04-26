<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link rel="stylesheet" href="<?= URLROOT ?>/assets/css/components/topbar.css">

  <title>Document</title>
</head>

<body>

  <div class="top-bar">
    <div class="logo-section">
      <img src="http://localhost/Green-lease/public/assets/images/logo.png" width="100px">
    </div>

    <div class="user-actions">
      <?php if (isset($_SESSION['role_id'])):?>
      <div class="notification-bell" style="position:relative;">
          <i class="fa fa-bell"></i>
          <?php if (!isset($notifications) || !is_array($notifications)) { $notifications = []; } ?>
          <?php if (count($notifications) > 0): ?>
              <span class="badge" id="notif-badge" style="position:absolute;top:-5px;right:-5px;background:red;color:white;border-radius:50%;padding:2px 6px;font-size:12px;"><?= count($notifications) ?></span>
          <?php endif; ?>
          <div class="notification-dropdown" style="display:none;position:absolute;right:0;top:30px;background:white;box-shadow:0 2px 8px rgba(0,0,0,0.15);min-width:220px;z-index:100;">
              <?php if (count($notifications) == 0): ?>
                  <div style="padding:10px;">No new notifications</div>
              <?php else: ?>
                  <?php foreach ($notifications as $notif): ?>
                      <a href="<?= $notif->link ?>" style="display:block;padding:10px 15px;color:#333;text-decoration:none;border-bottom:1px solid #eee;"><?= htmlspecialchars($notif->message) ?></a>
                  <?php endforeach; ?>
              <?php endif; ?>
          </div>
      </div>
      <?php endif; ?>
      <a href="<?php echo URLROOT; ?>/components/profile2/profilenavigation"><button class="profile-btn"><i class="fas fa-user"></i></button></a>
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

<script>
document.querySelector('.notification-bell').addEventListener('click', function(e) {
    var dropdown = this.querySelector('.notification-dropdown');
    dropdown.style.display = dropdown.style.display === 'block' ? 'none' : 'block';
    // Mark notifications as read via AJAX and hide badge
    var badge = document.getElementById('notif-badge');
    if (badge) {
        badge.style.display = 'none';
        // Send AJAX request to mark as read
        var xhr = new XMLHttpRequest();
        xhr.open('POST', '<?= URLROOT ?>/notifications/markAllRead', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.send();
    }
    e.stopPropagation();
});
document.addEventListener('click', function() {
    var dropdown = document.querySelector('.notification-dropdown');
    if(dropdown) dropdown.style.display = 'none';
});
</script>