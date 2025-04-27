<!DOCTYPE html>
<html>

<head>
	<link rel="stylesheet" type="text/css" href="contact.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" />
	<link
		href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,400;0,500;0,600;0,800;1,900&display=swap"
		rel="stylesheet">
	<link href="<?= URLROOT ?>/assets/css/contact.css" rel="stylesheet">
	<link href="<?= URLROOT ?>/assets/css/styles.css" rel="stylesheet">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Contact Us</title>
</head>

<body>
	<?php include 'components/navbar.php'; ?>
	<hr>
	<div class="container">
		<main class="row">
			<section class="col left">
				<div class="contactTitle">
					<h2>Get In Touch</h2>
					<p>Contact us to learn how Green Lease can help you create sustainable agricultural opportunities.
					</p>
				</div>
				<div class="contactInfo">

					<div class="iconGroup">
						<div class="icon">
							<i class="fa-solid fa-phone"></i>
						</div>
						<div class="details">
							<span>Phone</span>
							<span>+94 123 5588</span>
						</div>
					</div>
					<div class="iconGroup">
						<div class="icon">
							<i class="fa-solid fa-envelope"></i>
						</div>
						<div class="details">
							<span>Email</span>
							<span>admin@greenlease.com</span>
						</div>
					</div>

					<div class="iconGroup">
						<div class="icon">
							<i class="fa-solid fa-location-dot"></i>
						</div>
						<div class="details">
							<span>Location</span>
							<span>X Street, Y Road, San Fransisco</span>
						</div>
					</div>

				</div>

				<div class="socialMedia">
					<a href="#"><i class="fa-brands fa-facebook-f"></i></a>
					<a href="#"><i class="fa-brands fa-twitter"></i></a>
					<a href="#"><i class="fa-brands fa-instagram"></i></a>
					<a href="#"><i class="fa-brands fa-linkedin-in"></i></a>
				</div>
			</section>

			<section class="col right">
				<?php if (!empty($errors)): ?>
					<div class="alert alert-danger">
						<ul>
							<?php foreach ($errors as $error): ?>
								<li><?= $error ?></li>
							<?php endforeach; ?>
						</ul>
					</div>
				<?php endif; ?>

				<?php if (isset($_SESSION['success_message'])): ?>
					<div class="alert alert-success">
						<?= $_SESSION['success_message'] ?>
					</div>
					<?php unset($_SESSION['success_message']); ?>
				<?php endif; ?>

				<form class="messageForm" action="<?= URLROOT ?>/Inquiry/addInquiry" method="POST">

					<div class="inputGroup halfWidth">
						<input type="text" name="name" required="required">
						<label>Your Name</label>
					</div>

					<div class="inputGroup halfWidth">
						<input type="email" name="email" required="required">
						<label>Email</label>
					</div>

					<div class="inputGroup fullWidth">
						<input type="text" name="subject" required="required">
						<label>Subject</label>
					</div>

					<div class="inputGroup fullWidth">
						<textarea required="required" name="message"></textarea>
						<label>Say Something</label>
					</div>

					<div class="inputGroup fullWidth">
						<button type="submit">Send Message</button>
					</div>

				</form>
			</section>
		</main>
	</div>

	<?php include 'components/footer.php'; ?>

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

		function toggleMenu() {
			const navbarLinks = document.querySelector(".navbar-links");
			navbarLinks.classList.toggle("active");
		}
	</script>
</body>

</html>