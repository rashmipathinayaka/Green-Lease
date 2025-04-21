<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Project Events</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <link rel="stylesheet" href="<?php echo URLROOT; ?>/assets/CSS/supervisor/event.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
  <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
</head>

<body>
<?php
require ROOT . '/views/supervisor/sidebar.php';
require ROOT . '/views/components/topbar.php';

// Sample Data
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
      ['name' => 'Weeding', 'date' => '2025-04-25', 'time' => '12:30 AM', 'location' => 'Marine Avenue', 'workers' => 10, 'payment' => 'Rs. 1100']
    ]
  ]
];

// Sort projects by earliest upcoming event date
usort($projects, function($a, $b) {
  $aDate = '';
  $bDate = '';
  $today = date('Y-m-d');

  if (!empty($a['events'])) {
    $upcomingA = array_filter($a['events'], fn($e) => $e['date'] >= $today);
    if (!empty($upcomingA)) $aDate = min(array_column($upcomingA, 'date'));
  }

  if (!empty($b['events'])) {
    $upcomingB = array_filter($b['events'], fn($e) => $e['date'] >= $today);
    if (!empty($upcomingB)) $bDate = min(array_column($upcomingB, 'date'));
  }

  if ($aDate && $bDate) return strtotime($aDate) - strtotime($bDate);
  elseif ($aDate) return -1;
  elseif ($bDate) return 1;
  else return 0;
});
?>

<div class="section" id="project-events-section">
  <center><h1>Events Allocated for the Zone</h1></center><br><br>

  <?php foreach ($projects as $index => $project): 
    $today = date('Y-m-d');
    $futureEvents = array_filter($project['events'], fn($e) => $e['date'] >= $today);
    $earliestDate = !empty($futureEvents) ? min(array_column($futureEvents, 'date')) : '';
  ?>
    <div class="project-card" data-project-index="<?= $index ?>">
      <div class="project-header" onclick="toggleEvents('events-<?= $index ?>', <?= $index ?>)">
        <div>
          <h2><?= $project['id'] ?> <?= $earliestDate ? "<span class='date-pill'>{$earliestDate}</span>" : "" ?></h2>
          <p><?= $project['address'] ?></p>
          <p>Crop Type : <?= $project['crop'] ?></p>
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
      <input type="date" id="event-date" min="<?= date('Y-m-d') ?>" required>
      <input type="text" id="event-time" placeholder="Select Time" required>
      <input type="text" id="event-location" placeholder="Location" required>
      <input type="number" id="event-workers" placeholder="No. of Workers" required>
      <input type="text" id="event-payment" placeholder="Payment per Worker" required>

      <div class="duration-inputs">
        <label>Duration:</label>
        <div class="duration-group">
          <input type="number" id="duration-years" placeholder="Years" min="0">
          <input type="number" id="duration-months" placeholder="Months" min="0">
          <input type="number" id="duration-days" placeholder="Days" min="0">
          <input type="number" id="duration-hours" placeholder="Hours" min="0">
        </div>
      </div>

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

  const dateInput = document.getElementById('event-date').value;
  const todayStr = new Date().toISOString().split('T')[0];
  const today = new Date(todayStr);
  const inputDate = new Date(dateInput);

  if (inputDate < today) {
    alert("Event date cannot be in the past.");
    return;
  }

  // Form values
  const name = document.getElementById('event-name').value;
  const time = document.getElementById('event-time').value;
  const location = document.getElementById('event-location').value;
  const workers = document.getElementById('event-workers').value;
  const payment = document.getElementById('event-payment').value;

  const newEvent = { name, date: dateInput, time, location, workers, payment };

  const eventCard = document.createElement('div');
  eventCard.className = 'event-card';
  eventCard.innerHTML = `
    <h3>${newEvent.name} <span class="event-date">${newEvent.date}</span></h3>
    <p><i class="fas fa-clock"></i> ${newEvent.time}</p>
    <p><i class="fas fa-map-pin"></i> ${newEvent.location}</p>
    <p><i class="fas fa-users"></i> Workers: ${newEvent.workers}</p>
    <p><i class="fas fa-money-bill-wave"></i> Payment/Worker: ${newEvent.payment}</p>
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
  dateFormat: "h:i K",
  time_24hr: false
});
</script>
</body>
</html>
