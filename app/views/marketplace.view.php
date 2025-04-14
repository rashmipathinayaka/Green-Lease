<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Green Lease Marketplace</title>
    <link rel="stylesheet" href="<?= URLROOT ?>/assets/css/marketplace.css">
</head>
<body>
    <?php include 'components/navbar.php'; ?>

    <div class="container">
        <!-- Display messages if any -->
        <?php if(isset($_SESSION['message'])): ?>
            <div class="alert alert-<?= $_SESSION['message_type'] ?>">
                <?= $_SESSION['message'] ?>
            </div>
            <?php 
                // Clear the message after displaying
                unset($_SESSION['message']);
                unset($_SESSION['message_type']);
            ?>
        <?php endif; ?>

        <section class="filter-section">
            <form method="GET" action="<?= URLROOT ?>/marketplace" class="filter-form">
                <div class="filter-grid">
                    <input type="text" name="location" placeholder="Search by location" 
                           class="filter-input" value="<?= isset($_GET['location']) ? htmlspecialchars($_GET['location']) : '' ?>">
                    
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
                            <h2 class="listing-title"><?= htmlspecialchars($harvest->crop_type) ?> Harvest</h2>
                            <div class="listing-details">
                                <p>Location: <?= htmlspecialchars($harvest->address) ?> (Zone <?= htmlspecialchars($harvest->zone) ?>)</p>
                                <p>Land Size: <?= htmlspecialchars($harvest->size) ?> Acres</p>
                                <p>Harvest Date: <?= htmlspecialchars($harvest->harvest_date) ?></p>
                                <p>Remaining: <?= htmlspecialchars($harvest->rem_amount) ?> Tons</p>
                            </div>
                            <div class="current-bid">Minimum Bid (1kg): LKR <?= htmlspecialchars($harvest->min_bid) ?></div>
                            
                            <!-- PHP Form for bidding -->
                            <form method="POST" action="<?= URLROOT ?>/marketplace/placeBid" class="bid-form">
                                <input type="hidden" name="harvest_id" value="<?= $harvest->id ?>">
                                
                                <label for="amount_<?= $harvest->id ?>">Amount (kg)</label>
                                <input type="number" id="amount_<?= $harvest->id ?>" name="amount" 
                                       class="bid-input" required min="1" 
                                       max="<?= $harvest->rem_amount * 1000 ?>">
                                
                                <label for="unit_price_<?= $harvest->id ?>">Unit Price (LKR per kg)</label>
                                <input type="number" id="unit_price_<?= $harvest->id ?>" name="unit_price" 
                                       class="bid-input" required min="<?= $harvest->min_bid ?>">
                                
                                <button type="submit" class="bid-button">Place Bid</button>
                            </form>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>

    <?php include 'components/footer.php'; ?>
</body>
</html>