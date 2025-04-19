document.addEventListener("DOMContentLoaded", () => {
  // ---------- Sitehead Modals ----------
  const addSiteheadBtn = document.getElementById("add-sitehead-btn");
  const addSiteheadModal = document.getElementById("add-sitehead-form");
  const editSiteheadModal = document.getElementById("edit-sitehead-form");

  if (addSiteheadBtn) {
    addSiteheadBtn.addEventListener("click", () => {
      addSiteheadModal.style.display = "block";
    });
  }

  document.querySelectorAll(".edit-sitehead-btn").forEach((btn) => {
    btn.addEventListener("click", (e) => {
      const row = e.target.closest("tr");
      const id = row.dataset.id;
      const user_id = row.dataset.user_id;
      const land_id = row.dataset.land_id;
      const status = row.dataset.status;

      document.getElementById("edit-id").value = id;
      document.getElementById("edit-user_id").value = user_id;
      document.getElementById("edit-land_id").value = land_id;
      document.getElementById("edit-status").value = status;

      editSiteheadModal.style.display = "block";
    });
  });

  // ---------- Event Modals ----------
  const addEventBtn = document.getElementById("add-event-btn");
  const addEventModal = document.getElementById("add-event-form");
  const editEventModal = document.getElementById("edit-event-form");

  if (addEventBtn) {
    addEventBtn.addEventListener("click", () => {
      addEventModal.style.display = "block";
    });
  }

  document.querySelectorAll(".edit-event-btn").forEach((btn) => {
    btn.addEventListener("click", (e) => {
      const row = e.target.closest("tr");
      const id = row.dataset.id;
      const event_name = row.dataset.event_name;
      const project_id = row.dataset.project_id;
      const date = row.dataset.date;
      const time = row.dataset.time;
      const description = row.dataset.description;
      const worker = row.dataset.worker;
      const status = row.dataset.status;
      const location = row.dataset.location;

      document.getElementById("edit-event-id").value = id;
      document.getElementById("edit-event_name").value = event_name;
      document.getElementById("edit-project_id").value = project_id;
      document.getElementById("edit-date").value = date;
      document.getElementById("edit-time").value = time;
      document.getElementById("edit-description").value = description;
      document.getElementById("edit-worker").value = worker;
      document.getElementById("edit-status").value = status;
      document.getElementById("edit-location").value = location;

      editEventModal.style.display = "block";
    });
  });

  // ---------- Close Modals ----------
  document.querySelectorAll(".close-form").forEach((btn) => {
    btn.addEventListener("click", () => {
      btn.closest(".modal").style.display = "none";
    });
  });

  window.addEventListener("click", (e) => {
    if (e.target.classList.contains("modal")) {
      e.target.style.display = "none";
    }
  });
});
