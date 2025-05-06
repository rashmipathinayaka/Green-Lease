<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Events for Project <?= htmlspecialchars($project_id) ?></title>
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/assets/CSS/supervisor/event.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    <style>
        body {
            padding: 40px;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f5f7fa;
        }
        .container {
            max-width: 900px;
            margin: auto;
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 6px rgba(0,0,0,0.1);
            align-items: center;
        }
        h1 {
            color: #2e7d32;
            margin-bottom: 20px;
        }
        .btn-add-event {
            background-color: #2e7d32;
            color: white;
            border: none;
            padding: 10px 16px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 14px;
            margin-bottom: 20px;
            display: inline-flex;
            align-items: center;
        }
        .btn-add-event i {
            margin-right: 8px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 40px;
        }
        th, td {
            padding: 12px 15px;
            border: 1px solid #ddd;
            text-align:center;
        }
        th {
            background-color: #2e7d32;
            color: white;
        }
        .error {
            color: red;
            margin-bottom: 15px;
        }
        /* Modal styles */
        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0; top: 0;
            width: 100%; height: 100%;
            overflow: auto;
            background-color: rgba(0,0,0,0.5);
        }
        .modal-content {
            background-color: #fff;
            margin: 10% auto;
            padding: 20px;
            border-radius: 8px;
            width: 400px;
            position: relative;
        }
        .close-btn {
            position: absolute;
            right: 15px;
            top: 10px;
            font-size: 22px;
            font-weight: bold;
            cursor: pointer;
            color: #aaa;
        }
        .close-btn:hover {
            color: #000;
        }
        label {
            display: block;
            margin-top: 12px;
            font-weight: 600;
        }
        input[type="text"], input[type="date"], textarea {
            width: 100%;
            padding: 8px 10px;
            margin-top: 6px;
            border: 1px solid #ccc;
            border-radius: 4px;
            resize: vertical;
        }
        button.submit-btn {
            margin-top: 20px;
            background-color: #2e7d32;
            color: white;
            border: none;
            padding: 10px 16px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 14px;
        }
        button.submit-btn:hover {
            background-color: #1b5e20;
        }
        .postponed-badge {
    display: inline-block;
    background-color: #e67e22;
    color: white;
    font-size: 0.8em;
    padding: 2px 6px;
    border-radius: 3px;
    margin-left: 5px;
    cursor: help;
}


        
    </style>
</head>
<body>

<div class="container">
    <h1>Events for Project ID: <?= htmlspecialchars($project_id) ?></h1>

    <?php if (!empty($errors)) : ?>
        <div class="error">
            <?php foreach ($errors as $error) : ?>
                <p><?= htmlspecialchars($error) ?></p>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
<br>
    <button class="btn-add-event" id="openModalBtn"><i class="fas fa-plus"></i> Add Event</button>

    <table>
        <thead>
            <tr>
                <th>Event Name</th>
                <th>Assigned Date</th>
                <th>New Date</th>
                <th>Time</th>
                <th>Workers Required</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($events)) : ?>
                <?php foreach ($events as $event) : ?>
                    <tr>
                        <td><?= htmlspecialchars($event->event_name) ?></td>
                        <td><?= htmlspecialchars($event->date) ?></td>
                        <td>
    <?php 
    // Check if display_date is set, otherwise use date or postponed_date
    $displayDate = $event->display_date ?? ($event->postponed_date ?? $event->date);
    $isPostponed = $event->is_postponed ?? (!empty($event->postponed_date));
    ?>
    
    <?= htmlspecialchars($displayDate ?? '') ?>
    
    <?php if ($isPostponed): ?>
        <span class="postponed-badge" title="Originally scheduled for <?= htmlspecialchars($event->date ?? '') ?>">
            (Postponed)
        </span>
    <?php endif; ?>
</td>

<td><?= htmlspecialchars($event->time) ?></td>
                        <td><?= htmlspecialchars($event->workers_required) ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php else : ?>
                <tr><td colspan="5" style="text-align:center;">No Events found for this project.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<!-- Add Event Modal -->
<div id="addEventModal" class="modal">
    <div class="modal-content">
        <span class="close-btn" id="closeModalBtn">&times;</span>
        <h2>Add New Event</h2>
        <form action="<?= URLROOT ?>/Supervisor/Event/addEvent" method="POST">
            <input type="hidden" name="project_id" value="<?= htmlspecialchars($project_id) ?>" />
            <label for="event_name">Event Name <span style="color:red;">*</span></label>
            <input type="text" id="event_name" name="event_name" value="<?= htmlspecialchars($form_data['event_name'] ?? '') ?>" required />

            <label for="date">Event Date <span style="color:red;">*</span></label>
            <input type="date" id="date" name="date" 
             min="<?= date('Y-m-d') ?>" 
             value="<?= htmlspecialchars($form_data['date'] ?? '') ?>" 
             required />


            <label for="event_time">Event Time <span style="color:red;">*</span></label>
           <input type="time" id="event_time" name="time" value="<?= htmlspecialchars($form_data['time'] ?? '') ?>" required />

          
           <label for="workers_required">Workers Required</label>
           <input type="number" id="workers_required" name="workers_required" min="0" value="<?= htmlspecialchars($form_data['workers_required'] ?? '0') ?>" />

           <label for="payment_per_worker">Payment per Worker (LKR)</label>
<div class="input-group">
    <input type="number" id="payment_per_worker" name="payment_per_worker" 
           min="0" step="1" 
           value="<?= htmlspecialchars($form_data['payment_per_worker'] ?? '0') ?>" 
           oninput="this.value = Math.floor(this.value);" />
</div>
           
         <label for="description">Description</label>
            <textarea id="description" name="description" rows="3"><?= htmlspecialchars($form_data['description'] ?? '') ?></textarea>

            
            <button type="submit" class="submit-btn">Add Event</button>
        </form>
    </div>
</div>

<script>
    const modal = document.getElementById('addEventModal');
    const openBtn = document.getElementById('openModalBtn');
    const closeBtn = document.getElementById('closeModalBtn');

    openBtn.onclick = function() {
        modal.style.display = 'block';
    }

    closeBtn.onclick = function() {
        modal.style.display = 'none';
    }

    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = 'none';
        }
    }
</script>

</body>
</html>
