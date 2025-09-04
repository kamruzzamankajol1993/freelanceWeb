// Sidebar Toggle Functionality
function toggleSidebar() {
  const sidebar = document.getElementById("sidebar");
  const overlay = document.getElementById("sidebarOverlay");

  sidebar.classList.toggle("active");
  overlay.classList.toggle("active");

  // Prevent body scroll when sidebar is open
  if (sidebar.classList.contains("active")) {
    document.body.style.overflow = "hidden";
  } else {
    document.body.style.overflow = "auto";
  }
}

// Close sidebar when clicking outside
document.addEventListener("click", (event) => {
  const sidebar = document.getElementById("sidebar");
  const sidebarToggle = document.querySelector(".sidebar-toggle");
  const overlay = document.getElementById("sidebarOverlay");

  if (
    !sidebar.contains(event.target) &&
    !sidebarToggle.contains(event.target) &&
    sidebar.classList.contains("active")
  ) {
    sidebar.classList.remove("active");
    overlay.classList.remove("active");
    document.body.style.overflow = "auto";
  }
});

// Handle window resize
window.addEventListener("resize", () => {
  const sidebar = document.getElementById("sidebar");
  const overlay = document.getElementById("sidebarOverlay");

  if (window.innerWidth > 768 && sidebar.classList.contains("active")) {
    sidebar.classList.remove("active");
    overlay.classList.remove("active");
    document.body.style.overflow = "auto";
  }
});

// Import Bootstrap Carousel
const bootstrap = window.bootstrap;

// Initialize carousel with custom settings
document.addEventListener("DOMContentLoaded", () => {
  const carousel = new bootstrap.Carousel(
    document.getElementById("heroCarousel"),
    {
      interval: 5000,
      wrap: true,
      pause: "hover",
    }
  );

  // Add smooth scrolling for anchor links
  document.querySelectorAll('a[href^="#"]').forEach((anchor) => {
    anchor.addEventListener("click", function (e) {
      e.preventDefault();
      const target = document.querySelector(this.getAttribute("href"));
      if (target) {
        target.scrollIntoView({
          behavior: "smooth",
          block: "start",
        });
      }
    });
  });
});

// Cart badge refresh using API helper (if available)
function refreshCartBadgeIfPossible() {
  try {
    if (window.PND_API && typeof window.PND_API.refreshCartBadge === 'function') {
      window.PND_API.refreshCartBadge();
    }
  } catch (_) {}
}

// Search functionality
const searchInput = document.querySelector(".search-input");
if (searchInput) {
  searchInput.addEventListener("keypress", function (e) {
    if (e.key === "Enter") {
      const searchTerm = this.value.trim();
      if (searchTerm) {
        console.log("Searching for:", searchTerm);
        // Implement search functionality here
        alert(`Searching for: ${searchTerm}`);
      }
    }
  });
}



// Image Gallery Function
function changeImage(thumbnailContainer, newImageSrc) {
  // Remove active class from all thumbnail containers
  const thumbnails = document.querySelectorAll(".single-img");
  thumbnails.forEach((thumb) => thumb.classList.remove("active"));

  // Add active class to clicked thumbnail container
  thumbnailContainer.classList.add("active");

  // Change main image with fade effect
  const mainImage = document.getElementById("mainImage");
  mainImage.style.opacity = "0.5";

  setTimeout(() => {
    mainImage.src = newImageSrc;
    mainImage.style.opacity = "1";
  }, 150);
}
// Note: Add to cart behavior is implemented per-page via API helper.

// Buy Now Function
function buyNow() {
  alert("Redirecting to checkout...");
}

// Smooth scroll and animations
function initializeAnimations() {
  // Add click events to buttons
  const buyNowBtn = document.querySelector(".btn-buy-now");
  

  // Add hover effects to product images
  const mainImage = document.getElementById("mainImage");
  mainImage.addEventListener("mouseenter", function () {
    this.style.transform = "scale(1.05)";
  });

  mainImage.addEventListener("mouseleave", function () {
    this.style.transform = "scale(1)";
  });
}

// Initialize everything when page loads
document.addEventListener("DOMContentLoaded", function () {
  //startCountdown();
  initializeAnimations();
  refreshCartBadgeIfPossible();

  // Add loading animation
  document.body.style.opacity = "0";
  setTimeout(() => {
    document.body.style.opacity = "1";
  }, 100);
});

// Handle window resize for responsive behavior
window.addEventListener("resize", function () {
  // Adjust layout if needed
  const thumbnails = document.querySelectorAll(".thumbnail-image");
  if (window.innerWidth < 576) {
    thumbnails.forEach((thumb) => {
      thumb.style.height = "60px";
    });
  } else {
    thumbnails.forEach((thumb) => {
      thumb.style.height = "100px";
    });
  }
});

// Add smooth scrolling for better UX
document.querySelectorAll('a[href^="#"]').forEach((anchor) => {
  anchor.addEventListener("click", function (e) {
    e.preventDefault();
    document.querySelector(this.getAttribute("href")).scrollIntoView({
      behavior: "smooth",
    });
  });
});

// Note: Basket page handles rendering via inline script using API helper.
// login modal

document.addEventListener("DOMContentLoaded", () => {
  const accountButtons = document.querySelectorAll(".account-btn");

  accountButtons.forEach((button) => {
    button.addEventListener("click", function () {
      // Remove 'active' class from all buttons
      accountButtons.forEach((btn) => btn.classList.remove("active"));

      // Add 'active' class to the clicked button
      this.classList.add("active");

      // Optional: You can add logic here to change form behavior based on selection
      const selectedAccount = this.dataset.account;
      console.log("Selected account:", selectedAccount);
    });
  });
});

// Profile navigation functionality
function navigateToProfile() {
  // Check if user is logged in (you can implement your own logic here)
  // For now, directly navigate to profile page
  window.location.href = 'profile.html';
}


