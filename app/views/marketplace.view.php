<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Green Lease Marketplace</title>
    <link rel="stylesheet" href="<?= URLROOT ?>/assets/css/marketplace.css">
    <style>
        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0,0,0,0.5);
        }

        .modal-content {
            background-color: #fefefe;
            margin: 15% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
            max-width: 500px;
            border-radius: 8px;
        }

        .modal-header {
            border-bottom: 1px solid #ddd;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }

        .modal-body {
            margin-bottom: 20px;
        }

        .bid-details {
            margin: 10px 0;
            padding: 10px;
            background-color: #f9f9f9;
            border-radius: 4px;
        }

        .modal-footer {
            border-top: 1px solid #ddd;
            padding-top: 10px;
            text-align: right;
        }

        .modal-footer button {
            margin-left: 10px;
            padding: 8px 16px;
            border-radius: 4px;
            cursor: pointer;
        }

        .confirm-btn {
            background-color: #4CAF50;
            color: white;
            border: none;
        }

        .cancel-btn {
            background-color: #f44336;
            color: white;
            border: none;
        }


        .countdown {
            background-color: #ffd700;
            color: #000;
            padding: 8px 12px;
            border-radius: 4px;
            font-weight: bold;
            display: inline-block;
            margin: 5px 0;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        @keyframes pulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.05); }
            100% { transform: scale(1); }
        }
    </style>
