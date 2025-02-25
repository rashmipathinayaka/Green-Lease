// Get the button and the form elements for Add Supervisor
const addSupervisorBtn = document.getElementById("solved-issues-btn"); // Button to open the form
const addSupervisorForm = document.getElementById("solved-issues"); // The form itself
const closeFormBtn = document.querySelector(".close-form"); // Button to close the form

// Open the form when the 'Add Supervisor' button is clicked
addSupervisorBtn.addEventListener("click", () => {
  addSupervisorForm.style.display = "block"; // Show the form
});

function switchTabs(tabId) {
  // Remove 'active' class from all tab buttons
  const allTabButtons = document.querySelectorAll(".tab-btn");
  allTabButtons.forEach((button) => button.classList.remove("active"));

  // Hide all tab contents
  const allTabContents = document.querySelectorAll(".tab-content");
  allTabContents.forEach((tab) => (tab.style.display = "none"));

  // Show the selected tab and mark its button as active
  document.getElementById(tabId).style.display = "block";
  document
    .querySelector(`[onclick="switchTabs('${tabId}')"]`)
    .classList.add("active");
}
