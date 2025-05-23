<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Project Details & Events</title>
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/assets/CSS/components/project.css">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>

</head>

<body>
    <header>
        <div class="container">
            <div class="header-content">
                <div class="logo">Project ID: <?php echo $projectdetails->id; ?></div>


                <div class="nav">

                    <?php echo $projectdetails->status; ?>
                </div>
            </div>
    </header>

    <div class="container">

        <section class="project-details">
            <div class="project-image">
                <?php if (!empty($eventdetails)): ?>
                    <?php foreach ($eventdetails as $event): ?>
                        <?php if (!empty($event->images)): ?>
                            <div class="event-gallery">
                                <div class="event-image-container" data-event-name="<?= htmlspecialchars($event->event_name) ?>" onclick="openImageModal(<?= $event->id ?>)">
                                    <img src="http://localhost/Green-lease/app/uploads/event_images/<?= htmlspecialchars($event->images[0]) ?>" alt="Event Image" class="event-image-thumbnail">
                                </div>

                                <div id="modal-<?= $event->id ?>" class="image-modal" style="display: none;">
                                    <div class="modal-content">
                                        <span class="close" onclick="closeImageModal(<?= $event->id ?>)">&times;</span>
                                        <h3>Event: <?= htmlspecialchars($event->event_name) ?></h3>
                                        <div class="modal-images">
                                            <?php foreach ($event->images as $img): ?>
                                                <img src="http://localhost/Green-lease/app/uploads/event_images/<?= htmlspecialchars($img) ?>" alt="Event Image">
                                            <?php endforeach; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php else: ?>
                            <div class="no-images-message">
                                <p>No images for now</p>
                            </div>
                        <?php endif; ?>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="no-images-message">
                        <p>No event images available for this project yet.</p>
                    </div>
                <?php endif; ?>
            </div>






            <div id="map" style="height: 500px; width: 100%;"></div>


            <div class="project-info">
                <h2 class="project-title">Details About the Land</h2>

                <div class="project-meta">
                    <div class="meta-item">
                        <h4>Land ID</h4>
                        <p><?php echo htmlspecialchars($landdetails->id) ?></p>
                    </div>


                    <div class="meta-item">
                        <h4>Address</h4>
                        <p><?php echo htmlspecialchars($landdetails->address) ?></p>
                    </div>
                    <div class="meta-item">
                        <h4>District</h4>
                        <p><?php echo htmlspecialchars($landdetails->zone) ?></p>
                    </div>

                    <div class="meta-item">
                        <h4>Size of the Land</h4>
                        <p><?php echo htmlspecialchars($landdetails->size) ?></p>
                    </div>
                    <div class="meta-item">
                        <h4>Leased Time Period</h4>
                        <p><?php echo htmlspecialchars($landdetails->duration) ?> years</p>
                    </div>
                    <div class="meta-item">
                        <h4>Registered Date</h4>
                        <p><?php echo htmlspecialchars($landdetails->registered_date) ?></p>
                    </div>




                </div>
                <br><br>
                <h2 class="project-title">Details About the Project</h2>

                <div class="project-meta">
                    <div class="meta-item">
                        <h4>Project ID</h4>
                        <p><?php echo htmlspecialchars($projectdetails->id) ?></p>
                    </div>
                    <div class="meta-item">
                        <h4>Expected End Date</h4>
                        <p><?php echo htmlspecialchars($projectdetails->end_date ?? ' ') ?></p>
                    </div>
                    <div class="meta-item">
                        <h4>Preffered Crop</h4>
                        <p><?php echo htmlspecialchars($landdetails->crop_type) ?></p>
                    </div>
                    <div class="meta-item">
                        <h4>Selected Crop</h4>
                        <p><?php echo htmlspecialchars($projectdetails->crop_type) ?></p>
                    </div>
                    <div class="meta-item">
                        <h4>Start Date</h4>
                        <p><?php echo htmlspecialchars($projectdetails->start_date) ?></p>
                    </div>

                </div>
            </div>

        </section>




        <section class="harvest-timeline">
            <h2 class="section-title">Event Schedule</h2>
            <div class="timeline">
                <div class="timeline-item">


                    <?php if (!empty($eventdetails)): ?>
                        <?php foreach ($eventdetails as $event): ?>
                            <div class="timeline-item">
                                <h3 class="timeline-title1">
                                    <?php
                                    if ($event->id == '1') {
                                        echo "Done";
                                    } else {
                                        echo "Upcoming";
                                    }
                                    ?>
                                </h3>


                                <h3 class="timeline-title"><?php echo htmlspecialchars($event->id); ?></h3>

                                <div class="timeline-date"><?php echo htmlspecialchars($event->date); ?></div>
                                <h3 class="timeline-title"><?php echo htmlspecialchars($event->event_name); ?></h3>
                                <p class="timeline-description">
                                    <?php echo htmlspecialchars($event->description ?? 'No description provided.'); ?>
                                </p>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p>No events found for this project.</p>
                    <?php endif; ?>



                </div>
        </section>

        <section class="team-section">
            <h2 class="section-title">Project Team</h2>
            <div class="team-grid">
                <div class="team-member">
                    <div class="member-avatar">
                        <img src="<?php echo URLROOT . '/assets/Images/' . htmlspecialchars($sitehead->propic); ?>" alt="Site Head Avatar" />
                    </div>
                    <div class="member-info">
                        <h4><?php echo htmlspecialchars($sitehead->full_name); ?></h4> 
                        <h4>Tel:<?php echo htmlspecialchars($sitehead->contact_no) ?></h4>

                        <p>Sitehead of the land</p>
                    </div>
                </div>



                <div class="team-member">
                    <div class="member-avatar">
                        <img src="<?php echo URLROOT . '/assets/Images/' . htmlspecialchars($supervisor->propic); ?>" alt="Site Head Avatar" />
                    </div>
                    <div class="member-info">
                        <h4><?php echo htmlspecialchars($supervisor->full_name) ?></h4>
                        <h4>Tel:<?php echo htmlspecialchars($supervisor->contact_no) ?></h4>

                        <p>Supervisor for the zone
                            Agronomist
                        </p>
                    </div>
                </div>


            </div>
        </section>
    </div>

    <!-- Footer -->
    <?php if (isset($_SESSION['id'])): ?>
        <footer>
            <div class="container">
                <div class="footer-content">
                    <div class="footer-section">

                        <h2>Give Your Feedback About the Project Here.</h2>
                        <h3> Your Sitehead, Supervisor would see
                            your feedbacks and will make sure to improve the project.</h3><br>
                        <form action="<?= URLROOT ?>/components/project/getfeedback/<?php echo $projectdetails->id; ?>" method="POST">
                            <input style="margin-bottom: 10px;" type="text" name="feedback" placeholder="Enter your feedback here" class="feedback-input">
                            <button style="padding: 10px 100px;" type="submit" class="feedback-button">Submit</button>
                        </form>


                    </div>
        </footer>

    <?php endif; ?>

</body>


<script>
    function openImageModal(eventId) {
        var modal = document.getElementById("modal-" + eventId);
        modal.style.display = "block";
    }

    function closeImageModal(eventId) {
        var modal = document.getElementById("modal-" + eventId);
        modal.style.display = "none";
    }

    window.onclick = function(event) {
        var modal;
        for (let eventId of <?= json_encode(array_column($eventdetails, 'id')) ?>) {
            modal = document.getElementById("modal-" + eventId);
            if (event.target === modal) {
                modal.style.display = "none";
            }
        }
    }
</script>
<script>
    var latitude = <?php echo $landdetails->latitude; ?>;
    var longitude = <?php echo $landdetails->longitude; ?>;

    var map = L.map('map').setView([latitude, longitude], 13);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
    }).addTo(map);

    L.marker([latitude, longitude]).addTo(map)
        .bindPopup("Project Location")
        .openPopup();
</script>



</html>