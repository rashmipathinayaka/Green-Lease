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
                <div class="logo">AgriProject Manager</div>
                <nav>
                    <ul>
                        <li><a href="#">Dashboard</a></li>
                        <li><a href="#">Projects</a></li>
                        <li><a href="#">Events</a></li>
                        <li><a href="#">Reports</a></li>
                    </ul>
                </nav>
            </div>
        </div>
    </header>

    <div class="container">
        <!-- Project Details -->
        <section class="project-details">
            <div class="project-image">
                <img src="/api/placeholder/600/400" alt="North Field Agriculture Project">
            </div>
            <div class="project-info">
                <h2 class="project-title">North Field Agriculture Project</h2>
                <div class="project-meta">
                    <div class="meta-item">
                        <h4>Location</h4>
                        <p>123 Farmland Road, Green Valley</p>
                    </div>
                    <div class="meta-item">
                        <h4>Project ID</h4>
                        <p>AGP-2025-042</p>
                    </div>
                    <div class="meta-item">
                        <h4>Supervisor</h4>
                        <p>John Anderson</p>
                    </div>
                    <div class="meta-item">
                        <h4>Site Head</h4>
                        <p>Maria Rodriguez</p>
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
                <div class="project-description">
                    <h3>Project Overview</h3>
                    <p>This large-scale agricultural project focuses on sustainable wheat and corn cultivation using advanced irrigation systems and organic farming practices. The 50-acre site is divided into 5 sectors with varied crop rotation schedules to maximize yield while minimizing environmental impact.</p>
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
        <section class="events-section">
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
        </section>

        <!-- Harvest Timeline -->
        <section class="harvest-timeline">
            <h2 class="section-title">Expected Harvesting Schedule</h2>
            <div class="timeline">
                <div class="timeline-item">
                    <div class="timeline-date">July 15, 2025</div>
                    <h3 class="timeline-title">Early Wheat Harvest - Sector 1</h3>
                    <p class="timeline-description">First wheat harvest from the early planting in Sector 1 (15 acres)</p>
                </div>
                <div class="timeline-item">
                    <div class="timeline-date">August 10, 2025</div>
                    <h3 class="timeline-title">Corn Harvest - Sector 2</h3>
                    <p class="timeline-description">Sweet corn harvest from Sector 2 (10 acres)</p>
                </div>
                <div class="timeline-item">
                    <div class="timeline-date">August 25, 2025</div>
                    <h3 class="timeline-title">Main Wheat Harvest - Sectors 3 & 4</h3>
                    <p class="timeline-description">Primary wheat harvest from Sectors 3 and 4 (20 acres total)</p>
                </div>
                <div class="timeline-item">
                    <div class="timeline-date">September 15, 2025</div>
                    <h3 class="timeline-title">Final Corn Harvest - Sector 5</h3>
                    <p class="timeline-description">Late season corn harvest from Sector 5 (5 acres)</p>
                </div>
            </div>
        </section>

        <!-- Team Section -->
        <section class="team-section">
            <h2 class="section-title">Project Team</h2>
            <div class="team-grid">
                <div class="team-member">
                    <div class="member-avatar">
                        <img src="/api/placeholder/100/100" alt="John Anderson">
                    </div>
                    <div class="member-info">
                        <h4>John Anderson</h4>
                        <p>Project Supervisor</p>
                    </div>
                </div>
                <div class="team-member">
                    <div class="member-avatar">
                        <img src="/api/placeholder/100/100" alt="Maria Rodriguez">
                    </div>
                    <div class="member-info">
                        <h4>Maria Rodriguez</h4>
                        <p>Site Head</p>
                    </div>
                </div>
                <div class="team-member">
                    <div class="member-avatar">
                        <img src="/api/placeholder/100/100" alt="David Chen">
                    </div>
                    <div class="member-info">
                        <h4>David Chen</h4>
                        <p>Irrigation Specialist</p>
                    </div>
                </div>
                <div class="team-member">
                    <div class="member-avatar">
                        <img src="/api/placeholder/100/100" alt="Sarah Williams">
                    </div>
                    <div class="member-info">
                        <h4>Sarah Williams</h4>
                        <p>Agronomist</p>
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
                    <h3>AgriProject Manager</h3>
                    <p>Your complete solution for agricultural project management and tracking.</p>
                </div>
                <div class="footer-section">
                    <h3>Quick Links</h3>
                    <ul>
                        <li><a href="#">Dashboard</a></li>
                        <li><a href="#">Projects</a></li>
                        <li><a href="#">Events</a></li>
                        <li><a href="#">Reports</a></li>
                    </ul>
                </div>
                <div class="footer-section">
                    <h3>Contact</h3>
                    <ul>
                        <li>Email: info@agriproject.com</li>
                        <li>Phone: (555) 123-4567</li>
                        <li>Address: 456 Farm Tech Drive, Agriculture Valley</li>
                    </ul>
                </div>
            </div>
            <div class="copyright">
                <p>&copy; 2025 AgriProject Manager. All rights reserved.</p>
            </div>
        </div>
    </footer>
</body>
</html>