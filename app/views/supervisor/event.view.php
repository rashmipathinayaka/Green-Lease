<?php
// Assuming this file is located at views/supervisor/event.view.php

$supervisorId = $_SESSION['user_id'];

require ROOT . '/views/supervisor/sidebar.php';
require ROOT . '/views/components/topbar.php';
?>

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
<div class="section" id="project-events-section">
  <center><h1>Events Allocated for the Zone</h1></center><br><br>

  <?php
  $projects = $data['projects'];
  $projectEvents = $data['projectEvents'];
  $today = $data['today'];

  foreach ($projects as $index => $project):
    $events = $projectEvents[$project->id] ?? [];

    // Find earliest upcoming event date
    $earliestDate = '';
    foreach ($events as $event) {
      if ($event->date >= $today) {
        $earliestDate = $event->date;
        break;
      }
    }
  ?>
    <div class="project-card" data-project-index="<?= $index ?>">
      <div class="project-header" onclick="toggleEvents('events-<?= $index ?>', <?= $index ?>)">
        <div>
          <h2><?= $project->id ?> <?= $earliestDate ? "<span class='date-pill'>{$earliestDate}</span>" : "" ?></h2>
          <p><?= $project->address ?></p>
          <p>Crop Type: <?= $project->crop_type ?></p>
        </div>
        <button class="add-event-btn" onclick="openModal(event, '<?= $project->id ?>')">+ Add Event</button>
        <i class="fas fa-chevron-down toggle-icon" id="icon-<?= $index ?>"></i>
      </div>

      <div class="project-events" id="events-<?= $index ?>">
        <?php if (!empty($events)): ?>
          <?php foreach ($events as $event): 
            $isPast = $event->date < $today;
          ?>
            <div class="event-card <?= $isPast ? 'past-event' : '' ?>">
              <h3><?= $event->event_name ?> <span class="event-date"><?= $event->date ?></span></h3>
              <p><i class="fas fa-clock"></i> <?= date('h:i A', strtotime($event->time)) ?></p>
              <p><i class="fas fa-map-pin"></i> <?= $event->location ?></p>
              <p><i class="fas fa-users"></i> No of Workers: <?= $event->workers_required ?></p>
              <p><i class="fas fa-money-bill-wave"></i> Payment Per Worker: Rs. <?= $event->payment_per_worker ?></p>
            </div>
          <?php endforeach; ?>
        <?php else: ?>
          <p class="no-events">No events scheduled yet.</p>
        <?php endif; ?>
      </div>
    </div>
  <?php endforeach; ?>

  <?php if (empty($projects)): ?>
    <div class="no-projects">
      <p>No projects assigned to you yet.</p>
    </div>
  <?php endif; ?>
</div>

<!-- Modal -->
<div class="modal-overlay" id="modal-overlay">
  <div class="modal">
    <div class="modal-close" onclick="closeModal()">×</div>
    <h3>Add New Event</h3>
    <form id="event-form" action="<?php echo URLROOT; ?>/supervisors/addEvent" method="POST">
      <input type="hidden" id="project-id" name="project_id">
      <input type="text" id="event-name" name="event_name" placeholder="Event Name" required>
      <input type="date" id="event-date" name="date" min="<?= date('Y-m-d') ?>" required>
      <input type="text" id="event-time" name="time" placeholder="Select Time" required>
      <input type="text" id="event-location" name="location" placeholder="Location" required>
      <input type="number" id="event-workers" name="workers_required" placeholder="No. of Workers" required>
      <input type="text" id="event-payment" name="payment_per_worker" placeholder="Payment per Worker" required>

      <div class="duration-inputs">
        <label>Duration:</label>
        <div class="duration-group">
          <input type="number" id="duration-years" name="duration_years" placeholder="Years" min="0" value="0">
          <input type="number" id="duration-months" name="duration_months" placeholder="Months" min="0" value="0">
          <input type="number" id="duration-days" name="duration_days" placeholder="Days" min="0" value="0">
          <input type="number" id="duration-hours" name="duration_hours" placeholder="Hours" min="0" value="0">
        </div>
      </div>

      <button type="submit">Add Event</button>
    </form>
  </div>
</div>

<script>
let selectedProjectId = null;

function toggleEvents(id, index) {
  const section = document.getElementById(id);
  const icon = document.getElementById('icon-' + index);
  section.classList.toggle('active');
  icon.classList.toggle('rotate');
}

function openModal(e, projectId) {
  e.stopPropagation();
  selectedProjectId = projectId;
  document.getElementById('project-id').value = projectId;
  document.getElementById('modal-overlay').style.display = 'flex';
}

function closeModal() {
  document.getElementById('modal-overlay').style.display = 'none';
  document.getElementById('event-form').reset();
}

// Form validation
document.getElementById('event-form').addEventListener('submit', function (e) {
  const dateInput = document.getElementById('event-date').value;
  const todayStr = new Date().toISOString().split('T')[0];
  const today = new Date(todayStr);
  const inputDate = new Date(dateInput);

  if (inputDate < today) {
    e.preventDefault();
    alert("Event date cannot be in the past.");
    return false;
  }
});

flatpickr("#event-time", {
  enableTime: true,
  noCalendar: true,
  dateFormat: "H:i",
  time_24hr: false,
  altInput: true,
  altFormat: "h:i K"
});
</script>
</body>
</html>
