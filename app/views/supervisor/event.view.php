

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/assets/css/supervisor.css">
    <title>Project Events</title>
    <style>
        .worker-events-header {
             margin-top:40px;
            margin-bottom: 15px;
            padding-bottom: 10px;
            border-bottom: 1px solid #e0e0e0;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .worker-events-header h2 {
            margin: 0;
            color: #2c3e50;
        }

        .project-id-card {
    background: linear-gradient(135deg, #f0fff4 0%, #ffffff 100%);
    border-radius: 12px;
    padding: 16px 20px;
    margin-bottom: 16px;
    cursor: pointer;
    border-left: 6px solid #2e7d32;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.06);
    transition: all 0.3s ease;
}

.project-id-card:hover {
    background: #e8f5e9;
    transform: translateY(-3px);
}

.project-id-header {
    
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.project-id-header h3 {
    font-size: 1.1rem;
    font-weight: 600;
    color: #2c3e50;
    margin: 0;
}

.event-date-label {
    font-size: 0.85rem;
    color: #2e7d32;
    font-weight: 500;
    background-color: #d0f0da;
    padding: 4px 8px;
    border-radius: 20px;
    margin-right: 8px;
}

        .event-details-container {
            display: none;
            margin-top: 10px;
            padding-top: 10px;
            border-top: 1px dashed #ddd;
        }

        .worker-events-list {
            max-height: 500px;
            overflow-y: auto;
            padding-right: 8px;
        }

        .worker-event-card {
            margin-bottom: 8px;
            background-color: white;
            padding: 8px;
            border-radius: 5px;
            box-shadow: 0 1px 2px rgba(0,0,0,0.05);
        }

        .worker-event-icon {
            display: inline-block;
            width: 30px;
            height: 30px;
            text-align: center;
            line-height: 30px;
            background-color: #e8f5e9;
            color: #4CAF50;
            border-radius: 50%;
            margin-right: 10px;
        }

        .worker-event-details {
            display: inline-block;
            vertical-align: top;
            width: calc(100% - 45px);
        }

        .worker-event-header h3 {
            margin: 0 0 5px 0;
            font-size: 0.9rem;
        }

        .worker-event-info {
            display: flex;
            flex-wrap: wrap;
            font-size: 0.8rem;
            color: #555;
        }

        .worker-event-info span {
            margin-right: 10px;
            margin-bottom: 5px;
        }

        .active-project {
    background-color: #d4edda;
    border-left: 6px solid #1b5e20;
    box-shadow: 0 6px 16px rgba(0, 0, 0, 0.08);
}


        .expand-icon {
    font-size: 0.9rem;
    color: #2e7d32;
    transition: transform 0.3s ease;
    margin-left: 4px;
}

.rotate-icon {
    transform: rotate(180deg);
}

.event-details-container {
    display: none;
    margin-top: 12px;
    padding-top: 12px;
    border-top: 1px dashed #b2dfdb;
    animation: fadeIn 0.3s ease;
}

@keyframes fadeIn {
    from { opacity: 0; transform: translateY(-5px); }
    to { opacity: 1; transform: translateY(0); }
}
.add-event-button {
    background-color: #2e7d32;
    color: white;
    border: none;
    padding: 8px 16px;
    font-size: 0.95rem;
    border-radius: 6px;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

.add-event-button:hover {
    background-color: #27632a;
}
#add-event-form {
            display: none;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background: #ffffff;
            padding: 24px;
            border-radius: 12px;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.15);
            z-index: 1000;
            width: 100%;
            max-width: 500px;
            animation: fadeIn 0.3s ease-in-out;
        }

        #add-event-form h3 {
            margin-bottom: 20px;
            font-size: 1.4rem;
            color: #2c3e50;
        }

        #add-event-form form {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        #add-event-form label {
            font-size: 0.9rem;
            font-weight: 600;
            color: #2c3e50;
            margin-bottom: 5px;
        }

        #add-event-form input {
            padding: 10px 12px;
            font-size: 0.9rem;
            border: 1px solid #ccc;
            border-radius: 6px;
            transition: border-color 0.3s ease;
        }

        #add-event-form input:focus {
            border-color: #2e7d32;
            outline: none;
            box-shadow: 0 0 0 3px rgba(46, 125, 50, 0.1);
        }

        #add-event-form button {
            padding: 10px 16px;
            font-size: 0.95rem;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        #add-event-form button[type="button"]:first-of-type {
            background-color: #2e7d32;
            color: white;
        }

        #add-event-form button[type="button"]:first-of-type:hover {
            background-color: #27632a;
        }

        #add-event-form button[type="button"]:last-of-type {
            background-color: #f5f5f5;
            color: #333;
        }

        #add-event-form button[type="button"]:last-of-type:hover {
            background-color: #e0e0e0;
        }

        #form-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.4);
            z-index: 999;
        }
        #add-event-form textarea {
    padding: 10px 12px;
    font-size: 0.9rem;
    border: 1px solid #ccc;
    border-radius: 6px;
    transition: border-color 0.3s ease;
    width: 100%;
    resize: vertical; /* Allows resizing the height */
}