</head>
<body>
    <?php include 'components/navbar.php'; ?>

    <div class="container">
        <?php if(isset($_SESSION['message'])): ?>
            <div class="alert alert-<?= $_SESSION['message_type'] === 'success' ? 'success' : 'error' ?>">
                <?= $_SESSION['message'] ?>
            </div>
            <?php 
                unset($_SESSION['message']);
                unset($_SESSION['message_type']);
            ?>
        <?php endif; ?>

        <section class="filter-section">
            <form method="GET" action="<?= URLROOT ?>/marketplace" class="filter-form">
                <div class="filter-grid">
                    <select name="location" class="filter-input">
                        <option value="">Select District</option>
                        <option value="Ampara" <?= (isset($_GET['location']) && $_GET['location'] == 'Ampara') ? 'selected' : '' ?>>Ampara</option>
                        <option value="Anuradhapura" <?= (isset($_GET['location']) && $_GET['location'] == 'Anuradhapura') ? 'selected' : '' ?>>Anuradhapura</option>
                        <option value="Badulla" <?= (isset($_GET['location']) && $_GET['location'] == 'Badulla') ? 'selected' : '' ?>>Badulla</option>
                        <option value="Batticaloa" <?= (isset($_GET['location']) && $_GET['location'] == 'Batticaloa') ? 'selected' : '' ?>>Batticaloa</option>
                        <option value="Colombo" <?= (isset($_GET['location']) && $_GET['location'] == 'Colombo') ? 'selected' : '' ?>>Colombo</option>
                        <option value="Galle" <?= (isset($_GET['location']) && $_GET['location'] == 'Galle') ? 'selected' : '' ?>>Galle</option>
                        <option value="Gampaha" <?= (isset($_GET['location']) && $_GET['location'] == 'Gampaha') ? 'selected' : '' ?>>Gampaha</option>
                        <option value="Hambantota" <?= (isset($_GET['location']) && $_GET['location'] == 'Hambantota') ? 'selected' : '' ?>>Hambantota</option>
                        <option value="Jaffna" <?= (isset($_GET['location']) && $_GET['location'] == 'Jaffna') ? 'selected' : '' ?>>Jaffna</option>
                        <option value="Kalutara" <?= (isset($_GET['location']) && $_GET['location'] == 'Kalutara') ? 'selected' : '' ?>>Kalutara</option>
                        <option value="Kandy" <?= (isset($_GET['location']) && $_GET['location'] == 'Kandy') ? 'selected' : '' ?>>Kandy</option>
                        <option value="Kegalle" <?= (isset($_GET['location']) && $_GET['location'] == 'Kegalle') ? 'selected' : '' ?>>Kegalle</option>
                        <option value="Kilinochchi" <?= (isset($_GET['location']) && $_GET['location'] == 'Kilinochchi') ? 'selected' : '' ?>>Kilinochchi</option>
                        <option value="Kurunegala" <?= (isset($_GET['location']) && $_GET['location'] == 'Kurunegala') ? 'selected' : '' ?>>Kurunegala</option>
                        <option value="Mannar" <?= (isset($_GET['location']) && $_GET['location'] == 'Mannar') ? 'selected' : '' ?>>Mannar</option>
                        <option value="Matale" <?= (isset($_GET['location']) && $_GET['location'] == 'Matale') ? 'selected' : '' ?>>Matale</option>
                        <option value="Matara" <?= (isset($_GET['location']) && $_GET['location'] == 'Matara') ? 'selected' : '' ?>>Matara</option>
                        <option value="Monaragala" <?= (isset($_GET['location']) && $_GET['location'] == 'Monaragala') ? 'selected' : '' ?>>Monaragala</option>
                        <option value="Mullaitivu" <?= (isset($_GET['location']) && $_GET['location'] == 'Mullaitivu') ? 'selected' : '' ?>>Mullaitivu</option>
                        <option value="Nuwara Eliya" <?= (isset($_GET['location']) && $_GET['location'] == 'Nuwara Eliya') ? 'selected' : '' ?>>Nuwara Eliya</option>
                        <option value="Polonnaruwa" <?= (isset($_GET['location']) && $_GET['location'] == 'Polonnaruwa') ? 'selected' : '' ?>>Polonnaruwa</option>
                        <option value="Puttalam" <?= (isset($_GET['location']) && $_GET['location'] == 'Puttalam') ? 'selected' : '' ?>>Puttalam</option>
                        <option value="Ratnapura" <?= (isset($_GET['location']) && $_GET['location'] == 'Ratnapura') ? 'selected' : '' ?>>Ratnapura</option>
                        <option value="Trincomalee" <?= (isset($_GET['location']) && $_GET['location'] == 'Trincomalee') ? 'selected' : '' ?>>Trincomalee</option>
                        <option value="Vavuniya" <?= (isset($_GET['location']) && $_GET['location'] == 'Vavuniya') ? 'selected' : '' ?>>Vavuniya</option>
                    </select>
                    
                    <input type="text" name="crop_type" placeholder="Harvest type" 
                           class="filter-input" value="<?= isset($_GET['crop_type']) ? htmlspecialchars($_GET['crop_type']) : '' ?>">
                    
                    <select name="sort" class="filter-input">
                        <option value="">Sort by</option>
                        <option value="price-asc" <?= (isset($_GET['sort']) && $_GET['sort'] == 'price-asc') ? 'selected' : '' ?>>
                            Price: Low to High
                        </option>
                        <option value="price-desc" <?= (isset($_GET['sort']) && $_GET['sort'] == 'price-desc') ? 'selected' : '' ?>>
                            Price: High to Low
                        </option>
                        <option value="date" <?= (isset($_GET['sort']) && $_GET['sort'] == 'date') ? 'selected' : '' ?>>
                            Harvest Date
                        </option>
                    </select>
                    
                    <button type="submit" class="filter-button">Apply Filters</button>
                </div>
            </form>
        </section>

        <div class="marketplace-grid">
            <?php if(empty($harvests)): ?>
                <p>No harvests found.</p>
            <?php else: ?>
                <?php foreach($harvests as $harvest): ?>
                    <div class="listing-card">
                        <div class="listing-image"></div>
                        <div class="listing-content">
                            <h2 class="listing-title"><?= htmlspecialchars($harvest->crop_type) ?> Harvest - <?= htmlspecialchars($harvest->address) ?></h2>
                            <div class="listing-details">
                                <p>Harvest Date: <?= htmlspecialchars($harvest->harvest_date) ?></p>
                                <p>Remaining: <?= htmlspecialchars($harvest->rem_amount) ?> Tons</p>
                                <!-- <b><p>Bidding Period: <?= date('Y-m-d', strtotime($harvest->bidding_start)) ?> to <?= date('Y-m-d', strtotime($harvest->bidding_end)) ?></p></b> -->
                                <p class="countdown" data-end="<?= htmlspecialchars($harvest->bidding_end) ?>">Time Remaining: Calculating...</p>
                            </div>
                            <div class="current-bid">Minimum Bid (1kg): LKR <?= htmlspecialchars($harvest->min_bid) ?></div>
                            
                            <form method="POST" action="<?= URLROOT ?>/marketplace/placeBid" class="bid-form" onsubmit="return showConfirmation(this, event)">
                                <input type="hidden" name="harvest_id" value="<?= $harvest->id ?>">
                                <input type="hidden" name="crop_type" value="<?= htmlspecialchars($harvest->crop_type) ?>">
                                
                                <label for="amount_<?= $harvest->id ?>">Amount (kg)</label>
                                <input type="number" id="amount_<?= $harvest->id ?>" name="amount" 
                                       class="bid-input" required min="1" 
                                       max="<?= $harvest->rem_amount * 1000 ?>"
                                       oninput="validateBid(this, <?= $harvest->min_bid ?>)">
                                
                                <label for="unit_price_<?= $harvest->id ?>">Unit Price (LKR per kg)</label>
                                <input type="number" id="unit_price_<?= $harvest->id ?>" name="unit_price" 
                                       class="bid-input" required min="<?= $harvest->min_bid ?>"
                                       oninput="validateBid(this, <?= $harvest->min_bid ?>)">
                                
                                <div id="bid_error_<?= $harvest->id ?>" class="error-message" style="color: red; display: none;"></div>
                                <button type="submit" class="bid-button">Place Bid</button>
                            </form>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>

    <div id="confirmationModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h2>Confirm Your Bid</h2>
            </div>
            <div class="modal-body">
                <p>Please review your bid details:</p>
                <div class="bid-details">
                    <p><strong>Crop Type:</strong> <span id="confirmCropType"></span></p>
                    <p><strong>Amount:</strong> <span id="confirmAmount"></span> kg</p>
                    <p><strong>Unit Price:</strong> LKR <span id="confirmUnitPrice"></span> per kg</p>
                    <p><strong>Total Value:</strong> LKR <span id="confirmTotalValue"></span></p>
                </div>
                <p>Are you sure you want to place this bid?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="cancel-btn" onclick="closeModal()">Cancel</button>
                <button type="button" class="confirm-btn" onclick="submitBid()">Confirm Bid</button>
            </div>
        </div>
    </div>

    <?php include 'components/footer.php'; ?>
    
    <script>
        function updateCountdowns() {
            const countdowns = document.querySelectorAll('.countdown');
            countdowns.forEach(countdown => {
                const endTime = new Date(countdown.dataset.end).getTime();
                const now = new Date().getTime();
                const timeLeft = endTime - now;

                if (timeLeft <= 0) {
                    countdown.parentElement.parentElement.parentElement.style.display = 'none';
                    return;
                }

                const days = Math.floor(timeLeft / (1000 * 60 * 60 * 24));
                const hours = Math.floor((timeLeft % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                const minutes = Math.floor((timeLeft % (1000 * 60 * 60)) / (1000 * 60));
                const seconds = Math.floor((timeLeft % (1000 * 60)) / 1000);

                countdown.textContent = `Time Remaining: ${days}d ${hours}h ${minutes}m ${seconds}s`;
            });
        }

        setInterval(updateCountdowns, 1000);
        updateCountdowns(); 

        function validateBid(input, minBid) {
            const form = input.closest('form');
            const errorDiv = form.querySelector('.error-message');
            const submitBtn = form.querySelector('button[type="submit"]');
            
            const unitPrice = parseInt(form.querySelector('input[name="unit_price"]').value) || 0;
            
            if (unitPrice < minBid) {
                errorDiv.textContent = `Minimum bid price is LKR ${minBid} per kg`;
                errorDiv.style.display = 'block';
                submitBtn.disabled = true;
            } else {
                errorDiv.style.display = 'none';
                submitBtn.disabled = false;
            }
        }

        let currentForm = null;

        function showConfirmation(form, event) {
            event.preventDefault();
            currentForm = form;

            const amount = form.querySelector('input[name="amount"]').value;
            const unitPrice = form.querySelector('input[name="unit_price"]').value;
            const cropType = form.querySelector('input[name="crop_type"]').value;
            const totalValue = amount * unitPrice;

            document.getElementById('confirmCropType').textContent = cropType;
            document.getElementById('confirmAmount').textContent = amount;
            document.getElementById('confirmUnitPrice').textContent = unitPrice;
            document.getElementById('confirmTotalValue').textContent = totalValue.toLocaleString();

            document.getElementById('confirmationModal').style.display = 'block';
            return false;
        }

        function closeModal() {
            document.getElementById('confirmationModal').style.display = 'none';
            currentForm = null;
        }

        function submitBid() {
            if (currentForm) {
                currentForm.submit();
            }
        }

        window.onclick = function(event) {
            const modal = document.getElementById('confirmationModal');
            if (event.target == modal) {
                closeModal();
            }
        }
    </script>
</body>
</html>