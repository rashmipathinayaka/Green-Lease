<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Project Events</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <link rel="stylesheet" href="<?php echo URLROOT; ?>/assets/CSS/supervisor/event.css">
  <!-- Flatpickr Time Picker -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

  <style>
    .past-event {
      opacity: 0.6;
      filter: grayscale(100%);
      pointer-events: none;
      user-select: none;
      position: relative;
    }

    .past-event::after {
      content: "PAST EVENT";
      position: absolute;
      top: 8px;
      right: 8px;
      background-color: #721c24;
      color: white;
      font-size: 12px;
      padding: 2px 6px;
      border-radius: 4px;
      font-weight: bold;
      opacity: 0.8;
    }
  </style>
</head>

<body>
<?php
require ROOT . '/views/supervisor/sidebar.php';
require ROOT . '/views/components/topbar.php';

// Sample data
$projects = [
  [
    'id' => 'P001',
    'crop' => 'Tomatoes',
    'address' => 'Green Valley Road',
    'events' => [
      ['name' => 'Land Preparation', 'date' => '2025-04-15', 'time' => '09:00 AM', 'location' => 'Green Valley Road', 'workers' => 10, 'payment' => 'Rs. 1000'],
      ['name' => 'Irrigation Setup', 'date' => '2025-04-28', 'time' => '01:00 PM', 'location' => 'Green Valley Road', 'workers' => 5, 'payment' => 'Rs. 1200'],
    ]
  ],
  [
    'id' => 'P002',
    'crop' => 'Carrots',
    'address' => 'Sunset Avenue',
    'events' => []
  ],
  [
    'id' => 'P003',
    'crop' => 'Lettuce',
    'address' => 'Hilltop Garden',
    'events' => [
      ['name' => 'Weeding', 'date' => '2025-04-20', 'time' => '10:30 AM', 'location' => 'Hilltop Garden', 'workers' => 8, 'payment' => 'Rs. 900']
    ]
    ],
    [
      'id' => 'P004',
      'crop' => 'Beans',
      'address' => 'Marine Avenue',
      'events' => [
        ['name' => 'Weeding', 'date' => '2025-04-12', 'time' => '12:30 AM', 'location' => 'Marine Avenue', 'workers' => 10, 'payment' => 'Rs. 1100']
      ]
    ]
];

// Sort projects based on earliest UPCOMING event date (past events ignored for sorting)
usort($projects, function($a, $b) {
  $aDate = '';
  $bDate = '';
  $today = date('Y-m-d');

  if (!empty($a['events'])) {
    $upcomingA = array_filter($a['events'], fn($e) => $e['date'] >= $today);
    if (!empty($upcomingA)) {
      $aDate = min(array_column($upcomingA, 'date'));
    }
  }

  if (!empty($b['events'])) {
    $upcomingB = array_filter($b['events'], fn($e) => $e['date'] >= $today);
    if (!empty($upcomingB)) {
      $bDate = min(array_column($upcomingB, 'date'));
    }
  }

  if ($aDate && $bDate) return strtotime($aDate) - strtotime($bDate);
  elseif ($aDate) return -1;
  elseif ($bDate) return 1;
  else return 0;
});
?>

