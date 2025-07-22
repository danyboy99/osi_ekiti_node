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

// Form submission functionality for registration form
document.addEventListener("DOMContentLoaded", () => {
  // Form submission
  const registrationForm = document.getElementById("registrationForm");
  if (registrationForm) {
    registrationForm.addEventListener("submit", (e) => {
      e.preventDefault();

      // Get form data
      const formData = new FormData(registrationForm);

      // Here you would typically send the data to your server
      console.log("Registration form submitted:", Object.fromEntries(formData));

      // Show success message (you can customize this)
      alert(
        "Registration submitted successfully! We'll review your application and get back to you soon."
      );
    });
  }
});
