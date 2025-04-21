// projectDetails.js
function openViewModal(contentHTML) {
    const modal = document.getElementById("view-modal");
    const contentContainer = document.getElementById("zone-details-content");
    contentContainer.innerHTML = contentHTML;
    modal.style.display = "block";
  }
  
  function closeViewModal() {
    document.getElementById("view-modal").style.display = "none";
  }
  
  function showZoneDetails(type) {
    let content = "";
  
    if (type === "lands") {
      content = `
        <p><strong>Zone ID:</strong> Z001</p>
        <p><strong>Total Lands:</strong> 15</p>
        <p><strong>Crop Type:</strong> Paddy</p>
        <p><strong>Region:</strong> Eastern Province</p>
      `;
    } else if (type === "workers") {
      content = `
        <p><strong>Total Workers:</strong> 30</p>
        <p><strong>Skilled:</strong> 12</p>
        <p><strong>Unskilled:</strong> 18</p>
        <p><strong>Supervisor:</strong> Mr. Silva</p>
      `;
    }
  
    openViewModal(content);
  }
  
  window.onclick = function (event) {
    const modal = document.getElementById("view-modal");
    if (event.target === modal) {
      closeViewModal();
    }
  };
  