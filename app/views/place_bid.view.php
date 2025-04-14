<h2>Place a Bid</h2>
<p>For: <strong><?= htmlspecialchars($harvest['crop_type']) ?></strong> from <?= htmlspecialchars($harvest['land_id']) ?></p>

<form method="post">
    <label>Amount (e.g., kg):</label>
    <input type="number" name="amount" required>

    <label>Unit Price (Rs):</label>
    <input type="number" name="unit_price" step="0.01" required>

    <button type="submit">Submit Bid</button>
</form>
