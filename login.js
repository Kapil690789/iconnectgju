// Modal handling code
var modal = document.getElementById("loginModal");
var btn = document.getElementById("login-signup-btn");
var span = document.getElementsByClassName("close")[0];

// When the user clicks the button, open the modal
btn.onclick = function() {
    modal.style.display = "block";
}

// When the user clicks on <span> (x), close the modal
span.onclick = function() {
    modal.style.display = "none";
}

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
    if (event.target == modal) {
        modal.style.display = "none";
    }
}

// Login functionality
const login = async (email, password) => {
    try {
      console.log('Attempting to login with', email, password);  // Debugging line
  
      const response = await fetch('http://localhost:3000/login', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
        },
        body: JSON.stringify({ email, password }),
      });
  
      if (!response.ok) {
        throw new Error(`HTTP error! Status: ${response.status}`);
      }
  
      const data = await response.json();
      console.log('Login Successful:', data);
  
      if (data.success) {
        // Redirect to the main page after successful login
        window.location.href = '/';  // Redirect to the homepage
      } else {
        alert('Login failed! Please check your credentials.');
      }
    } catch (error) {
      console.error('Error logging in:', error);
      alert(`Error logging in: ${error.message}`);  // Show a more user-friendly error message
    }
  };
  
  // Add event listener to the form submit
  document.getElementById('loginForm').addEventListener('submit', function (e) {
    e.preventDefault(); // Prevent the default form submission
    const email = document.getElementById('loginEmail').value;
    const password = document.getElementById('loginPassword').value;
    login(email, password); // Call login function with form values
  });
  