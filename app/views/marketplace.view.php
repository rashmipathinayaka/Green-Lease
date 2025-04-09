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
        <section class="filter-section">
            <div class="filter-grid">
                <input type="text" id="locationFilter" placeholder="Search by location" class="filter-input">
                <input type="text" id="harvestTypeFilter" placeholder="Harvest type" class="filter-input">
                <select id="sortBy" class="filter-input">
                    <option value="">Sort by</option>
                    <option value="price-asc">Price: Low to High</option>
                    <option value="price-desc">Price: High to Low</option>
                    <option value="date">Harvest Date</option>
                </select>
            </div>
        </section>

        <div class="marketplace-grid" id="marketplaceGrid">
            <!-- JavaScript will populate cards here -->
        </div>
    </div>

    <!-- Login Required Modal -->
    <div id="loginRequiredModal" class="modal">
        <div class="modal-content">
            <p>Please log in to place a bid.</p>
            <button onclick="window.location.href='<?= ROOT ?>/login'" class="modal-btn confirm">Go to Login</button>
            <button onclick="closeLoginModal()" class="modal-btn cancel">Cancel</button>
        </div>
    </div>

    <!-- Confirmation Modal -->
    <div id="confirmationModal" class="modal">
        <div class="modal-content">
            <p>Are you sure you want to place this bid?</p>
            <button id="confirmBid" class="modal-btn confirm">Yes, Place Bid</button>
            <button id="cancelBid" class="modal-btn cancel">Cancel</button>
        </div>
    </div>

    <!-- Success Modal -->
    <div id="successModal" class="modal">
        <div class="modal-content">
            <p>Bid placed successfully! Please wait for confirmation.</p>
            <button id="closeSuccessModal" class="modal-btn success-close">OK</button>
        </div>
    </div>

    <script>
        const listings = <?= json_encode($harvests) ?>;
        const marketplaceGrid = document.getElementById("marketplaceGrid");
        const loginRequiredModal = document.getElementById("loginRequiredModal");
        const confirmationModal = document.getElementById("confirmationModal");
        const successModal = document.getElementById("successModal");
        const confirmBidButton = document.getElementById("confirmBid");
        const cancelBidButton = document.getElementById("cancelBid");
        const closeSuccessModalButton = document.getElementById("closeSuccessModal");

        function renderListings(data) {
            marketplaceGrid.innerHTML = "";

            if (!data.length) {
                marketplaceGrid.innerHTML = "<p>No harvests found.</p>";
                return;
            }

            data.forEach(harvest => {
                const card = document.createElement("div");
                card.className = "listing-card";
                card.innerHTML = `
                    <div class="listing-image"></div>
                    <div class="listing-content">
                        <h2 class="listing-title">${harvest.crop_type} Harvest</h2>
                        <div class="listing-details">
                            <p>Location: ${harvest.address} (Zone ${harvest.zone})</p>
                            <p>Land Size: ${harvest.size} Acres</p>
                            <p>Harvest Date: ${harvest.harvest_date}</p>
                            <p>Remaining: ${harvest.rem_amount} Tons</p>
                        </div>
                        <div class="current-bid">Minimum Bid: $${harvest.min_bid}</div>
                        <form class="bid-form">
                            <input type="number" placeholder="Your bid" class="bid-input" min="${harvest.min_bid}" step="1000">
                            <button type="submit" class="bid-button">Place Bid</button>
                        </form>
                    </div>
                `;
                const bidForm = card.querySelector(".bid-form");
                bidForm.addEventListener("submit", (event) => handleBid(event, harvest.max_amount));
                marketplaceGrid.appendChild(card);
            });
        }

        function filterAndSortListings() {
            let filteredListings = [...listings];

            const location = document.getElementById("locationFilter").value.toLowerCase();
            if (location) {
                filteredListings = filteredListings.filter(item =>
                    item.address.toLowerCase().includes(location)
                );
            }

            const type = document.getElementById("harvestTypeFilter").value.toLowerCase();
            if (type) {
                filteredListings = filteredListings.filter(item =>
                    item.crop_type.toLowerCase().includes(type)
                );
            }

            const sort = document.getElementById("sortBy").value;
            if (sort === "price-asc") {
                filteredListings.sort((a, b) => a.max_amount - b.max_amount);
            } else if (sort === "price-desc") {
                filteredListings.sort((a, b) => b.max_amount - a.max_amount);
            } else if (sort === "date") {
                filteredListings.sort((a, b) => new Date(a.harvest_date) - new Date(b.harvest_date));
            }

            renderListings(filteredListings);
        }

        function handleBid(event, minBid) {
            event.preventDefault();
            const input = event.target.querySelector(".bid-input");
            const value = parseInt(input.value, 10);

            if (!value || value < minBid) {
                alert(`Your bid must be at least $${minBid}`);
                return;
            }

            confirmationModal.style.display = "flex";
        }

        function closeLoginModal() {
            loginRequiredModal.style.display = "none";
        }

        // Event Listeners
        document.getElementById("locationFilter").addEventListener("input", filterAndSortListings);
        document.getElementById("harvestTypeFilter").addEventListener("input", filterAndSortListings);
        document.getElementById("sortBy").addEventListener("change", filterAndSortListings);

        confirmBidButton.onclick = () => {
            confirmationModal.style.display = "none";
            successModal.style.display = "flex";
            setTimeout(() => {
                window.location.href = "<?= ROOT ?>/buyer";
            }, 2000);
        };

        cancelBidButton.onclick = () => {
            confirmationModal.style.display = "none";
        };

        closeSuccessModalButton.onclick = () => {
            successModal.style.display = "none";
        };

        window.onclick = (event) => {
            if (event.target === confirmationModal) confirmationModal.style.display = "none";
            if (event.target === successModal) successModal.style.display = "none";
            if (event.target === loginRequiredModal) loginRequiredModal.style.display = "none";
        };

        // Initial Load
        renderListings(listings);
    </script>

    <?php include 'components/footer.php'; ?>
</body>
</html>
