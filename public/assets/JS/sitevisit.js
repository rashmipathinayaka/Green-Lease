let currentVisitId = "";
let currentLandId = "";
let selectedDate = null;
let currentDate = new Date();

// Initialize calendar
function initCalendar() {
    renderCalendar(currentDate);
}

// Render calendar days
function renderCalendar(date) {
    const calendarDays = document.getElementById('calendarDays');
    calendarDays.innerHTML = '';
    
    const month = date.getMonth();
    const year = date.getFullYear();
    
    document.getElementById('currentMonth').textContent = `${getMonthName(month)} ${year}`;
    
    const firstDay = new Date(year, month, 1);
    const lastDay = new Date(year, month + 1, 0);
    
    // Add empty days for the start of the month
    for (let i = 0; i < firstDay.getDay(); i++) {
        const emptyDay = document.createElement('div');
        emptyDay.className = 'calendar-day disabled';
        calendarDays.appendChild(emptyDay);
    }
    
    // Add actual days
    for (let i = 1; i <= lastDay.getDate(); i++) {
        const day = document.createElement('div');
        day.className = 'calendar-day';
        day.textContent = i;
        
        const currentDayDate = new Date(year, month, i);
        // Disable past dates
        if (currentDayDate < new Date()) {
            day.classList.add('disabled');
        } else {
            day.addEventListener('click', function() {
                // Remove selected class from all days
                document.querySelectorAll('.calendar-day').forEach(d => {
                    d.classList.remove('selected');
                });
                
                // Add selected class to clicked day
                this.classList.add('selected');
                selectedDate = new Date(year, month, i);
            });
        }
        
        calendarDays.appendChild(day);
    }
}

// Helper functions
function getMonthName(monthIndex) {
    const months = ['January', 'February', 'March', 'April', 'May', 'June', 
                   'July', 'August', 'September', 'October', 'November', 'December'];
    return months[monthIndex];
}

function prevMonth() {
    currentDate.setMonth(currentDate.getMonth() - 1);
    renderCalendar(currentDate);
}

function nextMonth() {
    currentDate.setMonth(currentDate.getMonth() + 1);
    renderCalendar(currentDate);
}

// Modal functions
function openRescheduleModal(button) {
    currentVisitId = button.getAttribute('data-visit-id');
    currentLandId = button.getAttribute('data-land-id');
    
    document.getElementById('visitIdDisplay').textContent = currentVisitId;
    document.getElementById('landIdDisplay').textContent = currentLandId;
    
    // Reset selected date
    selectedDate = null;
    
    // Reset current date to today
    currentDate = new Date();
    
    // Initialize calendar
    initCalendar();
    
    document.getElementById('rescheduleModal').style.display = 'flex';
}

function closeModal() {
    document.getElementById('rescheduleModal').style.display = 'none';
}

function saveReschedule() {
    if (!selectedDate) {
        alert('Please select a date first');
        return;
    }
    
    const hour = document.getElementById('hourSelect').value;
    const minute = document.getElementById('minuteSelect').value;
    
    // Set the time to the selected date
    selectedDate.setHours(hour, minute, 0, 0);
    
    // Format the date for display
    const formattedDate = formatDate(selectedDate);
    
    // In a real application, you would send this data to the server
    // For this example, we'll just update the UI
    const rows = document.querySelectorAll('.visits-table tbody tr');
    rows.forEach(row => {
        const visitIdCell = row.querySelector('.visit-id');
        if (visitIdCell && visitIdCell.textContent === currentVisitId) {
            // Update the date cell
            row.cells[2].textContent = formattedDate;
        }
    });
    
    alert(`Site visit ${currentVisitId} rescheduled to ${formattedDate}`);
    closeModal();
}

function formatDate(date) {
    const options = { 
        year: 'numeric', 
        month: 'long', 
        day: 'numeric',
        hour: 'numeric', 
        minute: '2-digit'
    };
    return date.toLocaleDateString('en-US', options);
}

// Close modal if user clicks outside of it
window.onclick = function(event) {
    const modal = document.getElementById('rescheduleModal');
    if (event.target === modal) {
        closeModal();
    }
};

// Initialize calendar when page loads
window.onload = function() {
    initCalendar();
};