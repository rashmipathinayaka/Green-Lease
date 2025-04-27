<nav class="navbar">
  <div class="navbar-logo">
    <a href="<?=URLROOT ?>"><img src="<?=URLROOT ?>/assets/images/logo.png" alt="Green Lease Logo" /></a>
  </div>
  <div class="hamburger" onclick="toggleMenu()">&#9776;</div>
  <ul class="navbar-links">
    <li><a href="<?=URLROOT ?>">Home</a></li>
    <li><a href="<?=URLROOT ?>/about">About</a></li>
    <li><a href="<?=URLROOT ?>/contact">Contact</a></li>

    <?php if (isset($_SESSION['id'])): ?>
      <!-- Marketplace link is visible only when logged in -->
      <li><a href="<?=URLROOT ?>/marketplace">Marketplace</a></li>

      <li>
        <?php
        if ($_SESSION['role_id'] == 1) {
          echo '<a href="' .URLROOT . '/admin/index">Dashboard</a>';
        } elseif ($_SESSION['role_id'] == 2) {
          echo '<a href="' .URLROOT . '/supervisor/index">Dashboard</a>';
        } elseif ($_SESSION['role_id'] == 3) {
          echo '<a href="' .URLROOT . '/sitehead/index">Dashboard</a>';
        } elseif ($_SESSION['role_id'] == 4) {
          echo '<a href="' .URLROOT . '/landowner/index">Dashboard</a>';
        } elseif ($_SESSION['role_id'] == 5) {
          echo '<a href="' .URLROOT . '/buyer/index">Dashboard</a>';
        } elseif ($_SESSION['role_id'] == 6) {
          echo '<a href="' .URLROOT . '/worker/index">Dashboard</a>';
        }
        ?>
      </li>
      <li><a href="<?=URLROOT ?>/logout">Logout</a></li>
    <?php else: ?>
      <!-- Marketplace link is not shown for non-logged-in users -->
      <li><a href="<?=URLROOT ?>/login">Login</a></li>
    <?php endif; ?>
  </ul>
</nav>