// Existing code for navbar and theme toggle
const nav_toggler = document.getElementById('nav-toggler');
const nav_items = document.getElementById('nav-items');
const theme_checkbox = document.getElementById('theme_checkbox');
const navbar = document.querySelector('.navbar');
const recent_tab = document.querySelector('#recent-opp-head');
const past_tab = document.querySelector('#past-event-head');

const social_links = document.querySelectorAll('.social-link');
const twitter = document.getElementById('twitter');
const instagram = document.getElementById('instagram');
const linkedin = document.getElementById('linkedin');
const youtube = document.getElementById('youtube');
const social_color = ['white', 'purple', 'green', '#0a66c2', 'red'];

// Modal and button for Login/Signup
const loginSignupBtn = document.getElementById('login-signup-btn');
const loginSignupModal = document.getElementById('login-signup-modal');
const closeModal = document.getElementById('close-modal');
const loginSignupForm = document.getElementById('login-signup-form');
const switchToSignup = document.getElementById('switch-to-signup');
const switchToLogin = document.getElementById('switch-to-login');

// Theme Toggle Event Listener
tdocument.addEventListener("DOMContentLoaded", () => {
  // Check stored theme preference
  const savedTheme = localStorage.getItem('theme');
  const isDarkTheme = savedTheme === 'dark';

  if (isDarkTheme) {
    document.body.classList.add("dark-theme");
    theme_checkbox.checked = true; // Update the checkbox state
    navbar.classList.remove('navbar-dark');
  } else {
    document.body.classList.remove("dark-theme");
    theme_checkbox.checked = false; // Update the checkbox state
    navbar.classList.add('navbar-dark');
  }
});

// Theme Toggle Event Listener
theme_checkbox.addEventListener('click', () => {
  if (theme_checkbox.checked) {
    document.body.classList.add("dark-theme");
    navbar.classList.remove('navbar-dark');
    localStorage.setItem('theme', 'dark'); // Save preference
  } else {
    document.body.classList.remove("dark-theme");
    navbar.classList.add('navbar-dark');
    localStorage.setItem('theme', 'light'); // Save preference
  }
});

// Navbar Toggler Event Listener
nav_toggler.addEventListener('click', () => {
  if (!nav_items.classList.contains('active')) {
    nav_items.classList.add('active');
    nav_items.style.right = '0%';
  } else {
    nav_items.classList.remove('active');
    nav_items.style.right = '-100%';
  }
});

// Typewriter Effect
const texts = ["Hackathon", "Innovation", "Creativity", "Teamwork"];
let currentIndex = 0;
let currentCharIndex = 0;

function typeWriter() {
  const element = document.getElementById('typewriter');
  const currentText = texts[currentIndex];
  if (currentCharIndex < currentText.length) {
    element.textContent += currentText.charAt(currentCharIndex);
    currentCharIndex++;
    setTimeout(typeWriter, 100);
  } else {
    setTimeout(() => {
      currentIndex = (currentIndex + 1) % texts.length;
      currentCharIndex = 0;
      element.textContent = '';
      typeWriter();
    }, 2000);
  }
}

document.addEventListener("DOMContentLoaded", function () {
  typeWriter();
});

// Tab switching functionality for events
recent_tab.addEventListener('click', () => {
  if (!recent_tab.classList.contains('active')) {
    past_tab.classList.remove('active');
    recent_tab.classList.add('active');
    document.querySelector('#upcoming-event-body').classList.add('active');
    document.querySelector('#past-event-body').classList.remove('active');
  }
});

// Social link hover effects
social_links.forEach((social_link, index) => {
  social_link.addEventListener('mouseenter', function () {
    social_link.style.color = social_color[index];
  });
  social_link.addEventListener('mouseleave', function () {
    social_link.style.color = 'darkgray';
  });
});

// Show the modal when the Login/Signup button is clicked
loginSignupBtn.addEventListener('click', function() {
  // Redirect to login.html if the button is clicked
  window.location.href = 'login.html';
});

// Close the modal when the close button is clicked
closeModal.addEventListener('click', function() {
  loginSignupModal.style.display = "none";
});

// Close the modal when clicked outside of it
window.addEventListener('click', function(event) {
  if (event.target === loginSignupModal) {
    loginSignupModal.style.display = "none";
  }
});

// Form submission event listener for Login/Signup
loginSignupForm.addEventListener('submit', function (event) {
  event.preventDefault(); // Prevent form submission

  const email = document.querySelector('input[type="email"]').value;
  const password = document.querySelector('input[type="password"]').value;
  
  // Optionally check for name for signup
  const name = document.querySelector('input[type="text"]').value;

  if (email && password && (name || loginSignupForm.dataset.mode === 'login')) {
    // Handle login or signup logic here
    alert('Form submitted successfully');
    loginSignupModal.style.display = "none"; // Close the modal after submission
  } else {
    alert('Please fill out all fields');
  }
});

// Switch between Login and Signup forms
switchToSignup.addEventListener('click', () => {
  loginSignupForm.dataset.mode = 'signup';
  document.getElementById('signup-section').style.display = 'block';
  document.getElementById('login-section').style.display = 'none';
  switchToSignup.style.display = 'none';
  switchToLogin.style.display = 'inline-block';
});

switchToLogin.addEventListener('click', () => {
  loginSignupForm.dataset.mode = 'login';
  document.getElementById('signup-section').style.display = 'none';
  document.getElementById('login-section').style.display = 'block';
  switchToSignup.style.display = 'inline-block';
  switchToLogin.style.display = 'none';
});