#add-event-form textarea:focus {
    border-color: #2e7d32;
    outline: none;
    box-shadow: 0 0 0 3px rgba(46, 125, 50, 0.1);
}

    </style>
</head>
<body>

<?php
require ROOT . '/views/supervisor/sidebar.php';
require ROOT . '/views/components/topbar.php';
 ?>

<?php
$events = [
    [
        'project_id' => 'PRJ-001',
        'events' => [
            [
                'name' => 'Land Clearing',
                'time' => '09:00 AM',
                'date' => '2025-04-15',
                'location' => 'Field A, No. 12, Green Valley Road',
                'worker' => 'Ruwan Fernando',
                'icon' => 'fas fa-leaf'
            ]
        ]
    ],
    [
        'project_id' => 'PRJ-002',
        'events' => [
            [
                'name' => 'Soil Testing',
                'time' => '11:00 AM',
                'date' => '2025-04-15',
                'location' => 'Lab 1, No. 45, Orchard Street',
                'worker' => 'Priyanka Silva',
                'icon' => 'fas fa-vial'
            ],
            [
                'name' => 'Fertilizing',
                'time' => '01:00 PM',
                'date' => '2025-04-15',
                'location' => 'Field B, No. 89, Sunset Avenue',
                'worker' => 'Saman Kumara',
                'icon' => 'fas fa-seedling'
            ]
        ]
    ],
    [
        'project_id' => 'PRJ-003',
        'events' => [
            [
                'name' => 'Seed Sowing',
                'time' => '03:00 PM',
                'date' => '2025-04-15',
                'location' => 'Field C, No. 7, Maple Lane',
                'worker' => 'Nuwan Perera',
                'icon' => 'fas fa-seedling'
            ]
        ]
    ],
    [
        'project_id' => 'PRJ-004',
        'events' => [
            [
                'name' => 'Harvesting',
                'time' => '05:00 PM',
                'date' => '2025-04-10',
                'location' => 'Field D, No. 23, Sunshine Road',
                'worker' => 'Chaminda Karunaratne',
                'icon' => 'fas fa-tractor'
            ],
            [
                'name' => 'Processing the Harvest',
                'time' => '07:00 PM',
                'date' => '2025-04-16',
                'location' => 'Processing Unit, No. 5, Industrial Park',
                'worker' => 'Kusal Jayawardena',
                'icon' => 'fas fa-box'
            ]
        ]
    ],
    [
        'project_id' => 'PRJ-005',
        'events' => [
            [
                'name' => 'Weeding',
                'time' => '08:00 AM',
                'date' => '2025-04-14',
                'location' => 'Field E, No. 37, Evergreen Lane',
                'worker' => 'Ashoka Rathnayake',
                'icon' => 'fas fa-broom'
            ]
        ]
    ]
];
// Sort projects by earliest event date
usort($events, function ($a, $b) {
    $aDate = min(array_map(fn($e) => strtotime($e['date']), $a['events']));
    $bDate = min(array_map(fn($e) => strtotime($e['date']), $b['events']));
    return $aDate - $bDate;
});
?>

<div id="event-schedule-section" class="section">
    <div class="worker-events-container">
        <div class="worker-events-header">
            <h2><i class="fas fa-calendar-alt"></i> Project Events</h2>
            <button class="add-event-button" onclick="openAddEventForm()">
                <i class="fas fa-plus"></i> Add Event
            </button>
        </div>

        <div class="worker-events-list">
            <?php foreach ($events as $project): ?>
                <?php
                $earliestDate = min(array_map(fn($e) => $e['date'], $project['events']));
                $formattedDate = date("F j, Y", strtotime($earliestDate));
                ?>
                <div class="project-id-card" onclick="toggleEvents(this)">
                    <div class="project-id-header">
                        <h3><?= $project['project_id'] ?></h3>
                        <div>
                            <span class="event-date-label"><?= $formattedDate ?></span>
                            <i class="fas fa-chevron-down expand-icon"></i>
                        </div>
                    </div>
                    <div class="event-details-container">
                        <?php foreach ($project['events'] as $event): ?>
                            <div class="worker-event-card">
                                <div class="worker-event-icon"><i class="<?= $event['icon'] ?>"></i></div>
                                <div class="worker-event-details">
                                    <div class="worker-event-header"><h3><?= $event['name'] ?></h3></div>
                                    <div class="worker-event-info">
                                        <span><i class="fas fa-calendar"></i> <?= date("F j, Y", strtotime($event['date'])) ?></span>
                                        <span><i class="fas fa-clock"></i> <?= $event['time'] ?></span>
                                        <span><i class="fas fa-map-pin"></i> <?= $event['location'] ?></span>
                                        <span><i class="fas fa-user"></i> <?= $event['worker'] ?></span>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>

