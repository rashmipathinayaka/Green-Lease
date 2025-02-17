<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<div id="profile-section" class="section"">
                <center>
                    <div class="wrapper">
                        <div class="profile-container">
                            <div class="profile-header">
                                <div class="profile-image-container">
                                    <img id="profileImage" src="<?= ROOT ?>/assets/images/hero.jpg" alt="User Profile"
                                        class="profile-image">
                                    <label for="imageUpload" class="image-edit-overlay">✏️</label>
                                    <input type="file" id="imageUpload" accept="image/*">
                                </div>

                                <div class="profile-details-edit">
                                    <div class="detail-group">
                                        <div class="detail-label">Full Name</div>
                                        <div id="fullName" class="detail-value" contenteditable="true"
                                            data-placeholder="Enter full name">Sasmitha Silva</div>
                                    </div>
                                </div>
                            </div>
                            <div class="detail-group">
                                <div class="detail-label">Email Address</div>
                                <div id="emailAddress" class="detail-value" contenteditable="true"
                                    data-placeholder="Enter email address">silvasasmitha53@gmail.com</div>
                            </div>
                            <div class="detail-group">
                                <div class="detail-label">Contact Number</div>
                                <div id="contactNumber" class="detail-value" contenteditable="true"
                                    data-placeholder="Enter phone number">0715479744</div>
                            </div>
                            <div class="detail-group">
                                <div class="detail-label">Address</div>
                                <div id="address" class="detail-value" contenteditable="true"
                                    data-placeholder="Enter full address">12/1, 1st Lane, Kandy Road, Kandy</div>
                            </div>
                            <button id="submitBtn" class="green-btn">Save Profile</button>
                        </div>
                    </div>
                </center>
            </div>
</body>
</html>