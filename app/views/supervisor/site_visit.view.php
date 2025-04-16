<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Scheduled Site Visits</title>
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/assets/css/supervisor/sitevisit.css">
    <script src="<?php echo URLROOT; ?>/assets/js/sitevisit.js" defer></script>

</head>
<body>
    <div class="container">
        <h1>Scheduled Site Visits</h1>
        
        <table class="visits-table">
            <thead>
                <tr>
                    <th>Visit ID</th>
                    <th>Land ID</th>
                    <th>Scheduled Date & Time</th>
                   
                    <th>Action</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><span class="visit-id">SV-10023</span></td>
                    <td>LD-5678</td>
                    <td>April 18, 2025, 10:00 AM</td>
                    <td><span class="status-pill status-scheduled">Scheduled</span></td>
                    
                </tr>
                <?php if (!empty($visitdata)): ?>
					<?php foreach ($visitdata as $visit): ?>
						<tr data-land-id="<?= htmlspecialchars($visit->id) ?>">
							<td><?= htmlspecialchars($visit->id) ?></td>
							<td><?= htmlspecialchars($visit->land_id) ?></td>
							<td><?= htmlspecialchars($visit->date) ?> Sqm</td>
                            <td>
                        <button class="btn btn-reschedule" data-visit-id="SV-10023" data-land-id="LD-5678" onclick="openRescheduleModal(this)">Reschedule</button>
                    </td>
                            </tbody>
        </table>
        
        <!-- Reschedule Modal -->
        <div id="rescheduleModal" class="modal">
            <div class="modal-content">
                <div class="modal-header">
                    <h2 class="modal-title">Reschedule Site Visit</h2>
                    <span class="close" onclick="closeModal()">&times;</span>
                </div>
                <div id="modalBody">
                    <p>Visit ID: <span id="visitIdDisplay"></span></p>
                    <p>Land ID: <span id="landIdDisplay"></span></p>
                    
                    <div class="calendar">
                        <div class="calendar-header">
                            <button class="btn" onclick="prevMonth()">&lt;</button>
                            <h3 id="currentMonth">April 2025</h3>
                            <button class="btn" onclick="nextMonth()">&gt;</button>
                        </div>
                        
                        <div class="calendar-grid" id="weekdays">
                            <div class="calendar-weekday">Sun</div>
                            <div class="calendar-weekday">Mon</div>
                            <div class="calendar-weekday">Tue</div>
                            <div class="calendar-weekday">Wed</div>
                            <div class="calendar-weekday">Thu</div>
                            <div class="calendar-weekday">Fri</div>
                            <div class="calendar-weekday">Sat</div>
                        </div>
                        
                        <div class="calendar-grid" id="calendarDays">
                            <!-- Calendar days will be inserted here by JavaScript -->
                        </div>
                    </div>
                    
                    <div class="time-picker">
                        <div>
                            <label for="hourSelect">Hour:</label>
                            <select id="hourSelect">
                                <option value="9">9 AM</option>
                                <option value="10">10 AM</option>
                                <option value="11">11 AM</option>
                                <option value="12">12 PM</option>
                                <option value="13">1 PM</option>
                                <option value="14">2 PM</option>
                                <option value="15">3 PM</option>
                                <option value="16">4 PM</option>
                                <option value="17">5 PM</option>
                            </select>
                        </div>
                        <div>
                            <label for="minuteSelect">Minute:</label>
                            <select id="minuteSelect">
                                <option value="00">00</option>
                                <option value="15">15</option>
                                <option value="30">30</option>
                                <option value="45">45</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-cancel" onclick="closeModal()">Cancel</button>
                    <button class="btn btn-save" onclick="saveReschedule()">Save Changes</button>
                </div>
            </div>
        </div>
    </div>

  
</body>
</html>