// Get the button and the form elements for Add sitehead
const addsiteheadBtn = document.getElementById("add-sitehead-btn"); // Button to open the form
const addsiteheadForm = document.getElementById("add-sitehead-form"); // The form itself
const closeFormBtn = document.querySelector(".close-form"); // Button to close the form

// Open the form when the 'Add sitehead' button is clicked
addsiteheadBtn.addEventListener("click", () => {
  addsiteheadForm.style.display = "block"; // Show the form
});

// Close the form when the close button (×) is clicked
closeFormBtn.addEventListener("click", () => {
  addsiteheadForm.style.display = "none"; // Hide the form when the close button is clicked
});



// const addvisitBtn = document.getElementById("add-visit-btn"); // Button to open the form
// const addvisitForm = document.getElementById("add-visit-form"); // The form itself
// const closeFormBtn1 = document.querySelector(".close-form"); // Button to close the form

// // Open the form when the 'Add sitehead' button is clicked
// addvisitBtn.addEventListener("click", () => {
//   addvisitForm.style.display = "block"; // Show the form
// });

// // Close the form when the close button (×) is clicked
// closeFormBtn1.addEventListener("click", () => {
//   addvisitForm.style.display = "none"; // Hide the form when the close button is clicked
// });





 //Close the form when the close button (×) is clicked
 const closeFormBtn2 = document.querySelector("#edit-sitehead-form .close-form");
  closeFormBtn2.addEventListener("click", () => {
    editsiteheadForm.style.display = "none"; // Hide the form
 });


const siteheadTable = document.querySelector("#sitehead-list"); // Table containing the siteheads
const editsiteheadForm = document.getElementById("edit-sitehead-form"); // Edit form

siteheadTable.addEventListener("click", function(e) {
    if (e.target && e.target.classList.contains("edit-sitehead-btn")) {
        // Get the sitehead ID from the closest row's data-id
        const siteheadRow = e.target.closest("tr");
        const siteheadId = siteheadRow.getAttribute("data-id");

        // Set the form action dynamically based on the sitehead ID
        const formAction = "<?php echo URLROOT; ?>/Supervisor/manage_sitehead/update_sitehead/" + siteheadId;
        editsiteheadForm.setAttribute("action", formAction);  // Set dynamic action

        // Pre-fill the form with the selected sitehead's data
        const siteheadName = siteheadRow.querySelector("td:nth-child(1)").textContent.trim();
        const siteheadEmail = siteheadRow.querySelector("td:nth-child(2)").textContent.trim();
        const siteheadNumber = siteheadRow.querySelector("td:nth-child(3)").textContent.trim();
        const siteheadlandID = siteheadRow.querySelector("td:nth-child(4)").textContent.trim();
        const siteheadStatus = siteheadRow.querySelector("td:nth-child(5)").textContent.trim() === "Active" ? "0" : "1";

        // Populate the form inputs
        document.getElementById("edit-id").value = siteheadId;
        document.getElementById("edit-name").value = siteheadName;
        document.getElementById("edit-email").value = siteheadEmail;
        document.getElementById("edit-number").value = siteheadNumber;
        document.getElementById("edit-landID").value = siteheadlandID;
        document.getElementById("edit-status").value = siteheadStatus;

        // Show the modal form
        editsiteheadForm.style.display = "block";
    }
});