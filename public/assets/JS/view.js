function showSection(sectionId) {
	let modalContent = "";

	if (sectionId === "manage-lands-section") {
		modalContent = `
			<div class="modal-card">
				<h2>Lands in the Zone</h2>
				<ul class="modal-list">
					<li>Land ID: 101 – Greenfield A – 50 acres</li>
					<li>Land ID: 102 – Sunrise Plot – 40 acres</li>
					<li>Land ID: 103 – Hilltop Farm – 30 acres</li>
				</ul>
				
			</div>
		`;
	} else if (sectionId === "manage-supervisors-section") {
		modalContent = `
			<div class="modal-card">
				<h2>Workers in the Zone</h2>
				<ul class="modal-list">
					<li>Worker ID: 201 – John Doe – Harvesting</li>
					<li>Worker ID: 202 – Jane Smith – Irrigation</li>
					<li>Worker ID: 203 – Mike Brown – Planting</li>
				</ul>
				
			</div>
		`;
	}

	document.getElementById("modal-body").innerHTML = modalContent;
	document.getElementById("modal-overlay").style.display = "flex";
}

function closeModal() {
	document.getElementById("modal-overlay").style.display = "none";
}
