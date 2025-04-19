/// Select tab buttons and tab content sections
const solvedIssuesTabBtn = document.getElementById("solved-issues-btn"); // Button for switching to Solved Issues tab
const solvedIssuesTabContent = document.getElementById("solved-issues"); // Solved Issues tab content
const RequestHistoryTabBtn = document.getElementById("request-history-btn"); // Button for switching to request history tab
const RequestHistoryTabContent = document.getElementById("request-history");
const stockManagementBtn = document.getElementById("stock-management-btn"); // Button for switching to stock management tab
const stockManagementTabContent = document.getElementById("stock-management");
// Function to switch between Pending and Solved tabs

function switchTabs(clickedBtn, tabId) {
  // Remove 'active' class from all tab buttons
  document
    .querySelectorAll(".tab-btn")
    .forEach((btn) => btn.classList.remove("active"));

  // Hide all tab contents
  document
    .querySelectorAll(".tab-content")
    .forEach((tab) => (tab.style.display = "none"));

  // Show the selected tab
  const selectedTab = document.getElementById(tabId);
  if (selectedTab) selectedTab.style.display = "block";

  // Add 'active' class to clicked button
  clickedBtn.classList.add("active");
}

function confirmMarkAsSolved(issueId) {
  const confirmation = confirm(
    "Are you sure you want to mark this issue as solved?"
  );
  if (confirmation) {
    window.location.href = `${URLROOT}/Supervisor/ManageIssues/markAsSolved/${issueId}`;
  }
}

function confirmRemoveIssue(issueId) {
  const confirmation = confirm(
    "Are you sure you want to permanently remove this issue?"
  );
  if (confirmation) {
    window.location.href = `${URLROOT}/Supervisor/ManageIssues/deleteIssue/${issueId}`;
  }
}

function confirmApproveRequest(requestId) {
  const confirmation = confirm(
    "Are you sure you want to approve this fertilizer request?"
  );
  if (confirmation) {
    window.location.href = `${URLROOT}/Supervisor/Manage_fertilizer/markAsAccept/${requestId}?success=accepted`;
  }
}

function confirmRejectRequest(requestId) {
  const confirmation = confirm(
    "Are you sure you want to reject this fertilizer request?"
  );
  if (confirmation) {
    window.location.href = `${URLROOT}/Supervisor/Manage_fertilizer/rejectRequest/${requestId}?success=rejected`;
  }
}

function searchFertilizerById() {
  const inputId = document.getElementById("fertilizer-search-id").value.trim();
  const rows = document.querySelectorAll(
    "#stock-management .dashboard-table tbody tr"
  );

  rows.forEach((row) => {
    const restockBtn = row.querySelector("button.blue-btn");
    if (restockBtn) {
      const fertilizerId = restockBtn.getAttribute("onclick").match(/\d+/)[0]; // Get ID from function call
      if (inputId === fertilizerId) {
        row.style.display = ""; // Show match
      } else {
        row.style.display = "none"; // Hide non-match
      }
    }
  });
}

function clearFertilizerSearch() {
  document.getElementById("fertilizer-search-id").value = "";
  const rows = document.querySelectorAll(
    "#stock-management .dashboard-table tbody tr"
  );
  rows.forEach((row) => (row.style.display = "")); // Reset table
}