<div class="section" id="project-events-section">
  <center><h1>Project Events</h1></center><br><br>

  <?php foreach ($projects as $index => $project): 
    $today = date('Y-m-d');

    // Get only future events to determine earliest date
    $futureEvents = array_filter($project['events'], fn($e) => $e['date'] >= $today);
    $earliestDate = !empty($futureEvents) ? min(array_column($futureEvents, 'date')) : '';
  ?>
    <div class="project-card" data-project-index="<?= $index ?>">
      <div class="project-header" onclick="toggleEvents('events-<?= $index ?>', <?= $index ?>)">
        <div>
          <h2><?= $project['id'] ?> <?= $earliestDate ? "<span class='date-pill'>{$earliestDate}</span>" : "" ?></h2>
          <p>Crop Type : <?= $project['crop'] ?></p>
          <p><?= $project['address'] ?></p>
        </div>
        <button class="add-event-btn" onclick="openModal(event, <?= $index ?>)">+ Add Event</button>
        <i class="fas fa-chevron-down toggle-icon" id="icon-<?= $index ?>"></i>
      </div>

      <div class="project-events" id="events-<?= $index ?>">
        <?php if (!empty($project['events'])): ?>
          <?php foreach ($project['events'] as $event): 
            $isPast = $event['date'] < $today;
          ?>
            <div class="event-card <?= $isPast ? 'past-event' : '' ?>">
              <h3><?= $event['name'] ?> <span class="event-date"><?= $event['date'] ?></span></h3>
              <p><i class="fas fa-clock"></i><?= $event['time'] ?></p>
              <p><i class="fas fa-map-pin"></i><?= $event['location'] ?></p>
              <p><i class="fas fa-users"></i> No of Workers : <?= $event['workers'] ?></p>
              <p><i class="fas fa-money-bill-wave"></i> Payment Per Worker : <?= $event['payment'] ?></p>
            </div>
          <?php endforeach; ?>
        <?php else: ?>
          <p class="no-events">No events scheduled yet.</p>
        <?php endif; ?>
      </div>
    </div>
  <?php endforeach; ?>
</div>

<!-- Modal -->
<div class="modal-overlay" id="modal-overlay">
  <div class="modal">
    <div class="modal-close" onclick="closeModal()">×</div>
    <h3>Add New Event</h3>
    <form id="event-form">
      <input type="text" id="event-name" placeholder="Event Name" required>
      <input type="date" id="event-date" required>
      <input type="text" id="event-time" placeholder="Select Time" required>
      <input type="text" id="event-location" placeholder="Location" required>
      <input type="number" id="event-workers" placeholder="No. of Workers" required>
      <input type="text" id="event-payment" placeholder="Payment per Worker" required>
      <button type="submit">Add Event</button>
    </form>
  </div>
</div>


<script>
  let selectedProjectIndex = null;

  function toggleEvents(id, index) {
    const section = document.getElementById(id);
    const icon = document.getElementById('icon-' + index);
    section.classList.toggle('active');
    icon.classList.toggle('rotate');
  }

  function openModal(e, index) {
    e.stopPropagation();
    selectedProjectIndex = index;
    document.getElementById('modal-overlay').style.display = 'flex';
  }

  function closeModal() {
    document.getElementById('modal-overlay').style.display = 'none';
    document.getElementById('event-form').reset();
  }

  document.getElementById('event-form').addEventListener('submit', function (e) {
    e.preventDefault();

    const name = document.getElementById('event-name').value;
    const date = document.getElementById('event-date').value;
    const time = document.getElementById('event-time').value;
    const location = document.getElementById('event-location').value;
    const workers = document.getElementById('event-workers').value;
    const payment = document.getElementById('event-payment').value;

    const eventCard = document.createElement('div');
    eventCard.className = 'event-card';
    eventCard.innerHTML = `
      <h3>${name} <span class="event-date">${date}</span></h3>
      <p><i class="fas fa-clock"></i>${time}</p>
      <p><i class="fas fa-map-pin"></i>${location}</p>
      <p><i class="fas fa-users"></i> Workers: ${workers}</p>
      <p><i class="fas fa-money-bill-wave"></i> Payment/Worker: ${payment}</p>
    `;

    const projectEvents = document.getElementById('events-' + selectedProjectIndex);
    const noEventsMsg = projectEvents.querySelector('.no-events');
    if (noEventsMsg) noEventsMsg.remove();
    projectEvents.appendChild(eventCard);

    closeModal();
  });
  flatpickr("#event-time", {
  enableTime: true,
  noCalendar: true,
  dateFormat: "h:i K", // e.g., 10:30 AM
  time_24hr: false
});

</script>
</body>
</html>
