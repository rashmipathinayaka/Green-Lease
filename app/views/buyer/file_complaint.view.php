<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/assets/css/buyer.css">
    <title>File a Complaint</title>
</head>
<body style="margin-top: 100px; margin-left: 20px; margin-right: 20px;">
<?php
require ROOT . '/views/buyer/sidebar.php';
require ROOT . '/views/components/topbar.php';
?>
<div id="file-a-complaint-section" class="section">
    <div class="complaint-section">
        <div class="form-container">
            <h1 class="complaint-topic">File a Complaint</h1>
            
            <?php if(isset($success)): ?>
                <div class="alert alert-success"><?php echo $success; ?></div>
            <?php endif; ?>
            
            <?php if(isset($error)): ?>
                <div class="alert alert-danger"><?php echo $error; ?></div>
            <?php endif; ?>
            
            <form class="form" method="POST" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="complaint-type">Type of Complaint</label>
                    <select id="complaint-type" name="complaint-type" required>
                        <option value="">Select a category</option>
                        <option value="Product Quality Issue">Product Quality Issue</option>
                        <option value="Payment/Billing Issues">Payment/Billing Issues</option>
                        <option value="Customer Service Experience">Customer Service Experience</option>
                        <option value="Product Description Mismatch">Product Description Mismatch</option>
                        <option value="Return/Refund Issues">Return/Refund Issues</option>
                        <option value="Shipping Delays/Damage">Shipping Delays/Damage</option>
                        <option value="Pricing Disputes">Pricing Disputes</option>
                        <option value="Order Cancellation Problems">Order Cancellation Problems</option>
                        <option value="Website/App Technical Issues">Website/App Technical Issues</option>
                        <option value="Other">Other</option>
                    </select>
                    <label for="description">Complaint Description</label>
                    <textarea id="description" name="description" required
                        placeholder="Please provide detailed information about your complaint..."></textarea>
                    <label for="attachment">Supporting Documents (if any)</label>
                    <input type="file" id="attachment" name="attachment">
                    <p class="attachment-note">Accepted file formats: PDF, JPG, PNG (Max size: 5MB)</p>
                                   
                    <button class="form-submit-btn" type="submit">
                        <i class="fas fa-paper-plane"></i>&nbsp; Submit Complaint
                    </button>
                </div>  
            </form>
        </div>
    </div>
</div>
</body>
</html>