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
      <img src="<?= URLROOT ?>/assets/images/logo.png" width="100px">
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
      <a href="<?php echo URLROOT; ?>/profile2/profilenavigation"><button class="profile-btn"><i class="fas fa-user"></i></button></a>
    </div>

    <div class="topbar-right">
        <div class="language-switcher">
            <?php $lang = $_SESSION['lang'] ?? 'en'; ?>
            <button type="button" class="language-btn <?php echo $lang === 'en' ? 'active' : ''; ?>" data-lang="en">
                <i class="fas fa-globe"></i> English
            </button>
            <button type="button" class="language-btn <?php echo $lang === 'si' ? 'active' : ''; ?>" data-lang="si">
                <i class="fas fa-globe"></i> සිංහල
            </button>
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

    if (navbar && navbarLinks && !navbar.contains(event.target) && navbarLinks.classList.contains('active')) {
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

<script>
document.querySelectorAll('.language-btn').forEach(button => {
    button.addEventListener('click', function() {
        const lang = this.dataset.lang;
        const currentUrl = window.location.href;

        // Add loading state
        this.disabled = true;
        this.style.opacity = '0.7';

        fetch('<?= URLROOT ?>/language/switch', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: `lang=${lang}&redirect_url=${encodeURIComponent(currentUrl)}`
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                window.location.reload();
            }
        })
        .catch(error => {
            console.error('Error parsing JSON:', error);
            this.disabled = false;
            this.style.opacity = '1';
        });
    });
});
</script>

<style>
.language-switcher {
    display: flex;
    gap: 5px;
    margin-right: 20px;
}

.language-switcher button {
    padding: 5px 10px;
    border: 1px solid #ddd;
    background: white;
    cursor: pointer;
    border-radius: 4px;
    font-size: 14px;
}

.language-switcher button.active {
    background: #2e7d32;
    color: white;
    border-color: #2e7d32;
}
</style>