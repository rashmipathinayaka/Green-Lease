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
            <!-- Listing Cards will be generated dynamically -->
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
        const listings = <?php echo json_encode([
            [
                'title' => "Organic Wheat Harvest",
                'location' => "Southwest Region",
                'acreage' => "50 acres",
                'expectedYield' => "200 tons",
                'harvestDate' => "September 2024",
                'minBid' => 45000,
                'id' => 1
            ],
            [
                'title' => "Organic Barley Harvest",
                'location' => "Northwest Region",
                'acreage' => "60 acres",
                'expectedYield' => "300 tons",
                'harvestDate' => "October 2024",
                'minBid' => 50000,
                'id' => 2
            ],
            [
                'title' => "Organic Rice Harvest",
                'location' => "East Region",
                'acreage' => "80 acres",
                'expectedYield' => "400 tons",
                'harvestDate' => "November 2024",
                'minBid' => 60000,
                'id' => 3
            ],
            [
                'title' => "Organic Corn Harvest",
                'location' => "Central Plains",
                'acreage' => "120 acres",
                'expectedYield' => "600 tons",
                'harvestDate' => "December 2024",
                'minBid' => 70000,
                'id' => 4
            ],
            [
                'title' => "Organic Oats Harvest",
                'location' => "Northern Highlands",
                'acreage' => "40 acres",
                'expectedYield' => "150 tons",
                'harvestDate' => "January 2025",
                'minBid' => 35000,
                'id' => 5
            ],
            [
                'title' => "Organic Soybean Harvest",
                'location' => "Midwest Region",
                'acreage' => "75 acres",
                'expectedYield' => "500 tons",
                'harvestDate' => "February 2025",
                'minBid' => 55000,
                'id' => 6
            ],
            [
                'title' => "Organic Sunflower Harvest",
                'location' => "Southeast Region",
                'acreage' => "90 acres",
                'expectedYield' => "400 tons",
                'harvestDate' => "March 2025",
                'minBid' => 65000,
                'id' => 7
            ],
            [
                'title' => "Organic Cotton Harvest",
                'location' => "South Region",
                'acreage' => "100 acres",
                'expectedYield' => "800 tons",
                'harvestDate' => "April 2025",
                'minBid' => 80000,
                'id' => 8
            ],
            [
                'title' => "Organic Sugar Cane Harvest",
                'location' => "West Coast Region",
                'acreage' => "200 acres",
                'expectedYield' => "1500 tons",
                'harvestDate' => "May 2025",
                'minBid' => 100000,
                'id' => 9
            ]
        ]); ?>;



        const marketplaceGrid = document.getElementById("marketplaceGrid");
        // const loginRequiredModal = document.getElementById("loginRequiredModal");

        function renderListings(filteredListings) {
            marketplaceGrid.innerHTML = "";
            filteredListings.forEach(listing => {
                const card = document.createElement("div");
                card.classList.add("listing-card");
                card.innerHTML = `
                    <div class="listing-image"></div>
                    <div class="listing-content">
                        <h2 class="listing-title">${listing.title}</h2>
                        <div class="listing-details">
                            <p><strong>Location:</strong> ${listing.location}</p>
                            <p><strong>Acreage:</strong> ${listing.acreage}</p>
                            <p><strong>Expected Yield:</strong> ${listing.expectedYield}</p>
                            <p><strong>Harvest Date:</strong> ${listing.harvestDate}</p>
                        </div>
                        <div class="current-bid">Minimum Bid: $${listing.minBid}</div>
                        <form class="bid-form" onsubmit="handleBid(event, ${listing.minBid})">
                            <input type="number" placeholder="Enter your bid" class="bid-input" min="${listing.minBid}" step="1000">
                            <button type="submit" class="bid-button">Place Bid</button>
                        </form>
                    </div>
                `;
                marketplaceGrid.appendChild(card);
            });
        }

        function handleBid(event, minBid) {
            event.preventDefault();
            
            // if (!isLoggedIn) {
            //     loginRequiredModal.style.display = "flex";
            //     return;
            // }

            const bidInput = event.target.querySelector('.bid-input');
            const bidValue = parseInt(bidInput.value, 10);

            if (!bidValue || bidValue < minBid) {
                alert(`Your bid must be at least $${minBid}`);
                return;
            }

            confirmationModal.style.display = "flex";
        }

        function closeLoginModal() {
            loginRequiredModal.style.display = "none";
        }

        // Filter and sort functionality remains the same
        function filterAndSortListings() {
            let filteredListings = listings;

            const locationFilter = document.getElementById("locationFilter").value.toLowerCase();
            if (locationFilter) {
                filteredListings = filteredListings.filter(listing => 
                    listing.location.toLowerCase().includes(locationFilter)
                );
            }

            const harvestTypeFilter = document.getElementById("harvestTypeFilter").value.toLowerCase();
            if (harvestTypeFilter) {
                filteredListings = filteredListings.filter(listing => 
                    listing.title.toLowerCase().includes(harvestTypeFilter)
                );
            }

            const sortBy = document.getElementById("sortBy").value;
            if (sortBy === "price-asc") {
                filteredListings.sort((a, b) => a.minBid - b.minBid);
            } else if (sortBy === "price-desc") {
                filteredListings.sort((a, b) => b.minBid - a.minBid);
            } else if (sortBy === "date") {
                filteredListings.sort((a, b) => new Date(a.harvestDate) - new Date(b.harvestDate));
            }

            renderListings(filteredListings);
        }

        // Event listeners
        document.getElementById("locationFilter").addEventListener("input", filterAndSortListings);
        document.getElementById("harvestTypeFilter").addEventListener("input", filterAndSortListings);
        document.getElementById("sortBy").addEventListener("change", filterAndSortListings);

        // Modal event listeners
        const confirmationModal = document.getElementById("confirmationModal");
        const successModal = document.getElementById("successModal");
        const confirmBidButton = document.getElementById("confirmBid");
        const cancelBidButton = document.getElementById("cancelBid");
        const closeSuccessModalButton = document.getElementById("closeSuccessModal");

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
            if (event.target === confirmationModal) {
                confirmationModal.style.display = "none";
            }
            if (event.target === successModal) {
                successModal.style.display = "none";
            }
            if (event.target === loginRequiredModal) {
                loginRequiredModal.style.display = "none";
            }
        };

        // Initial render
        renderListings(listings);

        function toggleMenu() {
            const navbarLinks = document.querySelector(".navbar-links");
            navbarLinks.classList.toggle("active");
        }
    </script>
    <?php include 'components/footer.php'; ?>
</body>
</html>