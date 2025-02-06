<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/assets/css/landowner/registerland.css">
    <title>Register Land</title>
</head>
<body>
<?php

require ROOT . '/views/landowner/sidebar.php';
require ROOT . '/views/components/navbar.php';

?>

<div id="register-lands-section" class="section">

    <h1 class="register-topic">Register Your Land</h1><br><br>

    <div class="form-container">
        <form enctype="multipart/form-data" method="POST" action="<?php echo URLROOT; ?>/Landowner/registerland">
            <div class="form-group">

                <div class="form-input-title">Address: </div>
                <input type="text" name="address" id="address" class="address" required>
                
                <div class="form-input-title">Size of the land (in sq meters): </div>
                <input type="number" name="size" id="size" class="size" required>

                <div class="form-input-title">Duration (in years): </div>
                <input type="number" name="duration" id="duration" class="duration" required>

                <div class="form-input-title">Preferred Crop Type: </div>
                <input type="text" name="crop" id="crop" class="crop" required>

                <div class="form-input-title">Upload Legal Document: </div>
                <input type="file" name="document" id="document" class="document" >

                <h6>You Cannot Change the Details Again</h6>
                
                <button class="form-submit-btn" type="submit">Submit</button>
            </div>  
        </form>

        <?php if (!empty($data['errors'])): ?>
        <div class="error-container">
            <?php foreach ($data['errors'] as $error): ?>
                <p class="error-message"><?= htmlspecialchars($error) ?></p>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>
    </div>
</div>

</body>
</html>
