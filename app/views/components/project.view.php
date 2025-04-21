<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Project Details & Events</title>
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/assets/CSS/components/project.css">

</head>

<body>
    <!-- Header -->
    <header>
        <div class="container">
            <div class="header-content">
                <div class="logo">Project ID: <?php echo $projectdetails->id; ?></div>
              
            
            <div class="nav">
             
                <?php echo $projectdetails->status; ?>
                </div></div>
    </header>

    <div class="container">
        <!-- Project Details -->
        <section class="project-details">
            <div class="project-image">
                <?php foreach ($eventdetails as $event): ?>
                    <?php
                    // Decode the JSON if it's not already an array
                    $images = json_decode($event->completion_images);
                    ?>
                    <?php if (!empty($images)): ?>
                        <div class="event-gallery">

                            <!-- Display only the first image initially -->
                            <div class="event-image-container" data-event-name="<?= htmlspecialchars($event->event_name) ?>" onclick="openImageModal(<?= $event->id ?>)">
                                <img src="http://localhost/Green-lease/app/uploads/event_images/<?= htmlspecialchars($images[0]) ?>" alt="Event Image" class="event-image-thumbnail">
                            </div>

                            <!-- Hidden Modal that will display all images when clicked -->
                            <div id="modal-<?= $event->id ?>" class="image-modal" style="display: none;">
                                <div class="modal-content">
                                    <span class="close" onclick="closeImageModal(<?= $event->id ?>)">&times;</span>
                                    <h3>Event: <?= htmlspecialchars($event->event_name) ?></h3>
                                    <div class="modal-images">
                                        <?php foreach ($images as $img): ?>
                                            <img src="http://localhost/Green-lease/app/uploads/event_images/<?= htmlspecialchars($img) ?>" alt="Event Image">
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                <?php endforeach; ?>
            </div>



            <div class="project-info">
                <h2 class="project-title">Details about the land</h2>

                <!-- First Meta Section -->
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
                        <h4>Size of the land</h4>
                        <p><?php echo htmlspecialchars($landdetails->size) ?></p>
                    </div>
                    <div class="meta-item">
                        <h4>leased time period</h4>
                        <p><?php echo htmlspecialchars($landdetails->duration) ?> years</p>
                    </div>
                    <div class="meta-item">
                        <h4>Registered Date</h4>
                        <p><?php echo htmlspecialchars($landdetails->registered_date) ?></p>
                    </div>

                </div>
                <br><br>
                <!-- Second Meta Section -->
                <h2 class="project-title">Details abut the project</h2>

                <div class="project-meta">
                    <div class="meta-item">
                        <h4>project ID</h4>
                        <p><?php echo htmlspecialchars($projectdetails->id) ?></p>
                    </div>
                    <div class="meta-item">
                        <h4>Expected end date</h4>
                        <p><?php echo htmlspecialchars($projectdetails->end_date) ?></p>
                    </div>
                    <div class="meta-item">
                        <h4>Preffered crop</h4>
                        <p><?php echo htmlspecialchars($landdetails->crop_type) ?></p>
                    </div>
                    <div class="meta-item">
                        <h4>Selected crop</h4>
                        <p><?php echo htmlspecialchars($projectdetails->crop_type) ?></p>
                    </div>
                    <div class="meta-item">
                        <h4>Start Date</h4>
                        <p>March 15, 2025</p>
                    </div>
                    <div class="meta-item">
                        <h4>Expected Completion</h4>
                        <p>September 30, 2025</p>
                    </div>
                </div>
            </div>

        </section>

        <!-- Stats Section -->
        <section class="stats-section">
            <div class="stat-card">
                <div class="stat-value">50</div>
                <div class="stat-label">Acres</div>
            </div>
            <div class="stat-card">
                <div class="stat-value">5</div>
                <div class="stat-label">Crop Varieties</div>
            </div>
            <div class="stat-card">
                <div class="stat-value">12</div>
                <div class="stat-label">Team Members</div>
            </div>
            <div class="stat-card">
                <div class="stat-value">85%</div>
                <div class="stat-label">Progress</div>
            </div>
        </section>

        <!-- Upcoming Events -->
        <!-- <section class="events-section">
            <h2 class="section-title">Upcoming Events</h2>
            <div class="events-grid">
                <div class="event-card">
                    <div class="event-image">
                        <img src="/api/placeholder/400/250" alt="Irrigation System Update">
                    </div>
                    <div class="event-details">
                        <div class="event-date">April 20, 2025</div>
                        <h3>Irrigation System Update</h3>
                        <p class="event-description">Installation of new drip irrigation components in Sectors 3 and 4.</p>
                        <span class="event-status status-upcoming">Upcoming</span>
                    </div>
                </div>
                <div class="event-card">
                    <div class="event-image">
                        <img src="/api/placeholder/400/250" alt="Pest Control Application">
                    </div>
                    <div class="event-details">
                        <div class="event-date">April 25, 2025</div>
                        <h3>Pest Control Application</h3>
                        <p class="event-description">Organic pest control application throughout all sectors.</p>
                        <span class="event-status status-upcoming">Upcoming</span>
                    </div>
                </div>
                <div class="event-card">
                    <div class="event-image">
                        <img src="/api/placeholder/400/250" alt="Soil Quality Assessment">
                    </div>
                    <div class="event-details">
                        <div class="event-date">May 5, 2025</div>
                        <h3>Soil Quality Assessment</h3>
                        <p class="event-description">Comprehensive soil analysis for nutrient levels and pH balance.</p>
                        <span class="event-status status-planned">Planned</span>
                    </div>
                </div>
            </div>
        </section> -->

        <!-- Harvest Timeline -->
        <section class="harvest-timeline">
            <h2 class="section-title">Expected Harvesting Schedule</h2>
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
                                        echo "Upcomming";
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

        <!-- Team Section -->
        <section class="team-section">
            <h2 class="section-title">Project Team</h2>
            <div class="team-grid">
                <div class="team-member">
                    <div class="member-avatar">
                        <!-- Displaying the profile picture -->
                        <img src="<?php echo URLROOT . '/assets/Images/' . htmlspecialchars($sitehead->propic); ?>" alt="Site Head Avatar" />
                    </div>
                    <div class="member-info">
                        <h4><?php echo htmlspecialchars($sitehead->full_name); ?></h4>
                        <p>Sitehead of the land</p>
                    </div>
                </div>



                <div class="team-member">
                    <div class="member-avatar">
                        <img src="<?php echo URLROOT . '/assets/Images/' . htmlspecialchars($supervisor->propic); ?>" alt="Site Head Avatar" />
                    </div>
                    <div class="member-info">
                        <h4><?php echo htmlspecialchars($supervisor->full_name) ?></h4>
                        <p>Supervisor for the zone
                            Agronomist
                        </p>
                    </div>
                </div>


            </div>
        </section>
    </div>

    <!-- Footer -->
    <footer>
        <div class="container">
            <div class="footer-content">
                <div class="footer-section">

                    <h2>Give you feedbacks about the project here.</h2>
                    <h3> Your sitehead,supervisor would see
                        your feedbacks and will make sure to improve the project.</h3>
                    <form action="<?= URLROOT ?>/components/project/getfeedback/<?php echo $projectdetails->id; ?>" method="POST">
                        <input type="text" name="feedback" placeholder="Enter your feedback here..." class="feedback-input">
                        <button type="submit" class="feedback-button">Submit</button>
                    </form>





                </div>
    </footer>
</body>
<script>
    // Function to open the modal and display all images
    function openImageModal(eventId) {
        var modal = document.getElementById("modal-" + eventId);
        modal.style.display = "block";
    }

    // Function to close the modal
    function closeImageModal(eventId) {
        var modal = document.getElementById("modal-" + eventId);
        modal.style.display = "none";
    }

    // Close the modal if the user clicks anywhere outside of the modal
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

</html>