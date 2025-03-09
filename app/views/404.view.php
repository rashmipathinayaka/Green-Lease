<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>404 - Page Not Found</title>
  <link rel="stylesheet" href="<?= URLROOT ?>/assets/css/error.css">
</head>

<body>

  <div class="error-container">
    <div class="error-icon">🔍</div>
    <h1>404</h1>
    <p>Oops! We couldn't find the page you're looking for.</p>
    <p>It might have been moved, deleted, or abducted by aliens. 👽</p>
    <br>
    <div class="action-buttons">
      <a href="<?= URLROOT ?>" class="btn" style="background: linear-gradient(135deg, #43a047 0%, #2e7d32 100%);
  box-shadow: 0 2px 6px rgba(46, 125, 50, 0.3);">Take Me Home</a>
      <a href="javascript:history.back()" class="btn btn-alt" style="background: linear-gradient(135deg, #e53935 0%, #c62828 100%);
  box-shadow: 0 2px 6px rgba(198, 40, 40, 0.3);">Go Back</a>
    </div>
    <div class="error-footer">
      <p>If you need assistance, <a href="/contact">Contact Us</a>!</p>
    </div>
  </div>

</body>

</html>