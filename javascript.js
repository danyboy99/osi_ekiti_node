// You can enhance dropdowns later; current CSS handles hover
// Toggle mobile menu
const menuToggle = document.getElementById("menuToggle");
const navMenu = document.getElementById("navMenu");

menuToggle.addEventListener("click", () => {
  navMenu.classList.toggle("active");
});

// Handle dropdown toggles on click
document.querySelectorAll(".dropdown-toggle").forEach((toggle) => {
  toggle.addEventListener("click", (e) => {
    e.preventDefault();

    const parent = toggle.closest(".dropdown");

    // Close others
    document.querySelectorAll(".dropdown").forEach((drop) => {
      if (drop !== parent) drop.classList.remove("show");
    });

    // Toggle current
    parent.classList.toggle("show");
  });
});

// Close dropdowns on click outside
document.addEventListener("click", (e) => {
  if (!e.target.closest(".dropdown")) {
    document
      .querySelectorAll(".dropdown")
      .forEach((drop) => drop.classList.remove("show"));
  }
});

// Form submission functionality is now handled in individual pages
// This prevents conflicts with page-specific form handlers
