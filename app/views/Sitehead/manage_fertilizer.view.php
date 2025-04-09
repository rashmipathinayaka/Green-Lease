<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/assets/css/sitehead.css">
    <title>Document</title>
</head>
<body>
<?php
require ROOT . '/views/sitehead/sidebar.php';
require ROOT . '/views/components/navbar.php';
?>
<div id="request-fertilizers-section" class="section">
					<div class="complaint-section">
						<div class="form-container">
							<h1 class="complaint-topic">Request for Fertilizers</h1>
							<form class="form">
								<div class="form-group">
									<label for="name">Land ID</label>
									<input type="text" id="name" name="name" required>
									<label for="complaint-type">Fertilizer Type</label>
									<select id="complaint-type" name="complaint-type" required>
                                        <option value="">Select Fertilizer Type</option>
                                        <option value="urea">Urea</option>
                                        <option value="dap">DAP</option>
                                        <option value="npk">NPK</option>
                                        <option value="potash">Potash</option>
                                        <option value="other">Other</option>
									</select>
									<label for="description">Special Requirements/Notes</label>
									<textarea id="description" name="description" 
										placeholder="Special Requirements (If any)"></textarea>
                                    <label>Preferred Delivery Date</label>
                                    <input type="date" required>
									<button class="form-submit-btn" type="submit">
									<i class="fas fa-paper-plane"></i>&nbsp; Submit Request
									</button>
								</div>
							</form>
						</div>
					</div>
				</div>
</body>
</html>