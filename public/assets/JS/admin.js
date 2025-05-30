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

function switchTabs(clickedBtn, tabId) {
  // Remove active class from all tab buttons
  document.querySelectorAll('.tab-btn').forEach(btn => {
      btn.classList.remove('active');
  });
  
  // Add active class to clicked button
  clickedBtn.classList.add('active');
  
  // Hide all tab contents
  document.querySelectorAll('.tab-content').forEach(content => {
      content.classList.remove('active');
  });
  
  // Show the selected tab content
  document.getElementById(tabId).classList.add('active');
}




function showSection(sectionId) {
  // Hide all sections
  const sections = document.querySelectorAll(".section");
  sections.forEach((section) => {
    section.style.display = "none";
  });

  // Show the selected section
  const selectedSection = document.getElementById(sectionId);
  if (selectedSection) {
    selectedSection.style.addClassName = "active";
    selectedSection.style.display = "block";
  }
}

// Placeholder for accept/reject buttons
document.addEventListener("DOMContentLoaded", () => {
  // Show the dashboard section by default
  showSection("dashboard-section");

  // Add event listeners to accept buttons
  document.querySelectorAll(".green-btn").forEach((button) => {
    button.addEventListener("click", () => {
      // Placeholder action for accepting an order
      console.log("Green Button Clicked!");
      // Need to Implement Acceptance Logic :)
    });
  });

  // Add event listeners to reject buttons
  document.querySelectorAll(".red-btn").forEach((button) => {
    button.addEventListener("click", () => {
      // Placeholder action for rejecting an order
      console.log("Red Button Clicked!");
      // Need to Implement Rejection Logic :)
    });
  });

  // New functions for top bar interactions
  document
    .querySelector(".notification-btn")
    .addEventListener("click", function () {
      alert("Notifications clicked!");
      // Need to Implement Notification Logic :)
    });

  // document.querySelector(".profile-btn").addEventListener("click", function () {
  //   alert("Profile clicked!");
  //   // Need to Implement Profile Logic :)
  // });
});

// Modal handling for adding supervisor

  // Show popup when button is clicked
  document.getElementById('add-supervisor-btn').addEventListener('click', function () {
    document.getElementById('add-supervisor-form').style.display = 'block';
  });

  // Handle form submission
  document.getElementById('supervisorForm').addEventListener('submit', function (e) {
    e.preventDefault(); // prevent page reload

    const formData = new FormData(this);

    fetch('/Admin/Manage_supervisor/add_supervisor', {
      method: 'POST',
      body: formData
    })
    .then(response => response.text()) // or .json() depending on your controller response
    .then(data => {
      alert('Supervisor added successfully!');
      // optionally hide form or refresh data
      document.getElementById('popupForm').style.display = 'none';
    })
    .catch(error => console.error('Error:', error));
  });


document.querySelectorAll(".edit-btn").forEach((button) => {
  button.addEventListener("click", (event) => {
    const supervisorId = event.target.getAttribute("data-id");
    // Fetch the current details for the selected supervisor
    const row = document.querySelector(`tr[data-id='${supervisorId}']`);
    const name = row.children[0].textContent;
    const email = row.children[1].textContent;
    const phone = row.children[2].textContent;
    const zone = row.children[3].textContent;
    const status = row.children[4].textContent;

    // Fill the form with current details
    document.getElementById("edit-name").value = name;
    document.getElementById("edit-email").value = email;
    document.getElementById("edit-phone").value = phone;
    document.getElementById("edit-zone").value = zone;
    document.getElementById("edit-status").value = status;

    // Store the ID of the supervisor being edited
    document.getElementById("edit-supervisor-id").value = supervisorId;

    // Show the edit form modal
    document.getElementById("edit-supervisor-form").style.display = "block";
  });
});

document.addEventListener("DOMContentLoaded", () => {
  document.querySelectorAll(".edit-btn").forEach((button) => {
    button.addEventListener("click", (event) => {
      const supervisorId = event.target.getAttribute("data-id");
      // Fetch the current details for the selected supervisor
      const row = document.querySelector(`tr[data-id='${supervisorId}']`);
      const name = row.children[0].textContent;
      const email = row.children[1].textContent;
      const phone = row.children[2].textContent;
      const zone = row.children[3].textContent;
      const status = row.children[4].textContent;

      // Fill the form with current details
      document.getElementById("edit-name").value = name;
      document.getElementById("edit-email").value = email;
      document.getElementById("edit-phone").value = phone;
      document.getElementById("edit-zone").value = zone;
      document.getElementById("edit-status").value = status;

      // Store the ID of the supervisor being edited
      document.getElementById("edit-supervisor-id").value = supervisorId;

      // Show the edit form modal
      document.getElementById("edit-supervisor-form").style.display = "block";
    });
  });

  // Handle Edit Form Submission
  const editSupervisorForm = document.getElementById("edit-supervisor-form");
  editSupervisorForm.addEventListener("submit", (event) => {
    event.preventDefault();

    // Get the supervisor ID
    const supervisorId = document.getElementById("edit-supervisor-id").value;

    // Get the updated details from the form
    const name = document.getElementById("edit-name").value;
    const email = document.getElementById("edit-email").value;
    const phone = document.getElementById("edit-phone").value;
    const zone = document.getElementById("edit-zone").value;
    const status = document.getElementById("edit-status").value;

    const row = document.querySelector(`tr[data-id='${supervisorId}']`);
    row.children[0].textContent = name;
    row.children[1].textContent = email;
    row.children[2].textContent = phone;
    row.children[3].textContent = zone;
    row.children[4].textContent = status;

    editSupervisorForm.style.display = "none";

    editSupervisorForm.reset();
  });

  // // Handle closing the edit form modal
  // document.querySelector(".close-edit-form").addEventListener("click", () => {
  //   document.getElementById("edit-supervisor-form").style.display = "none";
  // });
  document
    .querySelector("#edit-supervisor-form .close-form")
    .addEventListener("click", () => {
      document.getElementById("edit-supervisor-form").style.display = "none";
    });
});

function switchTab(tabName) {
  // Hide all fertilizer tab contents
  document.querySelectorAll('#inquiries-section .tab-content').forEach(content => {
    content.style.display = 'none';
  });

  // Remove active class from all tab buttons
  document.querySelectorAll('#inquiries-section .tab-btn').forEach(btn => {
    btn.classList.remove('active');
  });

  // Show selected tab content
  document.getElementById(tabName).style.display = 'block';
  event.currentTarget.classList.add('active');
}










