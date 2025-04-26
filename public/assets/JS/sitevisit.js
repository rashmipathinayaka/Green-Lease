function showRescheduleForm(visitId, landAddress, fromDate, toDate) {
    document.getElementById('rescheduleForm').style.display = 'block';
    document.getElementById('formVisitId').value = visitId;
    document.getElementById('formLandId').value = visitId; // or another land ID if needed
    document.getElementById('displayVisitId').textContent = visitId;
    document.getElementById('displayLandAddress').textContent = landAddress;
    document.getElementById('newDate').setAttribute('min', fromDate);
    document.getElementById('newDate').setAttribute('max', toDate);
    
    // Set fromDate and toDate into hidden fields
    document.getElementById('fromDate').value = fromDate;
    document.getElementById('toDate').value = toDate;
}



function hideRescheduleForm() {
    // Hide the form
    document.getElementById('rescheduleForm').style.display = 'none';
}

// Set today's date as minimum for the date input
window.addEventListener('DOMContentLoaded', () => {
    const today = new Date().toISOString().split('T')[0];
    const newDateInput = document.getElementById('newDate');
    if (newDateInput) {
        newDateInput.min = today;
    }
});

document.addEventListener('DOMContentLoaded', function() {
    const tabButtons = document.querySelectorAll('.tab-btn');
    const tabContents = document.querySelectorAll('.tab-content');
    
    // Set first tab as active if none are active
    if (!document.querySelector('.tab-btn.active')) {
        tabButtons[0]?.classList.add('active');
        tabContents[0]?.classList.add('active');
    }
    
    // Add click handlers
    tabButtons.forEach(button => {
        button.addEventListener('click', function() {
            const targetId = this.getAttribute('data-tab-target');
            
            // Remove active class from all buttons and contents
            tabButtons.forEach(btn => btn.classList.remove('active'));
            tabContents.forEach(content => content.classList.remove('active'));
            
            // Add active class to clicked button and target content
            this.classList.add('active');
            document.getElementById(targetId).classList.add('active');
        });
    });
  });