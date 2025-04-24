<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/assets/css/buyer.css">
    <title>Purchase History</title>
    <script>
        // Define URLROOT for JavaScript
        const URLROOT = '<?php echo URLROOT; ?>';
    </script>
    <style>
        /* Invoice Modal Styles */
        .invoice-modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0,0,0,0.5);
        }

        .invoice-modal-content {
            background-color: #fefefe;
            margin: 5% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 90%;
            max-width: 600px;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }

        .invoice-header {
            text-align: center;
            margin-bottom: 20px;
            padding-bottom: 20px;
            border-bottom: 2px solid #eee;
        }

        .invoice-header h2 {
            color: #1a472a;
            margin: 0;
        }

        .invoice-details {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            margin-bottom: 20px;
            padding: 15px;
            background-color: #f9f9f9;
            border-radius: 4px;
        }

        .invoice-details div {
            margin-bottom: 10px;
        }

        .invoice-details strong {
            color: #1a472a;
        }

        .invoice-table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }

        .invoice-table th,
        .invoice-table td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        .invoice-table th {
            background-color: #f5f5f5;
            color: #1a472a;
        }

        .invoice-total {
            text-align: right;
            font-size: 1.2em;
            margin-top: 20px;
            padding-top: 20px;
            border-top: 2px solid #eee;
        }

        .invoice-footer {
            text-align: center;
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #eee;
            color: #666;
        }

        .invoice-actions {
            display: flex;
            justify-content: flex-end;
            gap: 10px;
            margin-top: 20px;
        }

        .invoice-actions button {
            padding: 8px 16px;
            border-radius: 4px;
            cursor: pointer;
            border: none;
        }

        .print-btn {
            background-color: #1a472a;
            color: white;
        }

        .close-btn {
            background-color: #6c757d;
            color: white;
        }

        /* Rating Modal Styles */
        .rating-modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0,0,0,0.5);
        }

        .rating-modal-content {
            background-color: #fefefe;
            margin: 15% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 90%;
            max-width: 400px;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }

        .rating-stars {
            display: flex;
            justify-content: center;
            gap: 10px;
            margin: 20px 0;
        }

        .star {
            font-size: 24px;
            cursor: pointer;
            color: #ddd;
        }

        .star.active {
            color: #ffd700;
        }

        .rating-actions {
            display: flex;
            justify-content: flex-end;
            gap: 10px;
            margin-top: 20px;
        }

        .rating-actions button {
            padding: 8px 16px;
            border-radius: 4px;
            cursor: pointer;
            border: none;
        }

        .submit-rating {
            background-color: #1a472a;
            color: white;
        }

        .close-rating {
            background-color: #6c757d;
            color: white;
        }
    </style>
