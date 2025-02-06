function showSection(sectionId) {
  // Hide all sections
  const sections = document.querySelectorAll(".section");
  sections.forEach((section) => {
    section.style.display = "none";
  });

  // Show the selected section
  const selectedSection = document.getElementById(sectionId);
  if (selectedSection) {
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
const addSupervisorBtn = document.getElementById("add-supervisor-btn");
const addSupervisorForm = document.getElementById("add-supervisor-form");
const closeFormBtn = document.querySelector(".close-form");

addSupervisorBtn.addEventListener("click", () => {
  addSupervisorForm.style.display = "block";
});

closeFormBtn.addEventListener("click", () => {
  addSupervisorForm.style.display = "none";
});

const supervisorForm = document.getElementById("new-supervisor-form");
supervisorForm.addEventListener("submit", (event) => {
  event.preventDefault(); // Prevent the default form submission behavior

  // Extract form data
  const name = document.getElementById("name").value;
  const email = document.getElementById("email").value;
  const phone = document.getElementById("phone").value;
  const zone = document.getElementById("zone").value;
  const status = document.getElementById("status").value;

  // Add new supervisor to the list
  // const supervisorList = document.getElementById("supervisor-list");
  // const newRow = document.createElement("tr");
  // newRow.innerHTML = `
  //     <td>${name}</td>
  //     <td>${email}</td>
  //     <td>${phone}</td>
  //     <td>${zone}</td>
  //     <td>${status}</td>
  //     <td>
  //       <button class="green-btn">Edit</button>
  //       <button class="red-btn">Deactivate</button>
  //     </td>
  //   `;
  // supervisorList.appendChild(newRow);

  console.log("Name : " + name);
  console.log("Email : " + email);
  console.log("Phone : " + phone);
  console.log("Zone : " + zone);
  console.log("Status : " + status);

  // Hide the form
  addSupervisorForm.style.display = "none";

  // Clear the form fields
  supervisorForm.reset();
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
