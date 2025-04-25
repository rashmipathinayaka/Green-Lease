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
    "Are you sure you want to proceed to process this fertilizer request?"
  );
  if (confirmation) {
    window.location.href = `${URLROOT}/Supervisor/Manage_fertilizer/approveRequest/${requestId}`;
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

function searchFertilizerByName() {
  const searchTerm = document
    .getElementById("fertilizer-search-id")
    .value.trim()
    .toLowerCase();
  const rows = document.querySelectorAll(
    "#stock-management .dashboard-table tbody tr"
  );

  const fertilizerAliases = {
    urea: ["urea"],
    dap: ["dap", "diammonium phosphate"],
    npk: ["npk"],
    tsp: ["tsp", "triple super phosphate"],
    "ammonium sulphate": ["ammonium sulphate", "ammonium sulfate"],
    compost: ["compost"],
    nitrogen: ["nitrogen"],
    dolomite: ["dolomite"],
    "cow dung": ["cow dung", "dried cow dung manure", "cow manure"],
    "goat dung": ["goat dung", "dried goat dung manure", "goat manure"],
  };

  let anyMatch = false; // ✅ Added declaration here

  rows.forEach((row) => {
    const fertilizerCell = row.querySelector("td:first-child");
    if (fertilizerCell) {
      const fertilizerName = fertilizerCell.textContent.toLowerCase();
      let shouldShow = false;

      if (fertilizerName.includes(searchTerm)) {
        shouldShow = true;
      } else {
        for (const [baseName, aliases] of Object.entries(fertilizerAliases)) {
          const aliasMatch = aliases.some((alias) =>
            alias.includes(searchTerm)
          );
          const baseNameMatch = fertilizerName.includes(baseName);

          if (aliasMatch && baseNameMatch) {
            shouldShow = true;
            break;
          }
        }
      }

      row.style.display = shouldShow ? "" : "none";
      if (shouldShow) anyMatch = true;
    }
  });

  document.getElementById("no-results-msg").style.display = anyMatch
    ? "none"
    : "block";
}

function clearFertilizerSearch() {
  document.getElementById("fertilizer-search-id").value = "";
  const rows = document.querySelectorAll(
    "#stock-management .dashboard-table tbody tr"
  );
  rows.forEach((row) => (row.style.display = "")); // Reset table
  document.getElementById("no-results-msg").style.display = "none";
}