</head>
<body style="margin-top: 100px; margin-left: 20px; margin-right: 20px;">
    <?php
    require ROOT . '/views/buyer/sidebar.php';
    require ROOT . '/views/components/topbar.php';
    ?>
    <div id="purchase-history-section" class="section">
        <center>
            <h1>Purchase History</h1>
        </center>

        <table class="dashboard-table">
            <thead>
                <tr>
                    <th>Purchase Date</th>
                    <th>Amount</th>
                    <th>Status</th>
                    <th>Rating</th>
                    <th>Feedback</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody id="supervisor-list">
                <?php if(!empty($purchases)): ?>
                    <?php foreach($purchases as $purchase): ?>
                        <tr data-id="<?php echo $purchase->id; ?>"
                            data-date="<?php echo date('Y-m-d', strtotime($purchase->purchase_date)); ?>"
                            data-amount="<?php echo $purchase->amount; ?>"
                            data-status="<?php echo $purchase->status; ?>"
                            data-buyer-name="<?php echo htmlspecialchars($purchase->buyer_name); ?>"
                            data-contact-no="<?php echo htmlspecialchars($purchase->contact_no); ?>"
                            data-crop-type="<?php echo htmlspecialchars($purchase->crop_type); ?>"
                            data-land-address="<?php echo htmlspecialchars($purchase->land_address); ?>">
                            <td><?php echo date('Y-m-d', strtotime($purchase->purchase_date)); ?></td>
                            <td>LKR <?php echo number_format($purchase->amount, 2); ?></td>
                            <td><?php echo ucfirst($purchase->status); ?></td>
                            <td><?php echo $purchase->rating ? number_format($purchase->rating, 1) : 'Not Rated'; ?></td>
                            <td><?php echo $purchase->feedback; ?></td>
                            <td>
                                <button class="blue-btn" onclick="viewInvoice(<?php echo $purchase->id; ?>)">View Invoice</button>
                                <?php if($purchase->status === 'Delivered' && !$purchase->rating): ?>
                                    <button class="green-btn" onclick="showRatingModal(<?php echo $purchase->id; ?>)">Rate Order</button>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5" style="text-align: center;">No purchase history found</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <!-- Invoice Modal -->
    <div id="invoiceModal" class="invoice-modal">
        <div class="invoice-modal-content">
            <span class="close-invoice" onclick="closeInvoice()">&times;</span>
            <div class="invoice-header">
                <h2>Green Lease Invoice</h2>
                <p>Invoice #: <span id="invoiceNumber"></span></p>
                <p>Date: <span id="invoiceDate"></span></p>
            </div>
            
            <div class="invoice-details">
                <div class="buyer-info">
                    <h3>Buyer Information</h3>
                    <p><strong>Buyer Name:</strong> <span id="buyerName"></span></p>
                    <p><strong>Contact Number:</strong> <span id="contactNo"></span></p>
                    <p><strong>Status:</strong> <span id="purchaseStatus"></span></p>
                </div>
                <div class="purchase-info">
                    <h3>Purchase Details</h3>
                    <p><strong>Purchase Date:</strong> <span id="purchaseDate"></span></p>
                    <p><strong>Crop Type:</strong> <span id="cropType"></span></p>
                    <p><strong>Land Address:</strong> <span id="landAddress"></span></p>
                </div>
            </div>

            <div class="invoice-total">
                <h3>Total Amount: LKR <span id="totalAmount"></span></h3>
            </div>

            <div class="invoice-footer">
                <p>Thank you for your business!</p>
                <p>Green Lease - Sustainable Agriculture Solutions</p>
            </div>

            <div class="invoice-actions">
                <button class="close-btn" onclick="closeInvoice()">Close</button>
                <button class="print-btn" onclick="printInvoice()">Print Invoice</button>
            </div>
        </div>
    </div>

    <!-- Rating Modal -->
    <div id="ratingModal" class="rating-modal">
        <div class="rating-modal-content">
            <h2>Rate Your Purchase</h2>
            <p>How would you rate your experience with this purchase?</p>
            <div class="rating-stars">
                <span class="star" data-rating="1">★</span>
                <span class="star" data-rating="2">★</span>
                <span class="star" data-rating="3">★</span>
                <span class="star" data-rating="4">★</span>
                <span class="star" data-rating="5">★</span>
            </div>
            <input type="hidden" id="selectedRating" value="0">
            <input type="hidden" id="currentPurchaseId" value="">
            <div class="rating-actions">
                <button class="close-rating" onclick="closeRatingModal()">Cancel</button>
                <button class="submit-rating" onclick="submitRating()">Submit Rating</button>
            </div>
        </div>
    </div>

    <script>
        function viewInvoice(purchaseId) {
            const row = document.querySelector(`tr[data-id="${purchaseId}"]`);
            const date = row.dataset.date;
            const amount = parseFloat(row.dataset.amount);
            const status = row.dataset.status;
            const buyerName = row.dataset.buyerName;
            const contactNo = row.dataset.contactNo;
            const cropType = row.dataset.cropType;
            const landAddress = row.dataset.landAddress;

            // Update modal content
            document.getElementById('invoiceNumber').textContent = purchaseId;
            document.getElementById('invoiceDate').textContent = new Date().toLocaleDateString();
            document.getElementById('buyerName').textContent = buyerName;
            document.getElementById('contactNo').textContent = contactNo;
            document.getElementById('purchaseStatus').textContent = status;
            document.getElementById('purchaseDate').textContent = date;
            document.getElementById('cropType').textContent = cropType;
            document.getElementById('landAddress').textContent = landAddress;
            document.getElementById('totalAmount').textContent = amount.toLocaleString(undefined, {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2
            });

            // Show the modal
            document.getElementById('invoiceModal').style.display = 'block';
        }

        function closeInvoice() {
            document.getElementById('invoiceModal').style.display = 'none';
        }

        function printInvoice() {
            window.print();
        }

        // Rating Modal Functions
        function showRatingModal(purchaseId) {
            document.getElementById('currentPurchaseId').value = purchaseId;
            document.getElementById('ratingModal').style.display = 'block';
            resetStars();
        }

        function closeRatingModal() {
            document.getElementById('ratingModal').style.display = 'none';
            resetStars();
        }

        function resetStars() {
            document.getElementById('selectedRating').value = '0';
            document.querySelectorAll('.star').forEach(star => {
                star.classList.remove('active');
            });
        }

        // Star rating functionality
        document.querySelectorAll('.star').forEach(star => {
            star.addEventListener('mouseover', function() {
                const rating = this.getAttribute('data-rating');
                highlightStars(rating);
            });

            star.addEventListener('click', function() {
                const rating = this.getAttribute('data-rating');
                document.getElementById('selectedRating').value = rating;
                highlightStars(rating);
            });

            star.addEventListener('mouseout', function() {
                const selectedRating = document.getElementById('selectedRating').value;
                highlightStars(selectedRating);
            });
        });

        function highlightStars(rating) {
            document.querySelectorAll('.star').forEach(star => {
                const starRating = star.getAttribute('data-rating');
                if (starRating <= rating) {
                    star.classList.add('active');
                } else {
                    star.classList.remove('active');
                }
            });
        }

        function submitRating() {
            const purchaseId = document.getElementById('currentPurchaseId').value;
            const rating = document.getElementById('selectedRating').value;

            if (rating === '0') {
                alert('Please select a rating before submitting.');
                return;
            }

            const url = `${URLROOT}/Buyer/Purchase_history/submit_rating`;
            console.log('Submitting rating to:', url);
            console.log('Data:', { purchase_id: purchaseId, rating: rating });

            // Submit rating via AJAX
            fetch(url, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    purchase_id: purchaseId,
                    rating: rating
                })
            })
            .then(response => {
                console.log('Response status:', response.status);
                return response.json();
            })
            .then(data => {
                console.log('Response data:', data);
                if (data.success) {
                    closeRatingModal();
                    alert('Thank you for your rating!');
                    location.reload();
                } else {
                    alert(data.message || 'Error submitting rating. Please try again.');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Error submitting rating. Please try again.');
            });
        }

        // Close modals when clicking outside
        window.onclick = function(event) {
            const invoiceModal = document.getElementById('invoiceModal');
            const ratingModal = document.getElementById('ratingModal');
            
            if (event.target == invoiceModal) {
                closeInvoice();
            }
            if (event.target == ratingModal) {
                closeRatingModal();
            }
        }
    </script>
</body>
</html>