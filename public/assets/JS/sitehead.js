// In sitehead.js
document.addEventListener("DOMContentLoaded", function () {
  // Make entire event card clickable
  document.querySelectorAll(".event-card").forEach((card) => {
    card.style.cursor = "pointer";
    card.addEventListener("click", function (e) {
      // Don't navigate if clicking on a button inside the card
      if (e.target.tagName !== "BUTTON") {
        window.location.href =
          this.dataset.href || this.querySelector("a").href;
      }
    });
  });
});
