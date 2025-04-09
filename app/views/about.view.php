<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Green Lease</title>
  <link rel="stylesheet" href="<?= URLROOT ?>/assets/css/about.css">


</head>

<body>
  <header>

    <?php include 'components/navbar.php'; ?>
    <hr>

    <main>
      <section class="hero">
        <div class="hero-content">
          <h1>Revolutionize Agricultural Land Leasing</h1>
          <p>Green Lease is a platform that connects landowners, agricultural workers, and companies to promote
            sustainable farming practices. Unlock the potential of unused land and create a greener future.</p>
          <a href="<?= URLROOT ?>/signup" class="cta-button">Join Now</a>
        </div>
        <div class="hero-image">
          <img src="<?= URLROOT ?>/assets/images/hero.jpg" alt="Green Lease">
        </div>
      </section>

      <section>
        <h2>About Green Lease</h2>
        <p>Green Lease is a innovative platform that aims to facilitate the use of unused land for agriculture, while
          providing a transparent and efficient marketplace for land leasing. Our mission is to encourage sustainable
          farming practices and foster collaboration between landowners, agricultural workers, and companies.</p>
      </section>

      <section>
        <h2>Key Features</h2>
        <ul class="features-list">
          <li>Secure and transparent land leasing platform</li>
          <li>Incentives for sustainable farming practices</li>
          <li>User-friendly interface for easy navigation</li>
          <li>Real-time monitoring and reporting</li>
          <li>Collaborative tools for farmers and landowners</li>
        </ul>
      </section>
    </main>

    <?php include 'components/footer.php'; ?>
</body>

</html>