<!-- Add Event Form Modal -->
<div id="add-event-form">
    <h3>Add New Event</h3>
    <form id="eventForm">
        <div>
            <label for="project_id">Project ID</label>
            <input type="text" id="project_id" name="project_id" required>
        </div>
        <div>
            <label for="event_name">Event Name</label>
            <input type="text" id="event_name" name="event_name" required>
        </div>
        <div>
            <label for="event_date">Date</label>
            <input type="date" id="event_date" name="event_date" required>
        </div>
        <div>
            <label for="event_time">Time</label>
            <input type="time" id="event_time" name="event_time" required>
        </div>
        <div>
    <label for="event_description">Description</label>
    <textarea id="event_description" name="event_description" rows="4" required></textarea>
</div>

        <div>
            <label for="event_worker">No of Workers</label>
            <input type="text" id="event_workers" name="event_workers" required>
        </div>
    
        <button type="button" onclick="submitEventForm()">Submit</button>
        <button type="button" onclick="closeAddEventForm()">Cancel</button>
    </form>
</div>

<div id="form-overlay" onclick="closeAddEventForm()"></div>

<script>
    function toggleEvents(element) {
        element.classList.toggle('active-project');
        const detailsContainer = element.querySelector('.event-details-container');
        const icon = element.querySelector('.expand-icon');
        if (detailsContainer.style.display === 'block') {
            detailsContainer.style.display = 'none';
            icon.classList.remove('rotate-icon');
        } else {
            detailsContainer.style.display = 'block';
            icon.classList.add('rotate-icon');
        }
    }

    function openAddEventForm() {
        document.getElementById('add-event-form').style.display = 'block';
        document.getElementById('form-overlay').style.display = 'block';
    }

    function closeAddEventForm() {
        document.getElementById('add-event-form').style.display = 'none';
        document.getElementById('form-overlay').style.display = 'none';
    }

    function submitEventForm() {
        // Example stub: This is where you'd handle form submission.
        alert("Event submitted! (Hook this to backend for actual use)");
        closeAddEventForm();

        // Optional: reset form after submission
        document.getElementById("eventForm").reset();
    }

    function submitEventForm() {
        const projectID = document.getElementById('project_id').value.trim();
        const eventName = document.getElementById('event_name').value.trim();
        const eventDate = document.getElementById('event_date').value;
        const eventTime = document.getElementById('event_time').value;
        const numWorkers = document.getElementById('event_workers').value.trim();

        let errorMessages = [];

        if (projectID === '') {
            errorMessages.push("Project ID is required.");
            highlightField(document.getElementById('project_id'), false);
        } else {
            highlightField(document.getElementById('project_id'), true);
        }

        if (eventName === '') {
            errorMessages.push("Event name is required.");
            highlightField(document.getElementById('event_name'), false);
        } else {
            highlightField(document.getElementById('event_name'), true);
        }

        if (eventDate === '') {
            errorMessages.push("Event date is required.");
            highlightField(document.getElementById('event_date'), false);
        } else {
            highlightField(document.getElementById('event_date'), true);
        }

        if (eventTime === '') {
            errorMessages.push("Event time is required.");
            highlightField(document.getElementById('event_time'), false);
        } else {
            highlightField(document.getElementById('event_time'), true);
        }

        if (numWorkers === '') {
            errorMessages.push("Number of workers is required.");
            highlightField(document.getElementById('event_workers'), false);
        } else if (!/^\d+$/.test(numWorkers)) {
            errorMessages.push("Number of workers must be a valid number.");
            highlightField(document.getElementById('event_workers'), false);
        } else {
            highlightField(document.getElementById('event_workers'), true);
        }

        if (errorMessages.length > 0) {
            alert("Please fix the following errors:\n\n" + errorMessages.join("\n"));
            return;
        }

        const form = document.getElementById('eventForm');
        const formData = new FormData(form);

        console.log(Object.fromEntries(formData.entries()));

        // TODO: Send data to the server via AJAX or standard form submission
        closeAddEventForm();
    }

    function highlightField(field, isValid) {
        field.style.borderColor = isValid ? "#ccc" : "red";
    }
</script>

</body>
</html>