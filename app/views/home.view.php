<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Green Lease</title>
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" />
  <link rel="stylesheet" href="<?= URLROOT ?>/assets/css/styles.css" />
</head>

<body>
  <?php include 'components/navbar.php'; ?>

  <section class="hero">
    <div class="hero-content">
      <h1>Welcome to Green Lease</h1>
      <p>Empowering Green Agriculture Through Innovation</p>
    </div>
  </section>

  <section class="completed-projects">
    <h2>Completed Projects</h2>
    <div class="projects-grid">
      <a href="<?= URLROOT ?>/land" style="text-decoration:none;">
        <div class="project-card">
          <img src="<?= URLROOT ?>/assets/Images/hero.jpg" alt="Project Image" />
          <p>King Street - Panadura</p>
          <p>Tomato</p>
        </div>
      </a>
      <a href="<?= URLROOT ?>/land" style="text-decoration:none;">
        <div class="project-card">
          <img src="<?= URLROOT ?>/assets/Images/hero.jpg" alt="Project Image" />
          <p>Uyana Road - Moratuwa</p>
          <p>Potato</p>
        </div>
      </a>
      <a href="<?= URLROOT ?>/land" style="text-decoration:none;">
        <div class="project-card">
          <img src="<?= URLROOT ?>/assets/Images/hero.jpg" alt="Project Image" />
          <p>Hill Avenue - New York</p>
          <p>Maize</p>
        </div>
      </a>
      <a href="<?= URLROOT ?>/land" style="text-decoration:none;">
        <div class="project-card">
          <img src="<?= URLROOT ?>/assets/Images/hero.jpg" alt="Project Image" />
          <p>Reid Avenue - Colombo</p>
          <p>Rice</p>
        </div>
      </a>
      <a href="<?= URLROOT ?>/land" style="text-decoration:none;">
        <div class="project-card">
          <img src="<?= URLROOT ?>/assets/Images/hero.jpg" alt="Project Image" />
          <p>Mendis Lane - Moratuwa</p>
          <p>Sugarcane</p>
        </div>
      </a>
      <a href="<?= URLROOT ?>/land" style="text-decoration:none;">
        <div class="project-card">
          <img src="<?= URLROOT ?>/assets/Images/hero.jpg" alt="Project Image" />
          <p>Hill Street - Dehiwala</p>
          <p>Tomato</p>
        </div>
      </a>
    </div>
    <div class="show-more">
      <a href="projects.php" class="green-btn">Show More</a>
    </div>
  </section>

  <section class="stats-section">
    <div class="stats-content">
      <div class="stats-text">
        <h2>Promoting Sustainable Land Use</h2>
        <p>Together, we turn idle lands into productive spaces while contributing to a greener planet.</p>
      </div>

      <div class="stats-grid">
        <div class="stat-item">
          <div class="stat-icon">🌱</div>
          <div class="stat-number" data-target="100">0</div>
          <div class="stat-label">Projects</div>
        </div>

        <div class="stat-item">
          <div class="stat-icon">👥</div>
          <div class="stat-number" data-target="200">0</div>
          <div class="stat-label">Clients</div>
        </div>

        <div class="stat-item">
          <div class="stat-icon">🌾</div>
          <div class="stat-number" data-target="50">0</div>
          <div class="stat-label">Crops Grown</div>
        </div>

        <div class="stat-item">
          <div class="stat-icon">💰</div>
          <div class="stat-number" data-target="300">0</div>
          <div class="stat-label">Buyers</div>
        </div>
      </div>
    </div>
  </section>

  <br /><br /><br />

  <script>
    const observerOptions = {
      URLROOT: null,
      URLROOTMargin: '0px',
      threshold: 0.2
    };

    const observer = new IntersectionObserver((entries) => {
      entries.forEach(entry => {
        if (entry.isIntersecting) {
          const statItems = entry.target.querySelectorAll('.stat-item');
          animateStats(statItems);
          observer.unobserve(entry.target);
        }
      });
    }, observerOptions);

    const statsSection = document.querySelector('.stats-section');
    observer.observe(statsSection);

    function animateStats(statItems) {
      statItems.forEach((item, index) => {
        setTimeout(() => {
          item.classList.add('animate');
          const numberElement = item.querySelector('.stat-number');
          const targetValue = parseInt(numberElement.getAttribute('data-target'));
          animateNumber(numberElement, targetValue);
        }, index * 200);
      });
    }

    function animateNumber(element, target) {
      let current = 0;
      const increment = target / 50;
      const duration = 1500;
      const stepTime = duration / 50;

      const updateNumber = () => {
        current += increment;
        if (current > target) {
          current = target;
        }
        element.textContent = Math.floor(current) + '+';

        if (current < target) {
          setTimeout(updateNumber, stepTime);
        }
      };

      updateNumber();
    }
  </script>
  <?php include 'components/footer.php'; ?>
</body>

</html>